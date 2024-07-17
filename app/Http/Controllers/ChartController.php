<?php

namespace App\Http\Controllers;

use App\Models\Chart_data;
use Illuminate\Http\Request;
use App\Models\Accountsection;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{


    //total existing and new lives
    public function index1()
    {
        if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
            abort(404, 'Cannot Access');
        }

        $userData = Accountsection::select(DB::raw("COUNT(*) as count"))->whereIn('policy', ['Active', 'Pended'])->where("lives_2022", "New Lives")->whereYear("start_date", date('2022'))->groupBY(DB::raw("Month(start_date)"))->pluck('count');
        $userData1 = Accountsection::select(DB::raw("COUNT(*) as count"))->where('policy', 'Active')->where("lives_2022", "Existing")->whereYear("start_date", date('2022'))->groupBY(DB::raw("Month(start_date)"))->pluck('count');
        $total_newlives = Accountsection::select(DB::raw("COUNT(*) as count"))->where("lives_2022", "New Lives")->whereYear("start_date", date('2022'))->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->whereIn('policy', ['Active', 'Pended'])->pluck('count');
        $total_existing = Accountsection::select(DB::raw("COUNT(*) as count"))->where('policy', 'Active')->where("lives_2022", "Existing")->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->pluck('count');
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
        return view('/Graph/lives_2022', compact('userData', 'userData1', 'total_newlives', 'total_existing', 'userDataAccumulative', 'userDataAccumulative1'));
    }







    //for premium commission
    public function premium_commission()
    {
        if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
            abort(404, 'Cannot Access');
        }

        $sum = DB::table('Accountsection')
            ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
            ->sum('convert_premium_USD');
        $formattedsum = number_format($sum, 2);
        $formattedsum;
        $sum2 = DB::table('Accountsection')
            ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
            ->sum('commission_2022');
        $formattedsum2 = number_format($sum2, 2);
        $formattedsum2;



        $commissions = DB::table('Accountsection')->select(DB::raw('sum(commission_2022) as sum'))->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->groupBY(DB::raw("Month(start_date)"))->get();
        //make the $commissions become Accumulative sum
        $commissionsAccumulative = [];
        $commissionSum = 0;
        foreach ($commissions as $e) {
            $commissionSum += $e->sum;
            //make the  array decimal by two
            $commissionsAccumulative[] = floatval(number_format($commissionSum, 2, '.', ''));
            //because of number_format 2 the float become a string (varchar) so to make it a float you need to use floatval
        }


        $premium = DB::table('Accountsection')->select(DB::raw('sum(convert_premium_USD) as sum'))->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->groupBY(DB::raw("Month(start_date)"))->get();
        //make the $commissions become Accumulative sum
        $premiumAccumulative = [];
        $premiumSum = 0;
        foreach ($premium as $e) {
            $premiumSum += $e->sum;
            //make the  array decimal by two
            $premiumAccumulative[] = floatval(number_format($premiumSum, 2, '.', ''));
            //because of number_format 2 the float become a string (varchar) so to make it a float you need to use floatval

        }
        return view('/Graph/premium_commission', compact('premium', 'commissions', 'sum', 'sum2', 'formattedsum', 'formattedsum2', 'commissionsAccumulative', 'premiumAccumulative'));
    }





    public function source_inquiry()
    {
        if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
            abort(404, 'Cannot Access');
        }

        $source = Accountsection::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
            ->where('lives_2022', 'Existing')
            ->orWhere('lives_2022', 'New Lives')
            ->where('start_date', '>', '2022-01-01')
            ->where('start_date', '<', '2022-12-31')
            ->groupBy(DB::raw("source_inquiry"))
            ->get('count');

        $source_existing = Accountsection::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
            ->where('lives_2022', 'Existing')
            ->where('start_date', '>', '2022-01-01')
            ->where('start_date', '<', '2022-12-31')
            ->groupBy(DB::raw("source_inquiry"))
            ->get('count');

        $source_newlives = Accountsection::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
            ->where('lives_2022', 'New Lives')
            ->where('start_date', '>', '2022-01-01')
            ->where('start_date', '<', '2022-12-31')
            ->groupBy(DB::raw("source_inquiry"))
            ->get('count');


        return view('/Graph/source_inquiry', compact('source', 'source_existing', 'source_newlives'));
    }


    public function insurer()
    {
        if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
            abort(404, 'Cannot Access');
        }

        $insurer = Accountsection::select(DB::raw("COUNT(insurer) as count"), 'insurer')
            ->where('policy', 'Active')
            ->where('start_date', '>', '2022-01-01')
            ->where('start_date', '<', '2022-12-31')
            ->groupBy(DB::raw("insurer"))
            ->get('count');

        return view('Graph.insurer', compact('insurer'));
    }



    public function age()
    {
        $data = DB::table('accountsection')
            ->select(DB::raw("COUNT(age) as count"), 'age')
            ->groupBy('age')
            ->orderBy('age')
            ->get();
        return view('graph.age', compact('data'));
    }
}
