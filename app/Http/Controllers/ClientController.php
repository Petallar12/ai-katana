<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountsection;
use App\Models\Accountsection_2023;

class ClientController extends Controller
{
    
    public function copyClient($id)
    {
        // Retrieve client data from the database
        $client = Accountsection::find($id);
    
        // Create a new record in the other model
        $newClient = new Accountsection_2023;
    
        // Assign the values from the first model to the second model
        $newClient->membership = $client->membership;
        $newClient->full = $client->full;
        $newClient->insurer = $client->insurer;
        $newClient->policy = $client->policy;
    
        // Save the new record
        $newClient->save();
    
        return response()->json([
            'success' => true
        ]);
    }
}

