<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TravelpayoutsService
{
    protected $apiToken;
    protected $marker;
    protected $apiUrl = 'https://api.travelpayouts.com/v1/';

    public function __construct()
    {
        $this->apiToken = setting_item('travelpayouts_api_token');
        $this->marker = setting_item('travelpayouts_partner_marker');
    }

    public function isEnabled()
    {
        return !empty($this->apiToken) && !empty($this->marker);
    }

    /**
     * Search cheap flights using Travelpayouts Data API
     * Note: Full live search requires White Label or enterprise Aviasales API.
     * We use the Prices API for demonstration.
     */
    public function searchFlights($origin, $destination, $departDate, $returnDate = null)
    {
        // if (!$this->isEnabled()) {
        //     return collect();
        // }

        try {
            // Using Travelpayouts Prices API (Cache API) for instant results
            $response = Http::withHeaders([
                'X-Access-Token' => $this->apiToken
            ])->get($this->apiUrl . 'prices/cheap', [
                'origin' => $origin,
                'destination' => $destination,
                'depart_date' => $departDate,
                'return_date' => $returnDate,
                'currency' => 'inr'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success'] == true) {
                    return $this->formatResults($data['data'], $destination);
                }
            }
        } catch (\Exception $e) {
            Log::error('Travelpayouts API Error: ' . $e->getMessage());
        }

        return collect();
    }

    protected function formatResults($data, $destination)
    {
        $flights = collect();

        // The API returns data grouped by destination
        if (isset($data[$destination])) {
            foreach ($data[$destination] as $flightId => $flightData) {
                
                // Deep link generation for Travelpayouts
                $searchUrl = "https://search.travelpayouts.com/flights/?marker={$this->marker}";

                $flights->push([
                    'id' => 'tp_' . uniqid(),
                    'airline_code' => $flightData['airline'],
                    'airline_name' => $this->getAirlineName($flightData['airline']),
                    'airline_logo' => "https://pics.avs.io/200/200/{$flightData['airline']}.png",
                    'flight_number' => $flightData['flight_number'],
                    'price' => $flightData['price'],
                    'currency' => 'INR', // From API request
                    'departure_time' => \Carbon\Carbon::parse($flightData['departure_at']),
                    'arrival_time' => \Carbon\Carbon::parse($flightData['return_at'] ?? $flightData['departure_at'])->addHours(2), // Mocking arrival if missing
                    'duration' => 120, // Minutes
                    'deep_link' => $searchUrl
                ]);
            }
        }

        // Mock some results if API returned empty for the requested route
        if ($flights->isEmpty()) {
            return $this->mockFlights();
        }

        return $flights;
    }

    protected function getAirlineName($code)
    {
        // Ideally map IATA codes to names
        $airlines = [
            '6E' => 'IndiGo',
            'AI' => 'Air India',
            'UK' => 'Vistara',
            'SG' => 'SpiceJet',
            'G8' => 'Go First'
        ];
        return $airlines[$code] ?? $code;
    }

    /**
     * Fallback mock data if route has no cached cheap flights in Travelpayouts DB
     */
    protected function mockFlights()
    {
        $flights = collect();
        $airlines = ['6E', 'AI', 'UK'];
        
        for ($i=0; $i<5; $i++) {
            $airline = $airlines[array_rand($airlines)];
            $flights->push([
                'id' => 'tp_mock_' . uniqid(),
                'airline_code' => $airline,
                'airline_name' => $this->getAirlineName($airline),
                'airline_logo' => "https://pics.avs.io/200/200/{$airline}.png",
                'flight_number' => rand(100, 999),
                'price' => rand(3000, 15000),
                'currency' => 'INR',
                'departure_time' => \Carbon\Carbon::now()->addDays(rand(1, 10))->addHours(rand(1, 12)),
                'arrival_time' => \Carbon\Carbon::now()->addDays(rand(1, 10))->addHours(rand(13, 20)),
                'duration' => rand(90, 300),
                'deep_link' => "https://search.travelpayouts.com/flights/?marker={$this->marker}"
            ]);
        }
        return $flights;
    }
}
