<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use AmrShawky\LaravelCurrency\Facade\Currency;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $converted = '';
        $defaultDate = Carbon::today()->format('Y-m-d');
        // $dd = Currency::rates()->latest()->get();

        // Check if $request->lives is not null, set it to 0 otherwise
        $lives = $request->input('lives');

        $currencyFrom = $request->input('currency_from', ''); // Get the currency_from field, default to an empty string if not provided

        if (!empty($currencyFrom)) {
            $convertedObj = Currency::convert()
                ->from($currencyFrom)
                ->to('USD')
                ->amount($request->input('amount'));
            $converted = $convertedObj->get();
        } else {
            // Handle the case where the currency_from field is not set
            // You may throw an exception, show an error message, or take appropriate action
        }

        $amount = $request->input('amount');
        $currency = $request->input('currency_from');
        $active_premium = $request->input('amount');
        $frequency_premium = $request->input('amount') * $request->input('SecondNumber');
        $converted_amount = $request->input('converted');
        $convert_USD = $request->input('convert_USD');
        $total_commission = $lives*$lives ;

        return view('currency', compact('converted', 'convert_USD', 'lives', 'currency', 'frequency_premium', 'converted_amount','active_premium', 'total_commission'));
    }
 
}
