<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ClaimsController extends Controller
{
  public function fetchClaimsByClientNameFromClaimsDB(Request $request)
    {

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Make GET request to your API endpoint
            $response = $client->get('https://mibportal.com/claims_api/api/claims/fetchByClientName?client_name=' . $request->client_name, [
                'headers' => [
                    'X-Api-Key' => '47cfab61-de6b-4260-8857-a30e738c29c3',
                ],
            ]);

            // Get response body as string
            $body = $response->getBody()->getContents();

            // Convert JSON string to array
            $data = json_decode($body, true);

            // Process the data as needed

            return response()->json($data);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., connection errors)
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return view('claims.index')->with('data', $data);

    }

}
