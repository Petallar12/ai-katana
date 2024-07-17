<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Models\Accountsection_2024;

// use App\Models\Accountsection;
use Illuminate\Support\Facades\DB;

class Dashboard_2024Controller extends Controller
{
    public function users()
    {
        if (!in_array(auth()->user()->role, ['IT admin', 'Encoder', 'Management','Case Officer'])) {
            abort(403, 'Unauthorized action.');
        }
    //NEW LIVES CO //Total Active New Lives
    $newlives_active = Accountsection_2024::where('lives_2024','New Lives')
        ->whereIn('status',['Complete' ,'Incomplete'])
        ->where('insurance_type', 'IPMI')
        ->whereBetween('placement_date',['2024-01-01' , '2024-12-31'])
        ->whereIn('policy', ['Active'])
        ->count();

    $newlives_active_addon = Accountsection_2024::where('lives_2024','New Lives and Existing')
        ->whereIn('status',['Complete' ,'Incomplete'])
        ->where('insurance_type', 'IPMI')
        ->whereBetween('placement_date',['2024-01-01' , '2024-12-31'])
        ->whereIn('policy', ['Active'])
        ->count();    
    //Total Pended
    $pended = Accountsection_2024::where('lives_2024', 'New Lives')
        ->whereIn('insurance_type', ['IPMI'])
        ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
        ->whereIn('policy', ['Pended'])
        ->whereIn('status',['Complete' ,'Incomplete'])
        ->count();

    $lapsed_newlives =Accountsection_2024::where('lives_2024','New Lives')
    ->whereIn('status',['Complete' ,'Incomplete'])
        ->whereIn('insurance_type', ['IPMI'])
        ->whereBetween('placement_date',['2024-01-01' , '2024-12-31'])
        ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])
        ->whereIn('policy', ['Lapsed', 'Suspended'])
        ->count();
        //Total New Lives (New Lives + Pended)
        $newlives  = $newlives_active + $pended + $newlives_active_addon + $lapsed_newlives;
        // + $lapsed_newlives
        //RENEWALS COUNT -->
        
        //Renewals Active
        $renewals_Active = Accountsection_2024::where('policy','Active')
            ->whereIn('insurance_type', ['IPMI'])
            ->where('status', '!=', 'Not Counted')
            ->where('lives_2024','Existing')
            ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
            ->count();

        //Renewals Lapsed After 6 Months
        $renewals_Lapsed = Accountsection_2024::whereIn('policy', ['Lapsed', 'Suspended'])
            ->whereIn('insurance_type', ['IPMI'])
            ->where('status', '!=', 'Not Counted')
            ->where('lives_2024', 'Existing')
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
            ->whereRaw("DATEDIFF(cancelled_date, start_date) >= 180")
            ->count();

        $renewal_newlives = Accountsection_2024::
        where('insurance_type', 'IPMI')
        ->where('status', '!=', 'Not Counted')
        ->where('lives_2024' , 'New Lives and Existing')
        ->whereBetween('placement_date',['2024-01-01' , '2024-12-31'])
        ->whereIn('policy', ['Active'])
        ->count();
        
        //Total Renewal Count
        $renewals = $renewals_Active + $renewals_Lapsed + $renewal_newlives;
        
        //CANCELLATION -->

        //2022 and below   
        // $cancelled_2021_1 = Accountsection_2024::where('policy', 'Lapsed')
        //     ->whereIn('insurance_type', ['IPMI'])
        //     ->whereBetween('cancelled_date', ['2024-01-01', '2024-12-31'])
        //     ->whereNull('start_date')
        //     ->count();  
        // $cancelled_2021_2 = Accountsection_2024::where('policy','Lapsed')
        //     ->whereIn('insurance_type', ['IPMI'])
        //     ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])
        //     ->whereBetween('start_date',['0000-00-00' , '2022-12-31'])
        //     ->count();

        // $cancelled_2021 = $cancelled_2021_1 + $cancelled_2021_2;
        

        
        // $premium_cancelled = Accountsection_2024::where('policy','Lapsed')
        //     ->whereIn('insurance_type', ['IPMI'])
        //     ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])
        //     ->whereBetween('start_date',['0000-00-00' , '2022-12-31'])
        //     ->sum('convert_premium_USD');

        //Cancellations of 2024
        // $cancelled_2024 = Accountsection_2024::where('policy','Lapsed')
        //     ->whereIn('insurance_type', ['IPMI'])
        //     ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])
        //     ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])->count();
        
        //Renewal Cancellation
        $cancelled_renewal = Accountsection_2024::whereIn('policy', ['Lapsed', 'Suspended'])
            ->whereIn('insurance_type', ['IPMI'])
            ->where('status', '!=', 'Not Counted')
            ->whereIn('lives_2024' , ['Existing'])
            ->whereBetween('original_date',['0000-00-00' , '2023-12-31'])
            ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])
            ->count();
            

        //New Lives Cancellation
        $cancelled_newlives = Accountsection_2024::WHERE("lives_2024",'New Lives')->where("insurance_type","IPMI")
        ->where("policy","Lapsed")
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('placement_date',['2024-01-01' , '2024-12-31'])
        ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])
            ->count();    
        
        //Total Cancellations
        $cancelled = $cancelled_renewal + $cancelled_newlives;
        



        
        // $cancelled = Accountsection_2024::where('policy','Lapsed')
        //     ->whereIn('insurance_type', ['IPMI'])
        //     ->whereBetween('cancelled_date',['2024-01-01' , '2024-12-31'])->count();
       





        //NEW LIVES BUFFER COUNT -->
        // $total =  $newlives_active - $cancelled_2024;
        $total =  $newlives - $cancelled;

        


        //Get The Total Premium for 2024
        
        // $premium_1 = DB::table('Accountsection_2024')->where('insurance_type','IPMI')->where('policy', '!=' , 'Transferred')->whereBetween('start_date',['2024-01-01' , '2024-12-31'])->sum('convert_premium_USD');
        // $premium_2 = DB::table('Accountsection_2024')->where('insurance_type','IPMI')->where('policy', '!=' , 'Transferred')->whereBetween('start_date',['2024-01-01' , '2024-12-31'])->sum('convert_premium_USD');
        $premium = Accountsection_2024::where('insurance_type','IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereNotIn('policy', ['Transferred', 'Pended'])
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->sum('convert_premium_USD');  

        $premium_existing = Accountsection_2024::where('insurance_type','IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereNotIn('policy', ['Transferred', 'Pended'])
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->where('lives_2024','Existing')
        ->sum('convert_premium_USD');

        $premium_newlives = Accountsection_2024::where('insurance_type','IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereNotIn('policy', ['Transferred', 'Pended'])
        
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->where('lives_2024','New Lives')
        ->sum('convert_premium_USD');


        $exchangeRateGBP = 0.7872 ;  // Replace with the actual exchange rate
        $exchangeRateSGD = 1.33 ; //Replace with actual exchange rate 
        
        
        $premiumSGD = $premium * $exchangeRateSGD;
        //Get The 2 decimals in Total Premium $premium
        $formattedPremium = number_format($premium, 2);  
        $formattedPremiumSGD = number_format($premiumSGD, 2);
        


        // Get The Total Commissions for 2024 in USD
        $commission_2024 = Accountsection_2024::where('insurance_type', 'IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
            ->sum('commission_2024');

        // Fetch the Exchange Rate (Replace with your exchange rate retrieval mechanism)
        
        // Convert Commission to GBP
        $commissionGBP = $commission_2024 * $exchangeRateGBP;
        $commissionSGD = $commission_2024 * $exchangeRateSGD;
        $premiumSGD = $commission_2024 * $exchangeRateGBP;
        
                

        // Format Commission amounts
        $formattedCommission = number_format($commission_2024, 2);
        $formattedCommissionGBP = number_format($commissionGBP, 2);
        $formattedCommissionSGD = number_format($commissionSGD, 2);




        //total Group Count
     
        $clients_group_count = Accountsection_2024::where(function ($query) {
                    $query->where('lives_2024', 'New Lives')
                        ->where('insurance_type', 'IPMI')
                        ->where('status', '!=', 'Not Counted')
                        ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                        ->where('group_name', '!=', '')
                        ->whereIn('policy', ['Active']);
                })
                ->orWhere(function ($query) {
                    $query->where('policy', 'Active')
                        ->where('insurance_type', 'IPMI')
                        ->where('status', '!=', 'Not Counted')
                        ->where('lives_2024', 'Existing')
                        ->where('group_name', '!=', '')
                        ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
                })
                ->count();


        $individual = Accountsection_2024::where(function ($query) {
            $query->where('lives_2024', 'New Lives')
            ->where('status', '!=', 'Not Counted')
                ->where('insurance_type', 'IPMI')
                ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                 ->where(function ($query) {
        //this $query is to count the null in group_name 
            $query->where('group_name', '')
                ->orWhereNull('group_name');})
                ->whereIn('policy', ['Active']);
        })
        ->orWhere(function ($query) {
            $query->where('policy', 'Active')
                ->where('insurance_type', 'IPMI')
                ->where('status', '!=', 'Not Counted')
                ->where('lives_2024', 'Existing')
                  ->where(function ($query) {
        //this $query is to count the null in group_name 
            $query->where('group_name', '')
                ->orWhereNull('group_name');})
                ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
        })
        ->count();

        

                
        $group_count = Accountsection_2024::select('group_name')
        ->where(function ($query) {
            $query->where('lives_2024', 'New Lives')
                ->where('insurance_type', 'IPMI')
                ->where('status', '!=', 'Not Counted')
                ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                ->whereIn('policy', ['Active']);
        })
        ->orWhere(function ($query) {
            $query->where('policy', 'Active')
            ->where('status', '!=', 'Not Counted')
                ->whereIn('insurance_type', ['IPMI'])
                ->where('lives_2024', 'Existing')
                ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
        })
        ->distinct()
        ->count('group_name');

        //just add $clients_group_count and $individual client with group and individual
        $total_count_group = Accountsection_2024::where("policy", "Active")
        ->where('insurance_type' , 'IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
        ->count();


        //TOTAL NUMBER OF  CLIENTS -->
        // $clients = Accountsection_2024::whereIn('policy', ['Pended','Active'])->whereIn('insurance_type', ['IPMI'])->whereBetween('start_date',['2024-01-01' , '2024-12-31'])->count();


        // $total_members = Accountsection_2024::whereIn('policy', ['Active'])->whereIn('insurance_type', ['IPMI'])->whereBetween('start_date',['2024-01-01' , '2024-12-31'])->count();


        $clients = $newlives + $renewals;
        $total_members = $newlives_active + $renewals_Active;

 


        // blade in view - the placeholder use above inside is their conditions 
        return view('2024.accountsection.dashboard',
         compact('lapsed_newlives','group_count','total_count_group','clients','renewals','total','cancelled',
        'newlives','total_members','premium','formattedPremium','formattedCommission','pended', 'renewals_Active',
        'renewals_Lapsed','newlives_active','clients_group_count','individual','cancelled_newlives','cancelled_renewal',
        'formattedCommissionGBP','formattedCommissionSGD','formattedPremiumSGD', 'premium_newlives','premium_existing','renewal_newlives','newlives_active_addon'));
    }




}