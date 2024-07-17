<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Models\Accountsection;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{

    
    public function users()
    {

        // $clients = Accountsection::where('policy', '<>', 'No Sale')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
        

        
        // placeholder  -  table - condition - field - is equal to data - another condition - field -is equal to data - count
        //Total Active New Lives
        $newlives_active = Accountsection::where('lives_2022','New Lives')
            ->where('status', '!=', 'Not Counted')
            ->wherebetween('start_date', ['2022-01-01', '2022-12-31'])
            // ->where('insurance_type', 'IPMI')
            ->whereBetween('placement_date',['2022-01-01' , '2022-12-31'])
            ->whereIn('policy', ['Active'])
            ->count();

        $newlives_active_addon = Accountsection::where('lives_2022','New Lives and Existing')
            ->where('status', '!=', 'Not Counted')
            ->wherebetween('start_date', ['2022-01-01', '2022-12-31'])
            // ->where('insurance_type', 'IPMI')
            ->whereBetween('placement_date',['2022-01-01' , '2022-12-31'])
            ->whereIn('policy', ['Active'])
            ->count();    
        //Total Pended
        $pended = Accountsection::where('lives_2022','New Lives')
            ->where('status', '!=', 'Not Counted')
            ->wherebetween('start_date', ['2022-01-01', '2022-12-31'])
            // ->whereIn('insurance_type', ['IPMI'])
            ->whereBetween('placement_date',['2022-01-01' , '2022-12-31'])
            ->whereIn('policy', ['Pended'])
            ->count();

        $lapsed_newlives =Accountsection::where('lives_2022','New Lives')
            ->where('status', '!=', 'Not Counted')
            ->wherebetween('start_date', ['2022-01-01', '2022-12-31'])
            // ->whereIn('insurance_type', ['IPMI'])
            ->whereBetween('placement_date',['2022-01-01' , '2022-12-31'])
            ->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])
            ->whereIn('policy', ['Lapsed'])
            ->count();
            //Total New Lives (New Lives + Pended)
            $newlives  = $newlives_active + $pended + $newlives_active_addon + $lapsed_newlives;
            // + $lapsed_newlives
        //renewals
        $renewals_Active = Accountsection::where('policy','Active')->where('lives_2022','Existing')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
        $renewals_Lapsed = Accountsection::where('policy', ['Lapsed'])
        ->where('lives_2022', 'Existing')
        ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
        ->whereRaw("DATEDIFF(cancelled_date, start_date) >= 180")
        ->count();
        $renewals = $renewals_Active + $renewals_Lapsed;
         //No Sale
        $no_sale =  Accountsection::where('policy','No Sale')->where('lives_2022','New Lives')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
        
        //cancelations
        
        $cancelled_2021_1 = Accountsection::where('policy', 'Lapsed')->whereBetween('cancelled_date', ['2022-01-01', '2022-12-31'])->whereNull('start_date')->count();
        $cancelled_2021_2 = Accountsection::where('policy','Lapsed')->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->whereBetween('start_date',['0000-00-00' , '2021-12-31'])->count();
        $cancelled_2021 = $cancelled_2021_1 + $cancelled_2021_2;


        $cancelled_2022 = Accountsection::where('policy','Lapsed')->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
        
        $cancelled = Accountsection::where('policy','Lapsed')->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->count();
       
        //New Lives Buffer Cancellation
        $total =  $newlives_active - $cancelled_2022;


        $total_members = Accountsection::where('policy','Active')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
        //Get The Total Premium for 2022
        $premium = DB::table('Accountsection')->where('policy', '!=' , 'Transferred')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->sum('convert_premium_USD');
        //Get The 2 decimals in Total Premium $premium
        $formattedPremium = number_format($premium, 2);  $formattedPremium;
        //Get The Total Commissions for 2022
        $commission_2022 = DB::table('Accountsection')->where('policy', '!=' , 'Transferred')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->sum('commission_2022');
        //Get The 2 decimals in Total Commission $commission
        $formattedCommission = number_format($commission_2022, 2);  $formattedCommission;

        $clients = $newlives + $cancelled_2022 + $renewals_Active;


        //total Group Count
        $clients_group_count = Accountsection::where('policy','Active')->where('group_name', '!=', '')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
        $individual = Accountsection::where('policy', 'Active')->where(function ($query) {
        //this $query is to count the null in group_name 
        $query->where('group_name', '')->orWhereNull('group_name');})->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->count();
        $group_count = Accountsection::select('group_name')->where('policy', 'Active')->where('group_name', '!=', '')->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->distinct()->count('group_name');

        //just add $clients_group_count and $individual client with group and individual
        $total_count_group = Accountsection::where("policy", "Active")->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->count();

        // blade in view - the placeholder use above inside is their conditions 
        return view('accountsection.dashboard', compact('newlives_active_addon','lapsed_newlives','clients_group_count','individual','group_count','total_count_group','no_sale','clients','renewals','total','cancelled','cancelled_2021','cancelled_2022','newlives','total_members','premium','formattedPremium','formattedCommission','pended', 'renewals_Active','renewals_Lapsed','newlives_active'));
    }




}