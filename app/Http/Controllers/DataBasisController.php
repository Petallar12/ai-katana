<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountsection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DataBasisController extends Controller
{
    // public function close_renewals()
    // {
    //     $case_officers = Accountsection::distinct()->pluck('case_officer');
    //     foreach($case_officers as $case_officer) {
    //         $counts[$case_officer] = Accountsection::select(DB::raw("COUNT(case_officer) as count"))->where("case_officer",$case_officer)->where("policy","!=","No Sale")->where("lives_2022","Existing")->whereYear("start_date",date('2022'))->groupBY(DB::raw("Month(start_date)"))->pluck('count');
    //     }
        
    //     return view('/DataBasis/close_renewals',compact('case_officers','counts'));

    // }



    // public function close_renewals()
    
    // {  if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
    //     abort(404, 'Cannot Access');
    // }
    //     return view('/DataBasis/close_renewals');
    // }


    // public function close_newlives()
    // {  if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
    //     abort(404, 'Cannot Access');
    // }
    //     return view('/DataBasis/close_newlives');
    // }

    //RETURN VIEW FOR NEW LIVES COUNT 2022
    public function monthly_newlives()
    {
        return view('databasis.monthly_newlives');
    }

     //RETURN VIEW FOR RENEWALS COUNT 2022
     public function monthly_renewals()
     {
        return view('databasis.monthly_renewals');
     }
    


    public function cancellation_newlives()
    {  
  
    // Cancellation 2022
    $data = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Lapsed")->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->groupby('insurer')->get();
    $total_newlives = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Lapsed")->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->count();
    $today_data = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Lapsed")->whereDate('created_at', Carbon::today())->groupby('insurer')->get();
    $total_today_data = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Lapsed")->whereDate('created_at', Carbon::today())->count();

    
    $data2 = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'Existing')->where("policy","Lapsed")->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->groupby('insurer')->get();
    $total_renewal = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'Existing')->where("policy","Lapsed")->whereBetween('cancelled_date',['2022-01-01' , '2022-12-31'])->count();

    // New Lives January 4 2022
    $data3 = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Active")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupby('insurer')->get();
    $total_data3 = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Active")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();
    $today_data3 = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Active")->whereDate('created_at', Carbon::today())->groupby('insurer')->get();
    $total_today_data3 = Accountsection::select('insurer' , DB::raw("COUNT(lives_2022) as lives_2022"))->WHERE("lives_2022",'New Lives')->where("policy","Active")->whereDate('created_at', Carbon::today())->count();


    //source of inquiry 2022 (newlives)
    $source_inquiry = Accountsection::select('source_inquiry' , DB::raw("source_inquiry"))->where("policy","Active")->where("lives_2022","New Lives")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupby('source_inquiry')->get();
    $case_closed = Accountsection::select("case_closed")->distinct()->where("lives_2022","New Lives")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->orderby('case_closed')->get();
    $accountsection = Accountsection::select(['source_inquiry', 'case_closed', DB::raw("COUNT(source_inquiry) AS count")])->where("policy", "Active")->where("lives_2022", "New Lives")->whereBetween('start_date', ['2022-01-01', '2022-12-31'])->groupBy('case_closed', 'source_inquiry')->get();
    
   


    
    //source of inquiry 2022 (renewals)
    $source_inquiry2 = Accountsection::select('source_inquiry' , DB::raw("source_inquiry"))->where("lives_2022","Existing")->where("policy",'Active')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupby('source_inquiry')->get();
    $case_officer_2022 = Accountsection::select("case_officer_2022")->distinct()->where("lives_2022","Existing")->where("policy",'Active')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->orderby('case_officer_2022')->get();
    $accountsection2 = Accountsection::select(['source_inquiry' , 'case_officer_2022', DB::raw("Count(source_inquiry) as count")])->where("lives_2022",'Existing')->where("policy",'Active')->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupby('case_officer_2022','source_inquiry')->get();



    //Encoder Encoded 
    $encoded = Accountsection::select('encoded_by' , DB::raw("COUNT(created_at) as count"))->where("policy" ,"<>","No Sale")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->groupby('encoded_by')->get();
    $total_encoded = Accountsection::select('encoded_by' , DB::raw("COUNT(created_at) as created_at"))->where("policy" ,"<>","No Sale")->whereBetween('start_date',['2022-01-01' , '2022-12-31'])->count();





    //Encoder Encoded For Todays Video
    $encoded_today = Accountsection::select('encoded_by' , DB::raw("COUNT(updated_at) as count"))->whereDate('updated_at', Carbon::today())->groupby('encoded_by')->get();
    $total_encoded_today = Accountsection::select('encoded_by' , DB::raw("COUNT(updated_at) as created_at"))->whereDate('updated_at', Carbon::today())->count();



      
    
    // Group Count and Individual 2022
    $group_name = Accountsection::select(
        DB::raw("COALESCE(group_name, '') as group_name"), 
        DB::raw("COUNT(lives_2022) as lives_2022")
    )
    ->where("policy", "Active")
    ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
    ->groupBy(DB::raw("COALESCE(group_name, '')"))
    ->get();
$count_group_name = Accountsection::where("policy", "Active")
    ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
    ->count();

    foreach ($group_name as $row) {
        if (empty($row->group_name) || is_null($row->group_name)) {
            $row->group_name = '1 - Individual Counts';
        }
    }


    
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives
//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives//  zsource of inquiry not eaqual to total new lives




    return view('/DataBasis/cancellation_newlives', ['data' => $data , 'data2' => $data2, 'total_newlives' => $total_newlives, 'total_renewal' => $total_renewal, 'data3' => $data3  , 
     'total_data3' => $total_data3, 'today_data3' => $today_data3, 'total_today_data3' =>$total_today_data3 , 'today_data' => $today_data  , 'total_today_data' => $total_today_data ,
      'source_inquiry' => $source_inquiry , 'accountsection' =>$accountsection,'case_closed'=>$case_closed, 'source_inquiry2' => $source_inquiry2 , 'accountsection2' =>$accountsection2,'case_officer_2022' => $case_officer_2022,
      'encoded' =>$encoded, 'total_encoded' => $total_encoded,
    'encoded_today'=>$encoded_today, 'total_encoded_today' => $total_encoded_today, 'group_name'=>$group_name,'count_group_name'=>$count_group_name]);
    }



    
    }

    