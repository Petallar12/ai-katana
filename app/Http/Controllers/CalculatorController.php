<?php

namespace App\Http\Controllers;
use App\Models\Calculator;
use Illuminate\Http\Request;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Carbon\Carbon;




    class CalculatorController extends Controller
    {

    public function bupa()
    {
        
        return view('calculator.bupa');
    }
   
    public function bupa_compute(Request $request)
    {   
        $lives = $_POST['lives'];
        $currency = $_POST['currency'];
        $active_premium = $request->FirstNumber ;
        $frequency_premium = $request->FirstNumber ;
        $convert_usd = $request->FirstNumber * $currency;
        $total_commission = $request->FirstNumber * $currency * $lives;

        return view('calculator.bupa')->with('active_premium', $active_premium)->with('first_number', $request->FirstNumber)->with('frequency_premium', $frequency_premium)->with('convert_usd',$convert_usd) ->with('total_commission',$total_commission);
    }

    // public function aetna()
    // {
        
    //     return view('calculator.aetna');
    // }
    // public function aetna_compute(Request $request)
    // {   
    //     $lives = $_POST['lives'];
    //     $currency = $_POST['currency'];
    //     $active_premium = $request->FirstNumber ;
    //     $frequency_premium = $request->FirstNumber ;
    //     $convert_usd = $request->FirstNumber * $currency;
    //     $total_commission = $request->FirstNumber * $currency * $lives;

    //     return view('calculator.aetna')->with('active_premium', $active_premium)->with('first_number', $request->FirstNumber)->with('frequency_premium', $frequency_premium)->with('convert_usd',$convert_usd) ->with('total_commission',$total_commission);
    // }

    // public function allianz()
    // {
        
    //     return view('calculator.allianz');
    // }

    // public function allianz_compute(Request $request)
    // {   
    //     $lives = $_POST['lives'];
    //     $currency = $_POST['currency'];
    //     $active_premium = $request->FirstNumber ;
    //     $frequency_premium = $request->FirstNumber ;
    //     $convert_usd = $request->FirstNumber * $currency;
    //     $total_commission = $request->FirstNumber * $currency * $lives;

    //     return view('calculator.allianz')->with('active_premium', $active_premium)->with('first_number', $request->FirstNumber)->with('frequency_premium', $frequency_premium)->with('convert_usd',$convert_usd) ->with('total_commission',$total_commission);
    // }

    // public function ema()
    // {
       
    //     return view('calculator.ema');
    // }

    // public function ema_compute(Request $request)
    // {   
    //     $lives = $_POST['lives'];
    //     $currency = $_POST['currency'];
    //     $active_premium = $request->FirstNumber ;
    //     $frequency_premium = $request->FirstNumber ;
    //     $convert_usd = $request->FirstNumber * $currency;
    //     $total_commission = $request->FirstNumber * $currency * $lives;

    //     return view('calculator.ema')->with('active_premium', $active_premium)->with('first_number', $request->FirstNumber)->with('frequency_premium', $frequency_premium)->with('convert_usd',$convert_usd) ->with('total_commission',$total_commission);
    // } 



    //Values of currency are updated online 
    // public function bupa(Request $request)
    // {
    //     $converted = '';
    //     $defaultDate = Carbon::today()->format('Y-m-d');
    //     // $dd = Currency::rates()->latest()->get();

    //     // Check if $request->lives is not null, set it to 0 otherwise
    //     $lives = $request->input('lives');

    //     $currencyFrom = $request->input('currency_from', ''); // Get the currency_from field, default to an empty string if not provided

    //     if (!empty($currencyFrom)) {
    //         $convertedObj = Currency::convert()
    //             ->from($currencyFrom)
    //             ->to('USD')
    //             ->amount($request->input('amount'));
    //         $converted = $convertedObj->get();
    //     } else {
            // Handle the case where the currency_from field is not set
            // You may throw an exception, show an error message, or take appropriate action
    //     }

    //     $amount = $request->input('amount');
    //     $currency = $request->input('currency_from');
    //     $active_premium = $request->input('amount');
    //     $frequency_premium = $request->input('amount') * $request->input('SecondNumber');
    //     $converted_amount = $request->input('converted');
    //     $convert_USD = $request->input('convert_USD');
    //     $total_commission = $lives*$lives ;

    //     return view('calculator.bupa', compact('converted', 'convert_USD', 'lives', 'currency', 'frequency_premium', 'converted_amount','active_premium', 'total_commission'));
    // }


    public function aetna(Request $request)
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

        return view('calculator.aetna', compact('converted', 'convert_USD', 'lives', 'currency', 'frequency_premium', 'converted_amount','active_premium', 'total_commission'));
    }

    public function allianz(Request $request)
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

        return view('calculator.allianz', compact('converted', 'convert_USD', 'lives', 'currency', 'frequency_premium', 'converted_amount','active_premium', 'total_commission'));
    }
    public function ema(Request $request)
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

        return view('calculator.ema', compact('converted', 'convert_USD', 'lives', 'currency', 'frequency_premium', 'converted_amount','active_premium', 'total_commission'));
    }
   





























    


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}