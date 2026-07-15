<?php
namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Illuminate\Support\Facades\Log;

class RazorpayGateway extends BaseGateway
{
    public $name = 'Razorpay';
    protected $id = 'razorpay';

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Razorpay?')
            ],
            [
                'type'       => 'input',
                'id'         => 'name',
                'label'      => __('Custom Name'),
                'std'        => __("Razorpay"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'      => 'input',
                'id'        => 'razorpay_key_id',
                'label'     => __('Razorpay Key ID'),
            ],
            [
                'type'      => 'input',
                'id'        => 'razorpay_key_secret',
                'label'     => __('Razorpay Key Secret'),
            ]
        ];
    }

    public function process(Request $request, $booking, $service)
    {
        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::CANCELLED
        ])) {
            throw new Exception(__("Booking status does need to be paid"));
        }
        if (!$booking->pay_now) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }

        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $payment->save();

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->save();

        $key_id = $this->getOption('razorpay_key_id');
        $key_secret = $this->getOption('razorpay_key_secret');
        
        $currency = strtoupper(setting_item('currency_main') ?? 'INR');
        $amount = (int) ($booking->pay_now * 100); // Amount in smallest currency unit

        // Create Payment Link via cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $customer_name = trim($booking->first_name . ' ' . $booking->last_name);
        $customer_email = $booking->email;
        $customer_contact = $booking->phone;

        $post = [
            "amount" => $amount,
            "currency" => $currency,
            "accept_partial" => false,
            "reference_id" => (string)$booking->code,
            "description" => "Payment for Booking #" . $booking->id,
            "customer" => [
                "name" => $customer_name ? $customer_name : 'Customer',
                "email" => $customer_email ? $customer_email : 'customer@example.com',
                "contact" => $customer_contact ? $customer_contact : '+919999999999'
            ],
            "notify" => [
                "sms" => false,
                "email" => false
            ],
            "reminder_enable" => false,
            "callback_url" => $this->getReturnUrl() . '?c=' . $booking->code,
            "callback_method" => "get"
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        
        $headers = [];
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Error: ' . curl_error($ch));
        }
        curl_close($ch);

        $response = json_decode($result, true);

        if (isset($response['short_url'])) {
            // redirect to offsite payment gateway
            response()->json([
                'url' => $response['short_url']
            ])->send();
        } else {
            throw new Exception('Razorpay Error: ' . ($response['error']['description'] ?? 'Unknown Error'));
        }
    }

    public function confirmPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {

            $razorpay_payment_id = $request->query('razorpay_payment_id');
            $razorpay_payment_link_id = $request->query('razorpay_payment_link_id');
            $razorpay_payment_link_reference_id = $request->query('razorpay_payment_link_reference_id');
            $razorpay_payment_link_status = $request->query('razorpay_payment_link_status');
            $razorpay_signature = $request->query('razorpay_signature');

            $key_secret = $this->getOption('razorpay_key_secret');

            // Verify Signature
            // payload = payment_link_id + '|' + payment_link_reference_id + '|' + payment_link_status + '|' + payment_id
            $payload = $razorpay_payment_link_id . '|' . $razorpay_payment_link_reference_id . '|' . $razorpay_payment_link_status . '|' . $razorpay_payment_id;
            $expected_signature = hash_hmac('sha256', $payload, $key_secret);

            if (hash_equals($expected_signature, $razorpay_signature)) {
                if ($razorpay_payment_link_status === 'paid') {
                    $payment = $booking->payment;
                    if ($payment) {
                        $payment->status = 'completed';
                        $payment->logs = \GuzzleHttp\json_encode($request->query());
                        $payment->save();
                    }
                    try {
                        $booking->paid += (float)$booking->pay_now;
                        $booking->markAsPaid();
                    } catch (\Swift_TransportException $e) {
                        Log::warning($e->getMessage());
                    }
                    return redirect($booking->getDetailUrl())->with("success", __("You payment has been processed successfully"));
                }
            }

            // Failed signature or not paid
            $payment = $booking->payment;
            if ($payment) {
                $payment->status = 'fail';
                $payment->logs = \GuzzleHttp\json_encode($request->query());
                $payment->save();
            }
            try {
                $booking->markAsPaymentFailed();
            } catch (\Swift_TransportException $e) {
                Log::warning($e->getMessage());
            }
            return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
        }
        if (!empty($booking)) {
            return redirect($booking->getDetailUrl(false));
        } else {
            return redirect(url('/'));
        }
    }

    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {
            $payment = $booking->payment;
            if ($payment) {
                $payment->status = 'cancel';
                $payment->logs = \GuzzleHttp\json_encode([
                    'customer_cancel' => 1
                ]);
                $payment->save();

                // Refund without check status
                $booking->markAsCancel();
                return redirect($booking->getDetailUrl())->with("error", __("You cancelled the payment"));
            }
            return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
        }
        return redirect(url('/'));
    }
}
