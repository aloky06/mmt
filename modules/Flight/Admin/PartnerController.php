<?php

namespace Modules\Flight\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Flight\Models\Partner;
use Modules\Flight\Models\Commission;
use Modules\Flight\Models\PayoutRequest;

class PartnerController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu(route('flight.admin.index'));
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->checkPermission('flight_manage');
        $query = Partner::query();
        if ($request->query('s')) {
            $query->where('name', 'LIKE', '%' . $request->query('s') . '%');
        }
        $rows = $query->orderBy('id', 'desc')->paginate(20);
        $page_title = 'Affiliate Partners';
        return view('Flight::admin.partner.index', compact('rows', 'page_title'));
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('flight_manage');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Please select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if ($action == 'delete') {
            foreach ($ids as $id) {
                Partner::where('id', $id)->delete();
            }
        } else {
            foreach ($ids as $id) {
                Partner::where('id', $id)->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }

    public function payouts(Request $request)
    {
        $this->checkPermission('flight_manage');
        $query = PayoutRequest::with('partner');
        if ($request->query('status')) {
            $query->where('status', $request->query('status'));
        }
        $rows = $query->orderBy('id', 'desc')->paginate(20);
        $page_title = 'Payout Requests';
        return view('Flight::admin.partner.payouts', compact('rows', 'page_title'));
    }

    public function payoutBulkEdit(Request $request)
    {
        $this->checkPermission('flight_manage');
        $ids = $request->input('ids');
        $action = $request->input('action');
        
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Please select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        
        foreach ($ids as $id) {
            $payout = PayoutRequest::find($id);
            if ($payout) {
                $payout->status = $action;
                if ($action == 'completed') {
                    $payout->processed_at = now();
                    // Mark pending commissions as paid for this partner
                    Commission::where('partner_id', $payout->partner_id)
                        ->where('status', 'confirmed')
                        ->update(['status' => 'paid', 'paid_at' => now()]);
                }
                $payout->save();
            }
        }
        
        return redirect()->back()->with('success', __('Update success!'));
    }
}
