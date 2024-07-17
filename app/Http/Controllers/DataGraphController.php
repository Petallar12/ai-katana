<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Accountsection_2023;
use Illuminate\Support\Facades\Storage;

class DataGraphController extends Controller
{
    



// Premium (premium_commission.blade.php)
    public function index()
            {
            $query = Accountsection_2023::query();    
            $accountsection_2023 = $query->whereNotNull('convert_premium_USD')
                            ->where('convert_premium_USD', '!=', '')
                            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
                            ->get();

            return view('2023.2023datagraph.TotalPremium', ['accountsection_2023' => $accountsection_2023]);
            }


// commission (premium_commission.blade.php)
            public function total_commission()
            {
            $query = Accountsection_2023::query();    
            $accountsection_2023 = $query->whereNotNull('commission_2023')
                            ->where('commission_2023', '!=', '')
                            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
                            ->get();

            return view('2023.2023datagraph.totalcommission', ['accountsection_2023' => $accountsection_2023]);
            }

            public function show($id)
            {
                // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
                //     abort(404, 'Cannot Access');
                // }
                $accountsection_2023 = Accountsection_2023::find($id);
                return view('2023.2023datagraph.show')->with('accountsection_2023', $accountsection_2023);
            }

}