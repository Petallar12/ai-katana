<?php

namespace App\Http\Controllers;

use App\Models\Chart_data;
use Illuminate\Http\Request;
use App\Models\Accountsection;
use Illuminate\Support\Facades\DB;

class GraphDashboardController extends Controller
{


    //total existing and new lives
    public function index1(){
        // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
        //     abort(404, 'Cannot Access');
        // }

        $userData = Accountsection::select(DB::raw("COUNT(*) as count"))->whereIn('policy', ['Active', 'Pended'])->where("lives_2022","New Lives")->whereYear("start_date",date('2022'))->groupBY(DB::raw("Month(start_date)"))->pluck('count');
        $userData1 = Accountsection::select(DB::raw("COUNT(*) as count"))->where('policy','Active')->where("lives_2022","Existing")->whereYear("start_date",date('2022'))->groupBY(DB::raw("Month(start_date)"))->pluck('count');
        $total_newlives = Accountsection::select(DB::raw("COUNT(*) as count"))->whereIn('policy', ['Active', 'Pended'])->where("lives_2022","New Lives")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->pluck('count');
        $total_existing = Accountsection::select(DB::raw("COUNT(*) as count"))->where('policy','Active')->where("lives_2022","Existing")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->pluck('count');
        

        $userDataAccumulative = [];
        $currentSum = 0;
        foreach ($userData as $e) {
            $userDataAccumulative[] = $currentSum + $e;

            $currentSum = $currentSum + $e;
        }

        $userDataAccumulative1 = [];
        $currentSum = 0;
        foreach ($userData1 as $e) {
            $userDataAccumulative1[] = $currentSum + $e;

            $currentSum = $currentSum + $e;
        }

        return view('/GraphDashboard/lives_2022',compact('userData','userData1','total_newlives','total_existing', 'userDataAccumulative' , 'userDataAccumulative1'));
    }



    //for premium commission
    public function premium_commission()
    {
        // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
        //     abort(404, 'Cannot Access');
        // }
        
        $sum = DB::table('Accountsection') 
          ->whereBetween('start_date',['2022-01-01' , '2022-12-31'])
          ->sum('convert_premium_USD');
          $formattedsum = number_format($sum, 2);  $formattedsum;
          $sum2 = DB::table('Accountsection') 
          ->whereBetween('start_date',['2022-01-01' , '2022-12-31'])
          ->sum('commission_2022');
          $formattedsum2 = number_format($sum2, 2);  $formattedsum2;

        
        
        $commissions = DB::table('Accountsection')->select(DB::raw('sum(commission_2022) as sum'))->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupBY(DB::raw("Month(start_date)"))->get();       

        $commissionsAccumulative = [];
        $commissionSum = 0;
        foreach ($commissions as $e) {
            $commissionSum += $e->sum;
            $commissionsAccumulative[] = floatval(number_format($commissionSum, 2, '.', ''));
        }


        $premium = DB::table('Accountsection')->select(DB::raw('sum(convert_premium_USD) as sum'))->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupBY(DB::raw("Month(start_date)"))->get();
        $premiumAccumulative = [];
        $premiumSum = 0;
        foreach ($premium as $e) {
            $premiumSum += $e->sum;
            $premiumAccumulative[] = floatval(number_format($premiumSum, 2, '.', ''));
        }
        return view('/GraphDashboard/premium_commission', compact('premium','commissions','sum','sum2','formattedsum','formattedsum2','commissionsAccumulative','premiumAccumulative'));

    }


    public function source_inquiry()
    {
        // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
        //     abort(404, 'Cannot Access');
        // }
    
       $source = Accountsection::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
        ->where('policy', 'Active')
        ->where('lives_2022', 'New Lives')
        ->whereBetween('start_date',['2022-01-01' , '2022-12-31'])
        ->groupBy(DB::raw("source_inquiry"))
        ->get('count');
        

        $array = Accountsection::select('source_inquiry')
        ->where('policy', 'Active')
        ->where('lives_2022', 'New Lives')
        ->whereBetween('start_date',['2022-01-01' , '2022-12-31'])
        ->groupBy('source_inquiry')
        ->pluck('source_inquiry')
        ->toArray();


        return view('/GraphDashboard/source_inquiry', compact('source','array'));
        
    }

    public function country()
    {
        // if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
        //     abort(404, 'Cannot Access');
        // }
    
        $source = Accountsection::select(DB::raw("COUNT(country_residence) as count"), 'country_residence')
            ->where('policy', 'Active')
            ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
            ->groupBy(DB::raw("country_residence"))
            ->get();
    
        $total_count = $source->sum('count');
    
        $data = $source->map(function ($item) use ($total_count) {
            $percentage = round($item->count / $total_count * 100, 2);
            return [            'name' => $item->country_residence,            'count' => $item->count,            'percentage' => $percentage,        ];
        });
    
        return view('/GraphDashboard/country', compact('data'));
    }
   
    
    public function insurer()
    {
        // if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
        //     abort(404, 'Cannot Access');
        // }
    
        $source = Accountsection::select(DB::raw("COUNT(insurer) as count"), 'insurer')
            ->where('policy', 'Active')
            ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
            ->groupBy(DB::raw("insurer"))
            ->get();
    
        $total_count = $source->sum('count');
    
        $data = $source->map(function ($item) use ($total_count) {
            $percentage = round($item->count / $total_count * 100, 2);
            return [            'name' => $item->insurer,            'count' => $item->count,            'percentage' => $percentage,        ];
        });
    
        return view('/GraphDashboard/insurer', compact('data'));
    }

    

    public function age()
    {
        // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
        //     abort(404, 'Cannot Access');
        // }
    
        $source = Accountsection::select(DB::raw("COUNT(age) as count"), DB::raw("CAST(age AS UNSIGNED) as age_int"))
        ->where('policy', 'Active')
        ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
        ->groupBy('age_int')
        ->orderBy('age_int', 'asc')
        ->get('count', 'age_int');

        $array = Accountsection::select('age')
        ->where('policy', 'Active')        
        ->whereBetween('start_date',['2022-01-01' , '2022-12-31'])
        ->groupBy('age')
        ->orderByRaw('CAST(age AS SIGNED)')
        ->pluck('age')
        ->toArray();


        return view('/GraphDashboard/age', compact('source','array'));
        
    }


    public function country_premium()
{
    $source = Accountsection::select(DB::raw("SUM(convert_premium_USD) as premium_sum"), 'country_residence')
        
        ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
        ->groupBy(DB::raw("country_residence"))
        ->get();

    $total_sum = $source->sum('premium_sum');

    $data = $source->map(function ($item) use ($total_sum) {
        return [
            'name' => $item->country_residence,
            'premium_sum' => $item->premium_sum,
            'percentage' => round($item->premium_sum / $total_sum * 100, 2),
        ];
    });
    $source_total = Accountsection::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))
        
        ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
        
        ->get();

    return view('/GraphDashboard/country_premium', compact('data','source_total'));
}

    
    
    
    
}
