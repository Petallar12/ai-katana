<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Accountsection;
use Illuminate\Support\Facades\DB;
use App\Models\Accountsection_2023;
use App\Models\Accountsection;
class GraphDashboard_2023Controller extends Controller
{
      //total existing and new lives
      public function index1(){
        $userData = Accountsection_2023::select(DB::raw("COUNT(*) as count"))
        ->whereIn('policy',['Active' , 'Lapsed', 'Pended'])
        ->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
        ->where('status', '!=', 'Not Counted')
        ->where('insurance_type' , 'IPMI')
        ->whereYear("placement_date",['2023-01-01' , '2023-12-31'])
        ->groupBY(DB::raw("Month(placement_date)"))
        ->pluck('count');

        

        $userData1 = Accountsection_2023::select(DB::raw("COUNT(*) as count"))
        ->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
        ->where('status', '!=', 'Not Counted')
        ->where('insurance_type' , 'IPMI')
        ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->where('policy', 'Active')
                    ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
            })->orWhere(function ($query) {
                $query->whereIn('policy', ['Lapsed','Active'])
                    ->whereRaw('DATEDIFF(cancelled_date, start_date) >= 180');
            });
        })
        ->groupBY(DB::raw("Month(start_date)"))
        ->pluck('count');

        $total_newlives = Accountsection_2023::select(DB::raw("COUNT(*) as count"))
        ->whereIn('policy',['Active' , 'Pended', 'Lapsed'])
        ->where('insurance_type' , 'IPMI')
        ->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
        ->where('status', '!=', 'Not Counted')
        ->whereYear("placement_date",['2023-01-01' , '2023-12-31'])
        ->pluck('count');

        
        $total_existing = Accountsection_2023::select(DB::raw("COUNT(*) as count"))
        ->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
        ->where('status', '!=', 'Not Counted')
        ->where('insurance_type' , 'IPMI')
        ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->where('policy', 'Active')
                    ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
            })->orWhere(function ($query) {
                $query->whereIn('policy', ['Lapsed','Active'])
                    ->whereRaw('DATEDIFF(cancelled_date, start_date) >= 180');
            });
        })
        ->pluck('count');
        

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

        return view('/2023/GraphDashboard/lives_2023',compact('userData','userData1','total_newlives','total_existing', 'userDataAccumulative' , 'userDataAccumulative1'));
    }



        //for premium commission
        public function premium_commission()
        {
            $sum = Accountsection_2023::whereNotIn('policy', ['Transferred', 'Pended'])
              ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('convert_premium_USD');
              $formattedsum = number_format($sum, 2);  $formattedsum;
              $sum2 = Accountsection_2023::where('policy','!=','Transferred')
              ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('commission_2023');
              $formattedsum2 = number_format($sum2, 2);  $formattedsum2;
              
            $commissions = Accountsection_2023::select(DB::raw('sum(commission_2023) as sum'))  
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->where('status', '!=', 'Not Counted')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('insurance_type' , 'IPMI')
            ->groupBY(DB::raw("Month(start_date)"))
            ->get();       

            $commissionsAccumulative = [];
            $commissionSum = 0;
            foreach ($commissions as $e) {
                $commissionSum += $e->sum;
                $commissionsAccumulative[] = floatval(number_format($commissionSum, 2, '.', ''));
            }
    
    
            $premium = Accountsection_2023::select(DB::raw('sum(convert_premium_USD) as sum'))
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->where('status', '!=', 'Not Counted')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('insurance_type' , 'IPMI')
            ->groupBY(DB::raw("Month(start_date)"))
            ->get();
            
            
            
            $premiumAccumulative = [];
            $premiumSum = 0;
            foreach ($premium as $e) {
                $premiumSum += $e->sum;
                $premiumAccumulative[] = floatval(number_format($premiumSum, 2, '.', ''));
            }
    
            //This Code is use to make an Array that can bypass the blank month example is January Feb march april July, make may june still blank
            $array = Accountsection_2023::select(DB::raw("MONTHNAME(start_date) as month"))
            
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->where('status', '!=', 'Not Counted')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('insurance_type' , 'IPMI')
            ->groupBy('month')
            ->orderByRaw("MONTH(start_date)")
            ->pluck('month')
            ->toArray();
            
    
    
            return view('/2023/GraphDashboard/premium_commission', compact('array','premium','commissions','sum','sum2','formattedsum','formattedsum2','commissionsAccumulative','premiumAccumulative'));
    
        }


        public function premium_commission_normal()
        {
            $sum = Accountsection_2023::whereNotIn('policy', ['Transferred', 'Pended'])
              ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('convert_premium_USD');
              $formattedsum = number_format($sum, 2);  $formattedsum;
              $sum2 = Accountsection_2023::whereNotIn('policy', ['Transferred', 'Pended'])
              ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('commission_2023');
              $formattedsum2 = number_format($sum2, 2);  $formattedsum2;

              $premium = Accountsection_2023::select(DB::raw("sum(convert_premium_USD) as sum"))
              ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->whereNotIn('policy', ['Transferred', 'Pended'])
              ->where('insurance_type' , 'IPMI')
              ->groupBY(DB::raw("Month(start_date)"))
              ->pluck('sum');
  
              $commissions = Accountsection_2023::select(DB::raw("sum(commission_2023) as sum"))
              ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->whereNotIn('policy', ['Transferred', 'Pended'])
              ->where('insurance_type' , 'IPMI')
              ->groupBY(DB::raw("Month(start_date)"))
              ->pluck('sum');
  
            
           
        return view('/2023/GraphDashboard/premium_commission_normal',compact('premium','commissions','sum','sum2','formattedsum','formattedsum2',));
    }

        //new lives source of inquiry
        public function source_inquiry()
        {
            // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
            //     abort(404, 'Cannot Access');
            // }
        
        //    $source = Accountsection_2023::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
        //    ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
        //    ->whereIn('policy', ['Active', 'Pended'])
        //    ->where("insurance_type", "IPMI")
        //    ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
        //     ->groupBy('source_inquiry')
        //     ->havingRaw('COUNT(source_inquiry) > 0')
        //     ->get('count');

        $source = Accountsection_2023::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
            ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
            ->where('status', '!=', 'Not Counted')
            ->where("insurance_type", "IPMI")
            ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
            ->where(function ($query) {
            $query->whereIn('policy', ['Active', 'Pended'])
                ->orWhere(function ($query) {
            $query->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                ->whereIn('policy', ['Lapsed']);
            });
            })
            ->groupBy('source_inquiry')
            ->havingRaw('COUNT(source_inquiry) > 0')
            ->get('count');

    
            $array = Accountsection_2023::select('source_inquiry')
            ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
            ->where('status', '!=', 'Not Counted')
            ->where("insurance_type", "IPMI")
            ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
            ->where(function ($query) {
            $query->whereIn('policy', ['Active', 'Pended'])
                ->orWhere(function ($query) {
            $query->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                ->whereIn('policy', ['Lapsed']);
            });
            })
            ->groupBy('source_inquiry')
            //to remove the 0 in y axis
            ->havingRaw('COUNT(source_inquiry) > 0')
            ->pluck('source_inquiry')
            ->toArray();
            
            return view('/2023/GraphDashboard/source_inquiry', compact('source','array'));
            
        }

        //existing source of inquiry
        public function source_inquiry_existing()
        {
            
            $data = Accountsection_2023::select(DB::raw("COUNT(*) as count"), 'source_inquiry')            
            ->where('policy', 'Active')      
            ->where('insurance_type' , 'IPMI')  
            ->Where('lives_2023', 'Existing')
            ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
                ->groupBy('source_inquiry')
                ->get();
    
            // Prepare the data for the graph
            $categories = $data->pluck('source_inquiry');
            $count = $data->pluck('count');
    
            // Render the graph
            return view('/2023/GraphDashboard/source_inquiry', [
                'categories' => $categories,
                'count' => $count,
                'data' => $data,
            ]);
    
            }

        public function country()
    {
        // if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
        //     abort(404, 'Cannot Access');
        // }
    
        $source = Accountsection_2023::select(DB::raw("COUNT(country_residence) as count"), 'country_residence')
        ->where(function ($query) {
            $query->where('lives_2023', 'New Lives')
                ->where('insurance_type', 'IPMI')
                ->where('status', '!=', 'Not Counted')
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->whereIn('policy', ['Active']);
        })
        ->orWhere(function ($query) {
            $query->where('policy', 'Active')
                ->whereIn('insurance_type', ['IPMI'])
                ->where('status', '!=', 'Not Counted')
                ->where('lives_2023', 'Existing')
                ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
        })
            ->groupBy(DB::raw("country_residence"))
            ->get();
    
        $total_count = $source->sum('count');
    
        $data = $source->map(function ($item) use ($total_count) {
            $percentage = round($item->count / $total_count * 100, 2);
            return ['name' => $item->country_residence,'count' => $item->count,'percentage' => $percentage,];
        });
    
        return view('/2023/GraphDashboard/country', compact('data'));
    }
   
    
    public function insurer()
    {
        // if (!(auth()->user()->role == '1' || auth()->user()->role == '3')) {
        //     abort(404, 'Cannot Access');
        // }
    
        $source = Accountsection_2023::select(DB::raw("COUNT(insurer) as count"), 'insurer')
        ->where(function ($query) {
                $query->where('lives_2023', 'New Lives')
                    ->where('status', '!=', 'Not Counted')
                    ->where('insurance_type', 'IPMI')
                    ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                    ->whereIn('policy', ['Active']);
            })
            ->orWhere(function ($query) {
                $query->where('policy', 'Active')
                    ->whereIn('insurance_type', ['IPMI'])
                    ->where('lives_2023', 'Existing')
                    ->where('status', '!=', 'Not Counted')
                    ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
            })
            ->groupBy(DB::raw("insurer"))
            ->get();
    
        $total_count = $source->sum('count');
    
        $data = $source->map(function ($item) use ($total_count) {
            $percentage = round($item->count / $total_count * 100, 2);
            return [            'name' => $item->insurer,            'count' => $item->count,            'percentage' => $percentage,        ];
        });
    
        return view('/2023/GraphDashboard/insurer', compact('data'));
    }

    
//Number of Policy per Main applicants Age 2023
    public function age()
    {
        // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
        //     abort(404, 'Cannot Access');
        // }
    
        $source = Accountsection_2023::select(DB::raw("COUNT(age) as count"), DB::raw("CAST(age AS UNSIGNED) as age_int"))
        ->where('policy', 'Active')
        ->where('insurance_type' , 'IPMI')
        ->where('type_applicant','Main Applicant')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
        ->groupBy('age_int')
        ->orderBy('age_int', 'asc')
        ->get('count', 'age_int');

        $array = Accountsection_2023::select('age')
        ->where('policy', 'Active')     
        ->where('insurance_type' , 'IPMI')  
        ->where('type_applicant','Main Applicant')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
        ->groupBy('age')
        ->orderByRaw('CAST(age AS SIGNED)')
        ->pluck('age')
        ->toArray();

        $try = Accountsection_2023::where ('policy', 'Active')        
        ->where('insurance_type' , 'IPMI')
        ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
        ->count();


        return view('/2023/GraphDashboard/age', compact('source','array', 'try'));
        
    }    


//NFranciss want 2023
public function francis()
{
    $source = Accountsection::where('status', '!=', 'Not Counted')
    ->whereBetween('start_date', ['2022-01-01', '2022-12-31'])
    ->where(function ($query) {
        $query->where(function ($subQuery) {
            $subQuery->where('lives_2022', 'New Lives')
                    //  ->whereIn('insurance_type', ['IPMI'])
                     ->whereBetween('placement_date', ['2022-01-01', '2022-12-31'])
                     ->whereIn('policy', ['Active']);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('lives_2022', 'New Lives and Existing')
                    //  ->whereIn('insurance_type', ['IPMI'])
                     ->whereBetween('placement_date', ['2022-01-01', '2022-12-31'])
                     ->whereIn('policy', ['Active']);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('lives_2022', 'New Lives')
                    //  ->whereIn('insurance_type', ['IPMI'])
                     ->whereBetween('placement_date', ['2022-01-01', '2022-12-31'])
                     ->whereIn('policy', ['Pended']);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('lives_2022', 'New Lives')
                    //  ->whereIn('insurance_type', ['IPMI'])
                     ->whereBetween('placement_date', ['2022-01-01', '2022-12-31'])
                     ->whereBetween('cancelled_date', ['2022-01-01', '2022-12-31'])
                     ->whereIn('policy', ['Lapsed']);
        });
    }) 
    ->select(DB::raw('count(*) as count'))

    ->get();


    $renewal_2023 =  Accountsection_2023::select('*')->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
 ->wherein('membership',[    'BI-6000-0301-4663','BI-6000-0302-0669','BI-6000-0227-9730','BI-6000-0301-3236','BI-6000-0301-3816','BI-6000-0299-9886','BI-6000-0299-9889','BI-6000-0299-9888','BI-6000-0299-9883','BI-6000-0299-9875','BI-6000-0299-3918','BI-6000-0008-3641','BI-6000-0107-7547','BI-6000-0008-3648','BI-6000-0008-3645','BI-6000-0036-9053','BI-6000-0299-6185','BI-6000-0299-6176','BI-6000-0299-7352','BI-6000-0299-7360','BI-6000-0299-7364','BI-6000-0299-7366','BI-6000-0300-0432','BI-6000-0212-4985','BI-6000-0212-4987','BI-6000-0212-4986','BI-6000-0301-6189','BI-6000-0132-7092','BI-6000-0301-8778','BI-6000-0301-7843','BI-6000-0301-7854','BI-6000-0300-0380','BI-6000-0300-2228','BI-6000-0300-4172','BI-6000-0301-8806','BI-6000-0301-8899','BI-6000-0301-9927','BI-6000-0263-6960','BI-6000-0302-4339','BI-6000-0302-6016','BI-6000-0300-1905','BI-6000-0300-4514','BI-6000-0300-4517','BI-6000-0300-7508','BI-6000-0300-7933','BI-6000-0259-4709','BI-6000-0301-0414','BI-6000-0301-0417','BI-6000-0301-0478','BI-6000-0134-5901','BI-6000-0301-1824','BI-6000-0301-5649','BI-6000-0301-2152','BI-6000-0226-1992','BI-6000-0226-1994','BI-6000-0226-1995','BI-6000-0226-1993','BI-6000-0226-6514','BI-6000-0301-2141','2368D2','BI-6000-0261-0107','BI-6000-0302-3789','BI-6000-0302-4321','BI-6000-0302-5015','1000011817','1000011818','4005960015','1000012284','BI-6000-0301-3821','BI-6000-0302-2121','BI-6000-0302-2118','BI-6000-0302-2119','BI-6000-0302-2120','BI-6000-0302-2122','3000000075','3000000077','BI-6000-0302-6481','BI-6000-0302-6482','BI-6000-0302-6483','BI-6000-0302-6484','BI-6000-0305-5738','3000000109','BI-6000-0069-8285','0447A','BI-6000-0069-8290','BI-6000-0187-0099','BI-6000-0172-0411','BI-6000-0234-2123','BI-6000-0183-6213','0447D2','1528296','50414','0446A','BI-6000-0300-5019','BI-6000-0300-5047','4005960014','4005960012','4005960013','BI-6000-0211-6996','4005960011','4005960010','4005960009','4005960008','4005960007','4005960006','4005960005','4005960004','4005960003','4005960002','4005960001','4005950009','4005950010','4005950014','4005950008','4005950006','4005950006','4005950005','4005950004','4005950003','4005950002','3000000071','BI-6000-0302-9479','BI-6000-0285-9425','BI-6000-0303-1292','BI-6000-0303-1297','BI-6000-0306-2876','1531263','1531264','1531265','BI-6000-0304-4819','BI-6000-0303-0169','BI-6000-0303-0194','BI-6000-0303-0740','BI-6000-0303-2394','BI-6000-0302-7938','BI-6000-0302-7941','BI-6000-0302-7945','BI-6000-0302-7950','BI-6000-0302-7954','BI-6000-0302-8531','BI-6000-0302-9653','BI-6000-0303-0766','BI-6000-0303-2782','BI-6000-0303-3224','3000000142','BI-6000-0303-2438','BI-6000-0303-2829','BI-6000-0303-4386','3000000162','3000000162','BI-6000-0303-5335','BI-6000-0303-7070','P003605519','87360444','BI-6000-0304-6852','BI-6000-0304-6919','BI-6000-0305-2291','BI-6000-0305-0294','BI-6000-0303-5355','4006520009','3000000224','3000000224','3000000224','921116185','921116432','4006520010','4006520011','4006520012','4006520013','4006520014','P003638029','3000000264','3000000264','BI-6000-0285-6073','BI-6000-0300-2184','BI-6000-0300-9324','BI-6000-0300-2188','BI-6000-0303-9367','BI-6000-0306-0710','BI-6000-0301-1260','BI-6000-0305-7169','BI-6000-0305-7184','BI-6000-0305-8190','3000000293','BI-6000-0306-1144','3000000306','BI-6000-0306-6001','BI-6000-0306-1638','BI-6000-0306-3265','BI-6000-0306-7382','BI-6000-0306-1148','200001','BI-6000-0305-1857','BI-6000-0307-0091','BI-6000-0306-6899','BI-6000-0306-6127','BI-6000-0306-8638','BI-6000-0307-1205','BI-6000-0307-1167','BI-6000-0307-1180','BI-6000-0303-0149','BI-6000-0307-1183','BI-6000-0307-1197','3000000242','3000000242','3000000143','3000000143','3000000143','3000000143','5139A','5139D1','BI-6000-0307-3788','BI-6000-0307-4836','BI-6000-0307-4829','BI-6000-0307-4830','BI-6000-0307-4831','BI-6000-0307-4832','BI-6000-0307-4833','BI-6000-0307-3866','BI-6000-0307-3871','5065A','5065B','5144B','4006520016','4006520017','2908A','3000000117','BI-6000-0308-2015','BI-6000-0308-2024','BI-6000-0307-8363','BI-6000-0252-0933','BI-6000-0303-3909','BI-6000-0308-1889','BI-6000-0253-5164','BI-6000-0253-5167','BI-6000-0253-5165','BI-6000-0253-5166','BI-6000-0309-0953','BI-6000-0308-5093','BI-6000-0308-5067','BI-6000-0308-5071','BI-6000-0245-5886','4005950016','2964A','2964B','2964D1','2964D2','BI-6000-0053-1706','BI-6000-0309-0815','921120134','921120134','BI-6000-0308-3107','BI-6000-0308-3115','BI-6000-0308-3126','46658','5264A','5264B','BI-6000-0309-4724','BI-6000-0309-2319','BI-6000-0308-9298','5270A','BI-6000-0307-3314','BI-6000-0307-4326','BI-6000-0307-4841','BI-6000-0305-3256','BI-6000-0311-8490','BI-6000-0305-4447','BI-6000-0311-8491','BI-6000-0311-8492','BI-6000-0311-8493','BI-6000-0306-9319','BI-6000-0302-5396','3000000260','BI-6000-0305-3283','3000000485','3000000485','3000000485','3000000497','3000000528','3000000520','3000000520','BI-6000-0305-4011','BI-6000-0309-0995','921114865','BI-6000-0305-4740','BI-6000-0281-5967','BI-6000-0307-4849','BI-6000-0310-2046','BI-6000-0309-9963','921119336','BI-6000-0311-2458','0447D1','0447D3','921101233','BI-6000-0311-3174','IPDB0002236','PTI-K38-01028-1','PTI-A02060','BI-6000-0312-0681','ARID-B23-00122-1','BI-6000-0312-0700','ARID-B23-00122-1','ARID-B0900108-1','87305811','921120950','BI-6000-0310-0417','BI-6000-0092-4987','BI-6000-0309-7156','BI-6000-0212-4984','BI-6000-0310-5113','BI-6000-0311-2427','1531263','PLG-G78-00672-1','LISD-A684-03269-1','3000000388','3000000623','BI-6000-0305-4899','3000000278','BI-6000-0307-6147','BI-6000-0307-6128','BI-6000-0307-6139','BI-6000-0307-6143','BI-6000-0306-0748','BI-6000-0310-5268','BI-6000-0119-0367','BI-6000-0310-5290','BI-6000-0119-0366','BI-6000-0119-0368','BI-6000-0311-6138','BI-6000-0119-0369','BI-6000-0312-0106','BI-6000-0310-0986','BI-6000-0311-5640','BI-6000-0312-0694','BI-6000-0312-0697','BI-6000-0312-0160','BI-6000-0312-0678','BI-6000-0312-0712','BI-6000-0312-0214','BI-6000-0312-0742','BI-6000-0312-0745','BI-6000-0312-0748','BI-6000-0312-0752','BI-6000-0312-0193','BI-6000-0312-0189','S-HIA-00006456-00-22','BI-6000-0312-0765','BI-6000-0305-4355','BI-6000-0305-4357','IE-007248-02','BI-6000-0305-4356','IE-007248-03','BI-6000-0305-4358','BI-6000-0303-1869','1000011817','1000011818','1000013400','1000013134','1000013135','1000013136','1000013137','1000014743','1000014742','1000014644','1000014645','1000014646','1000014647','1000015002','1000015002','1000015008','1000015579','4006520001','QNA3848317','4006520003','4006520004','BI-6000-0303-7595','BI-6000-0311-5611','BI-6000-0306-5398','BI-6000-0306-5415','BI-6000-0306-5412','4007120010','4007120001','4007120002','4007120003','BI-6000-0308-5082','4007120004','4007120004','BI-6000-0228-7335','4007120004','BI-6000-0202-9387','4007120004','4007120004','BI-6000-0202-9384','4007120005','BI-6000-0310-7349','4006520006','BI-6000-0288-8952','4006520008','4006520007','BI-6000-0310-3822','BI-6000-0310-3828','BI-6000-0310-9167','BI-6000-0310-9176','4007120006','BI-6000-0310-3846','4007120006','4007120006','400712006','4871A','4007120007','4007120008','4007120009','4004370002','4005960012','4006520015','BI-6000-0309-9424','BI-6000-0308-5411','4006520016','BI-6000-0309-9499','BI-6000-0310-0467','4006520018','BI-6000-0312-2373','BI-6000-0310-9544','BI-6000-0312-0874','4005950017','BI-6000-0310-1452','4005950018','4005950019','BI-6000-0309-7180','BI-6000-0303-4964','4004540001','4006520020','BI-6000-0312-3824','201237','201239','P003743866','P003822394','BI-6000-0309-8843','4871B','5144A','4007700001','BI-6000-0309-0289','400770002','4007700003','11626','BI-6000-0308-3092','4007700006','LISD-A448-03032-1','4007700009','1000014794','5416A','LISD-A448-03032-1','5186B','5270A','1000014643','3259A','3259DI','325D2','3260A','3260B','3261A','321D1','321D2','3261D3','3262A','3262D1','3262D2','3263A','3264A','3264B','3264B','3265B','3265D1','3438A','BI-6000-0265-5221','3386A','3387A','3388A','BI-6000-0312-4064','2984A','4008040004','2949A','4008040001','2949B','2949D1','4008040002','2949D2','2949D3','4008040003','2950A','2950B','3371A','400450004','400450004','3241A','3242A','2391A','BI-6000-0310-5124','2391B','2392A','2392B1','2392D1','1000016147','1000013542','1000013543','1000013544','3451A','1000013545','BI-6000-0311-3685','1000014534','1000014535','3452A','1000014536','BI-6000-0312-0066','BI-6000-0307-4355','BI-6000-0309-8433','2129000774','BI-6000-0309-9305','BI-6000-0309-9309','BI-6000-0309-9324','BI-6000-0311-5612','BI-6000-0309-7095','BI-6000-0312-3242','BI-6000-0309-4507','BI-6000-0160-2834','BI-6000-0310-6621','BI-6000-0312-3248','BI-6000-0310-8308','BI-6000-0311-0512','BI-6000-0310-7817','BI-6000-0310-7793','BI-6000-0310-8376','BI-6000-0310-9434','BI-6000-0310-8347','BI-6000-0314-8282','BI-6000-0312-6472','3000000629','BI-6000-0312-8899','BI-60000-313-7878','BI-60000-313-7878','BI-60000-313-7878','BI-6000-0313-7850','BI-6000-0312-6176','BI-6000-0312-6177','BI-6000-0276-3755','BI-6000-0276-3756','BI-6000-0276-3757','BI-6000-0313-1099','BI-6000-0315-0043','BI-6000-0313-9150','BI-6000-0313-9138','BI-6000-0051-1729','BI-6000-0313-4104','ARID-B42-00142-1','BI-6000-0312-9243','BI-6000-0313-1530','BI-6000-0313-0473','BI-6000-0311-3114','ARID-B42-00142-1','BI-6000-0313-1831','BI-6000-0313-8333','BI-6000-0313-8346','PTI-M11-01199-1','PTI-M14-01202-1','3000000640','3474A','3474B','3474D1','GE-012109-00','GE-012110-00','SXV0004552','3260D4','3532A','3532D1','3532D2','3533A','3533D1','3533D2','3532D3','3000000672','BXV-SAB005'
        ])
    ->where(function($query) {
        // Group the conditions related to 'Active' policies
        $query->where(function($subQuery) {
            $subQuery->where('policy', 'Active')
                ->where('status', '!=', 'Not Counted')
                ->whereIn('insurance_type', ['IPMI'])
                ->where('lives_2023', 'Existing');
        })
        // Group the conditions related to 'Lapsed' policies with a cancellation date greater than 180 days from the start date
        ->orWhere(function($subQuery) {
            $subQuery->where('policy', 'Lapsed')
                ->where('status', '!=', 'Not Counted')
                ->whereIn('insurance_type', ['IPMI'])
                ->where('lives_2023', 'Existing')
                ->whereRaw("DATEDIFF(cancelled_date, start_date) >= 180");
        })
        // Group the conditions related to 'New Lives and Existing' policies
        ->orWhere(function($subQuery) {
            $subQuery->where('insurance_type', 'IPMI')
                ->where('status', '!=', 'Not Counted')
                ->where('lives_2023', 'New Lives and Existing')
                ->whereBetween('placement_date',['2023-01-01' , '2023-12-31'])
                ->whereIn('policy', ['Active']);
            });
        }) 
        ->select(DB::raw('count(*) as count'))

        ->get();


        //Cancelled

        $queryWithConditions = Accountsection_2023::select('*')
        ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
        ->wherein('membership',[
            'BI-6000-0301-4663','BI-6000-0302-0669','BI-6000-0227-9730','BI-6000-0301-3236','BI-6000-0301-3816','BI-6000-0299-9886','BI-6000-0299-9889','BI-6000-0299-9888','BI-6000-0299-9883','BI-6000-0299-9875','BI-6000-0299-3918','BI-6000-0008-3641','BI-6000-0107-7547','BI-6000-0008-3648','BI-6000-0008-3645','BI-6000-0036-9053','BI-6000-0299-6185','BI-6000-0299-6176','BI-6000-0299-7352','BI-6000-0299-7360','BI-6000-0299-7364','BI-6000-0299-7366','BI-6000-0300-0432','BI-6000-0212-4985','BI-6000-0212-4987','BI-6000-0212-4986','BI-6000-0301-6189','BI-6000-0132-7092','BI-6000-0301-8778','BI-6000-0301-7843','BI-6000-0301-7854','BI-6000-0300-0380','BI-6000-0300-2228','BI-6000-0300-4172','BI-6000-0301-8806','BI-6000-0301-8899','BI-6000-0301-9927','BI-6000-0263-6960','BI-6000-0302-4339','BI-6000-0302-6016','BI-6000-0300-1905','BI-6000-0300-4514','BI-6000-0300-4517','BI-6000-0300-7508','BI-6000-0300-7933','BI-6000-0259-4709','BI-6000-0301-0414','BI-6000-0301-0417','BI-6000-0301-0478','BI-6000-0134-5901','BI-6000-0301-1824','BI-6000-0301-5649','BI-6000-0301-2152','BI-6000-0226-1992','BI-6000-0226-1994','BI-6000-0226-1995','BI-6000-0226-1993','BI-6000-0226-6514','BI-6000-0301-2141','2368D2','BI-6000-0261-0107','BI-6000-0302-3789','BI-6000-0302-4321','BI-6000-0302-5015','1000011817','1000011818','4005960015','1000012284','BI-6000-0301-3821','BI-6000-0302-2121','BI-6000-0302-2118','BI-6000-0302-2119','BI-6000-0302-2120','BI-6000-0302-2122','3000000075','3000000077','BI-6000-0302-6481','BI-6000-0302-6482','BI-6000-0302-6483','BI-6000-0302-6484','BI-6000-0305-5738','3000000109','BI-6000-0069-8285','0447A','BI-6000-0069-8290','BI-6000-0187-0099','BI-6000-0172-0411','BI-6000-0234-2123','BI-6000-0183-6213','0447D2','1528296','50414','0446A','BI-6000-0300-5019','BI-6000-0300-5047','4005960014','4005960012','4005960013','BI-6000-0211-6996','4005960011','4005960010','4005960009','4005960008','4005960007','4005960006','4005960005','4005960004','4005960003','4005960002','4005960001','4005950009','4005950010','4005950014','4005950008','4005950006','4005950006','4005950005','4005950004','4005950003','4005950002','3000000071','BI-6000-0302-9479','BI-6000-0285-9425','BI-6000-0303-1292','BI-6000-0303-1297','BI-6000-0306-2876','1531263','1531264','1531265','BI-6000-0304-4819','BI-6000-0303-0169','BI-6000-0303-0194','BI-6000-0303-0740','BI-6000-0303-2394','BI-6000-0302-7938','BI-6000-0302-7941','BI-6000-0302-7945','BI-6000-0302-7950','BI-6000-0302-7954','BI-6000-0302-8531','BI-6000-0302-9653','BI-6000-0303-0766','BI-6000-0303-2782','BI-6000-0303-3224','3000000142','BI-6000-0303-2438','BI-6000-0303-2829','BI-6000-0303-4386','3000000162','3000000162','BI-6000-0303-5335','BI-6000-0303-7070','P003605519','87360444','BI-6000-0304-6852','BI-6000-0304-6919','BI-6000-0305-2291','BI-6000-0305-0294','BI-6000-0303-5355','4006520009','3000000224','3000000224','3000000224','921116185','921116432','4006520010','4006520011','4006520012','4006520013','4006520014','P003638029','3000000264','3000000264','BI-6000-0285-6073','BI-6000-0300-2184','BI-6000-0300-9324','BI-6000-0300-2188','BI-6000-0303-9367','BI-6000-0306-0710','BI-6000-0301-1260','BI-6000-0305-7169','BI-6000-0305-7184','BI-6000-0305-8190','3000000293','BI-6000-0306-1144','3000000306','BI-6000-0306-6001','BI-6000-0306-1638','BI-6000-0306-3265','BI-6000-0306-7382','BI-6000-0306-1148','200001','BI-6000-0305-1857','BI-6000-0307-0091','BI-6000-0306-6899','BI-6000-0306-6127','BI-6000-0306-8638','BI-6000-0307-1205','BI-6000-0307-1167','BI-6000-0307-1180','BI-6000-0303-0149','BI-6000-0307-1183','BI-6000-0307-1197','3000000242','3000000242','3000000143','3000000143','3000000143','3000000143','5139A','5139D1','BI-6000-0307-3788','BI-6000-0307-4836','BI-6000-0307-4829','BI-6000-0307-4830','BI-6000-0307-4831','BI-6000-0307-4832','BI-6000-0307-4833','BI-6000-0307-3866','BI-6000-0307-3871','5065A','5065B','5144B','4006520016','4006520017','2908A','3000000117','BI-6000-0308-2015','BI-6000-0308-2024','BI-6000-0307-8363','BI-6000-0252-0933','BI-6000-0303-3909','BI-6000-0308-1889','BI-6000-0253-5164','BI-6000-0253-5167','BI-6000-0253-5165','BI-6000-0253-5166','BI-6000-0309-0953','BI-6000-0308-5093','BI-6000-0308-5067','BI-6000-0308-5071','BI-6000-0245-5886','4005950016','2964A','2964B','2964D1','2964D2','BI-6000-0053-1706','BI-6000-0309-0815','921120134','921120134','BI-6000-0308-3107','BI-6000-0308-3115','BI-6000-0308-3126','46658','5264A','5264B','BI-6000-0309-4724','BI-6000-0309-2319','BI-6000-0308-9298','5270A','BI-6000-0307-3314','BI-6000-0307-4326','BI-6000-0307-4841','BI-6000-0305-3256','BI-6000-0311-8490','BI-6000-0305-4447','BI-6000-0311-8491','BI-6000-0311-8492','BI-6000-0311-8493','BI-6000-0306-9319','BI-6000-0302-5396','3000000260','BI-6000-0305-3283','3000000485','3000000485','3000000485','3000000497','3000000528','3000000520','3000000520','BI-6000-0305-4011','BI-6000-0309-0995','921114865','BI-6000-0305-4740','BI-6000-0281-5967','BI-6000-0307-4849','BI-6000-0310-2046','BI-6000-0309-9963','921119336','BI-6000-0311-2458','0447D1','0447D3','921101233','BI-6000-0311-3174','IPDB0002236','PTI-K38-01028-1','PTI-A02060','BI-6000-0312-0681','ARID-B23-00122-1','BI-6000-0312-0700','ARID-B23-00122-1','ARID-B0900108-1','87305811','921120950','BI-6000-0310-0417','BI-6000-0092-4987','BI-6000-0309-7156','BI-6000-0212-4984','BI-6000-0310-5113','BI-6000-0311-2427','1531263','PLG-G78-00672-1','LISD-A684-03269-1','3000000388','3000000623','BI-6000-0305-4899','3000000278','BI-6000-0307-6147','BI-6000-0307-6128','BI-6000-0307-6139','BI-6000-0307-6143','BI-6000-0306-0748','BI-6000-0310-5268','BI-6000-0119-0367','BI-6000-0310-5290','BI-6000-0119-0366','BI-6000-0119-0368','BI-6000-0311-6138','BI-6000-0119-0369','BI-6000-0312-0106','BI-6000-0310-0986','BI-6000-0311-5640','BI-6000-0312-0694','BI-6000-0312-0697','BI-6000-0312-0160','BI-6000-0312-0678','BI-6000-0312-0712','BI-6000-0312-0214','BI-6000-0312-0742','BI-6000-0312-0745','BI-6000-0312-0748','BI-6000-0312-0752','BI-6000-0312-0193','BI-6000-0312-0189','S-HIA-00006456-00-22','BI-6000-0312-0765','BI-6000-0305-4355','BI-6000-0305-4357','IE-007248-02','BI-6000-0305-4356','IE-007248-03','BI-6000-0305-4358','BI-6000-0303-1869','1000011817','1000011818','1000013400','1000013134','1000013135','1000013136','1000013137','1000014743','1000014742','1000014644','1000014645','1000014646','1000014647','1000015002','1000015002','1000015008','1000015579','4006520001','QNA3848317','4006520003','4006520004','BI-6000-0303-7595','BI-6000-0311-5611','BI-6000-0306-5398','BI-6000-0306-5415','BI-6000-0306-5412','4007120010','4007120001','4007120002','4007120003','BI-6000-0308-5082','4007120004','4007120004','BI-6000-0228-7335','4007120004','BI-6000-0202-9387','4007120004','4007120004','BI-6000-0202-9384','4007120005','BI-6000-0310-7349','4006520006','BI-6000-0288-8952','4006520008','4006520007','BI-6000-0310-3822','BI-6000-0310-3828','BI-6000-0310-9167','BI-6000-0310-9176','4007120006','BI-6000-0310-3846','4007120006','4007120006','400712006','4871A','4007120007','4007120008','4007120009','4004370002','4005960012','4006520015','BI-6000-0309-9424','BI-6000-0308-5411','4006520016','BI-6000-0309-9499','BI-6000-0310-0467','4006520018','BI-6000-0312-2373','BI-6000-0310-9544','BI-6000-0312-0874','4005950017','BI-6000-0310-1452','4005950018','4005950019','BI-6000-0309-7180','BI-6000-0303-4964','4004540001','4006520020','BI-6000-0312-3824','201237','201239','P003743866','P003822394','BI-6000-0309-8843','4871B','5144A','4007700001','BI-6000-0309-0289','400770002','4007700003','11626','BI-6000-0308-3092','4007700006','LISD-A448-03032-1','4007700009','1000014794','5416A','LISD-A448-03032-1','5186B','5270A','1000014643','3259A','3259DI','325D2','3260A','3260B','3261A','321D1','321D2','3261D3','3262A','3262D1','3262D2','3263A','3264A','3264B','3264B','3265B','3265D1','3438A','BI-6000-0265-5221','3386A','3387A','3388A','BI-6000-0312-4064','2984A','4008040004','2949A','4008040001','2949B','2949D1','4008040002','2949D2','2949D3','4008040003','2950A','2950B','3371A','400450004','400450004','3241A','3242A','2391A','BI-6000-0310-5124','2391B','2392A','2392B1','2392D1','1000016147','1000013542','1000013543','1000013544','3451A','1000013545','BI-6000-0311-3685','1000014534','1000014535','3452A','1000014536','BI-6000-0312-0066','BI-6000-0307-4355','BI-6000-0309-8433','2129000774','BI-6000-0309-9305','BI-6000-0309-9309','BI-6000-0309-9324','BI-6000-0311-5612','BI-6000-0309-7095','BI-6000-0312-3242','BI-6000-0309-4507','BI-6000-0160-2834','BI-6000-0310-6621','BI-6000-0312-3248','BI-6000-0310-8308','BI-6000-0311-0512','BI-6000-0310-7817','BI-6000-0310-7793','BI-6000-0310-8376','BI-6000-0310-9434','BI-6000-0310-8347','BI-6000-0314-8282','BI-6000-0312-6472','3000000629','BI-6000-0312-8899','BI-60000-313-7878','BI-60000-313-7878','BI-60000-313-7878','BI-6000-0313-7850','BI-6000-0312-6176','BI-6000-0312-6177','BI-6000-0276-3755','BI-6000-0276-3756','BI-6000-0276-3757','BI-6000-0313-1099','BI-6000-0315-0043','BI-6000-0313-9150','BI-6000-0313-9138','BI-6000-0051-1729','BI-6000-0313-4104','ARID-B42-00142-1','BI-6000-0312-9243','BI-6000-0313-1530','BI-6000-0313-0473','BI-6000-0311-3114','ARID-B42-00142-1','BI-6000-0313-1831','BI-6000-0313-8333','BI-6000-0313-8346','PTI-M11-01199-1','PTI-M14-01202-1','3000000640','3474A','3474B','3474D1','GE-012109-00','GE-012110-00','SXV0004552','3260D4','3532A','3532D1','3532D2','3533A','3533D1','3533D2','3532D3','3000000672','BXV-SAB005'
                ])

        ->where(function($query) {
            // Group the conditions related to 'Active' policies
            $query->where(function($subQuery) {
                $subQuery->where('policy', 'Active')
                    // ->where('status', '!=', 'Not Counted')
                    // ->whereIn('insurance_type', ['IPMI'])
                    ->where('lives_2023', 'Existing');
            })
            // Group the conditions related to 'Lapsed' policies with a cancellation date greater than 180 days from the start date
            ->orWhere(function($subQuery) {
                $subQuery->where('policy', 'Lapsed')
                    ->where('status', '!=', 'Not Counted')
                    ->whereIn('insurance_type', ['IPMI'])
                    ->where('lives_2023', 'Existing')
                    ->whereRaw("DATEDIFF(cancelled_date, start_date) >= 180");
            })
            // Group the conditions related to 'New Lives and Existing' policies
            ->orWhere(function($subQuery) {
                $subQuery->where('insurance_type', 'IPMI')
                    ->where('status', '!=', 'Not Counted')
                    ->where('lives_2023', 'New Lives and Existing')
                    ->whereBetween('placement_date',['2023-01-01' , '2023-12-31'])
                    ->whereIn('policy', ['Active']);
                });
            })
            ->pluck('id');

        $queryWithoutConditions  = Accountsection_2023::select('*')
        // ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
        
        ->wherein('membership',[
    'BI-6000-0301-4663','BI-6000-0302-0669','BI-6000-0227-9730','BI-6000-0301-3236','BI-6000-0301-3816','BI-6000-0299-9886','BI-6000-0299-9889','BI-6000-0299-9888','BI-6000-0299-9883','BI-6000-0299-9875','BI-6000-0299-3918','BI-6000-0008-3641','BI-6000-0107-7547','BI-6000-0008-3648','BI-6000-0008-3645','BI-6000-0036-9053','BI-6000-0299-6185','BI-6000-0299-6176','BI-6000-0299-7352','BI-6000-0299-7360','BI-6000-0299-7364','BI-6000-0299-7366','BI-6000-0300-0432','BI-6000-0212-4985','BI-6000-0212-4987','BI-6000-0212-4986','BI-6000-0301-6189','BI-6000-0132-7092','BI-6000-0301-8778','BI-6000-0301-7843','BI-6000-0301-7854','BI-6000-0300-0380','BI-6000-0300-2228','BI-6000-0300-4172','BI-6000-0301-8806','BI-6000-0301-8899','BI-6000-0301-9927','BI-6000-0263-6960','BI-6000-0302-4339','BI-6000-0302-6016','BI-6000-0300-1905','BI-6000-0300-4514','BI-6000-0300-4517','BI-6000-0300-7508','BI-6000-0300-7933','BI-6000-0259-4709','BI-6000-0301-0414','BI-6000-0301-0417','BI-6000-0301-0478','BI-6000-0134-5901','BI-6000-0301-1824','BI-6000-0301-5649','BI-6000-0301-2152','BI-6000-0226-1992','BI-6000-0226-1994','BI-6000-0226-1995','BI-6000-0226-1993','BI-6000-0226-6514','BI-6000-0301-2141','2368D2','BI-6000-0261-0107','BI-6000-0302-3789','BI-6000-0302-4321','BI-6000-0302-5015','1000011817','1000011818','4005960015','1000012284','BI-6000-0301-3821','BI-6000-0302-2121','BI-6000-0302-2118','BI-6000-0302-2119','BI-6000-0302-2120','BI-6000-0302-2122','3000000075','3000000077','BI-6000-0302-6481','BI-6000-0302-6482','BI-6000-0302-6483','BI-6000-0302-6484','BI-6000-0305-5738','3000000109','BI-6000-0069-8285','0447A','BI-6000-0069-8290','BI-6000-0187-0099','BI-6000-0172-0411','BI-6000-0234-2123','BI-6000-0183-6213','0447D2','1528296','50414','0446A','BI-6000-0300-5019','BI-6000-0300-5047','4005960014','4005960012','4005960013','BI-6000-0211-6996','4005960011','4005960010','4005960009','4005960008','4005960007','4005960006','4005960005','4005960004','4005960003','4005960002','4005960001','4005950009','4005950010','4005950014','4005950008','4005950006','4005950006','4005950005','4005950004','4005950003','4005950002','3000000071','BI-6000-0302-9479','BI-6000-0285-9425','BI-6000-0303-1292','BI-6000-0303-1297','BI-6000-0306-2876','1531263','1531264','1531265','BI-6000-0304-4819','BI-6000-0303-0169','BI-6000-0303-0194','BI-6000-0303-0740','BI-6000-0303-2394','BI-6000-0302-7938','BI-6000-0302-7941','BI-6000-0302-7945','BI-6000-0302-7950','BI-6000-0302-7954','BI-6000-0302-8531','BI-6000-0302-9653','BI-6000-0303-0766','BI-6000-0303-2782','BI-6000-0303-3224','3000000142','BI-6000-0303-2438','BI-6000-0303-2829','BI-6000-0303-4386','3000000162','3000000162','BI-6000-0303-5335','BI-6000-0303-7070','P003605519','87360444','BI-6000-0304-6852','BI-6000-0304-6919','BI-6000-0305-2291','BI-6000-0305-0294','BI-6000-0303-5355','4006520009','3000000224','3000000224','3000000224','921116185','921116432','4006520010','4006520011','4006520012','4006520013','4006520014','P003638029','3000000264','3000000264','BI-6000-0285-6073','BI-6000-0300-2184','BI-6000-0300-9324','BI-6000-0300-2188','BI-6000-0303-9367','BI-6000-0306-0710','BI-6000-0301-1260','BI-6000-0305-7169','BI-6000-0305-7184','BI-6000-0305-8190','3000000293','BI-6000-0306-1144','3000000306','BI-6000-0306-6001','BI-6000-0306-1638','BI-6000-0306-3265','BI-6000-0306-7382','BI-6000-0306-1148','200001','BI-6000-0305-1857','BI-6000-0307-0091','BI-6000-0306-6899','BI-6000-0306-6127','BI-6000-0306-8638','BI-6000-0307-1205','BI-6000-0307-1167','BI-6000-0307-1180','BI-6000-0303-0149','BI-6000-0307-1183','BI-6000-0307-1197','3000000242','3000000242','3000000143','3000000143','3000000143','3000000143','5139A','5139D1','BI-6000-0307-3788','BI-6000-0307-4836','BI-6000-0307-4829','BI-6000-0307-4830','BI-6000-0307-4831','BI-6000-0307-4832','BI-6000-0307-4833','BI-6000-0307-3866','BI-6000-0307-3871','5065A','5065B','5144B','4006520016','4006520017','2908A','3000000117','BI-6000-0308-2015','BI-6000-0308-2024','BI-6000-0307-8363','BI-6000-0252-0933','BI-6000-0303-3909','BI-6000-0308-1889','BI-6000-0253-5164','BI-6000-0253-5167','BI-6000-0253-5165','BI-6000-0253-5166','BI-6000-0309-0953','BI-6000-0308-5093','BI-6000-0308-5067','BI-6000-0308-5071','BI-6000-0245-5886','4005950016','2964A','2964B','2964D1','2964D2','BI-6000-0053-1706','BI-6000-0309-0815','921120134','921120134','BI-6000-0308-3107','BI-6000-0308-3115','BI-6000-0308-3126','46658','5264A','5264B','BI-6000-0309-4724','BI-6000-0309-2319','BI-6000-0308-9298','5270A','BI-6000-0307-3314','BI-6000-0307-4326','BI-6000-0307-4841','BI-6000-0305-3256','BI-6000-0311-8490','BI-6000-0305-4447','BI-6000-0311-8491','BI-6000-0311-8492','BI-6000-0311-8493','BI-6000-0306-9319','BI-6000-0302-5396','3000000260','BI-6000-0305-3283','3000000485','3000000485','3000000485','3000000497','3000000528','3000000520','3000000520','BI-6000-0305-4011','BI-6000-0309-0995','921114865','BI-6000-0305-4740','BI-6000-0281-5967','BI-6000-0307-4849','BI-6000-0310-2046','BI-6000-0309-9963','921119336','BI-6000-0311-2458','0447D1','0447D3','921101233','BI-6000-0311-3174','IPDB0002236','PTI-K38-01028-1','PTI-A02060','BI-6000-0312-0681','ARID-B23-00122-1','BI-6000-0312-0700','ARID-B23-00122-1','ARID-B0900108-1','87305811','921120950','BI-6000-0310-0417','BI-6000-0092-4987','BI-6000-0309-7156','BI-6000-0212-4984','BI-6000-0310-5113','BI-6000-0311-2427','1531263','PLG-G78-00672-1','LISD-A684-03269-1','3000000388','3000000623','BI-6000-0305-4899','3000000278','BI-6000-0307-6147','BI-6000-0307-6128','BI-6000-0307-6139','BI-6000-0307-6143','BI-6000-0306-0748','BI-6000-0310-5268','BI-6000-0119-0367','BI-6000-0310-5290','BI-6000-0119-0366','BI-6000-0119-0368','BI-6000-0311-6138','BI-6000-0119-0369','BI-6000-0312-0106','BI-6000-0310-0986','BI-6000-0311-5640','BI-6000-0312-0694','BI-6000-0312-0697','BI-6000-0312-0160','BI-6000-0312-0678','BI-6000-0312-0712','BI-6000-0312-0214','BI-6000-0312-0742','BI-6000-0312-0745','BI-6000-0312-0748','BI-6000-0312-0752','BI-6000-0312-0193','BI-6000-0312-0189','S-HIA-00006456-00-22','BI-6000-0312-0765','BI-6000-0305-4355','BI-6000-0305-4357','IE-007248-02','BI-6000-0305-4356','IE-007248-03','BI-6000-0305-4358','BI-6000-0303-1869','1000011817','1000011818','1000013400','1000013134','1000013135','1000013136','1000013137','1000014743','1000014742','1000014644','1000014645','1000014646','1000014647','1000015002','1000015002','1000015008','1000015579','4006520001','QNA3848317','4006520003','4006520004','BI-6000-0303-7595','BI-6000-0311-5611','BI-6000-0306-5398','BI-6000-0306-5415','BI-6000-0306-5412','4007120010','4007120001','4007120002','4007120003','BI-6000-0308-5082','4007120004','4007120004','BI-6000-0228-7335','4007120004','BI-6000-0202-9387','4007120004','4007120004','BI-6000-0202-9384','4007120005','BI-6000-0310-7349','4006520006','BI-6000-0288-8952','4006520008','4006520007','BI-6000-0310-3822','BI-6000-0310-3828','BI-6000-0310-9167','BI-6000-0310-9176','4007120006','BI-6000-0310-3846','4007120006','4007120006','400712006','4871A','4007120007','4007120008','4007120009','4004370002','4005960012','4006520015','BI-6000-0309-9424','BI-6000-0308-5411','4006520016','BI-6000-0309-9499','BI-6000-0310-0467','4006520018','BI-6000-0312-2373','BI-6000-0310-9544','BI-6000-0312-0874','4005950017','BI-6000-0310-1452','4005950018','4005950019','BI-6000-0309-7180','BI-6000-0303-4964','4004540001','4006520020','BI-6000-0312-3824','201237','201239','P003743866','P003822394','BI-6000-0309-8843','4871B','5144A','4007700001','BI-6000-0309-0289','400770002','4007700003','11626','BI-6000-0308-3092','4007700006','LISD-A448-03032-1','4007700009','1000014794','5416A','LISD-A448-03032-1','5186B','5270A','1000014643','3259A','3259DI','325D2','3260A','3260B','3261A','321D1','321D2','3261D3','3262A','3262D1','3262D2','3263A','3264A','3264B','3264B','3265B','3265D1','3438A','BI-6000-0265-5221','3386A','3387A','3388A','BI-6000-0312-4064','2984A','4008040004','2949A','4008040001','2949B','2949D1','4008040002','2949D2','2949D3','4008040003','2950A','2950B','3371A','400450004','400450004','3241A','3242A','2391A','BI-6000-0310-5124','2391B','2392A','2392B1','2392D1','1000016147','1000013542','1000013543','1000013544','3451A','1000013545','BI-6000-0311-3685','1000014534','1000014535','3452A','1000014536','BI-6000-0312-0066','BI-6000-0307-4355','BI-6000-0309-8433','2129000774','BI-6000-0309-9305','BI-6000-0309-9309','BI-6000-0309-9324','BI-6000-0311-5612','BI-6000-0309-7095','BI-6000-0312-3242','BI-6000-0309-4507','BI-6000-0160-2834','BI-6000-0310-6621','BI-6000-0312-3248','BI-6000-0310-8308','BI-6000-0311-0512','BI-6000-0310-7817','BI-6000-0310-7793','BI-6000-0310-8376','BI-6000-0310-9434','BI-6000-0310-8347','BI-6000-0314-8282','BI-6000-0312-6472','3000000629','BI-6000-0312-8899','BI-60000-313-7878','BI-60000-313-7878','BI-60000-313-7878','BI-6000-0313-7850','BI-6000-0312-6176','BI-6000-0312-6177','BI-6000-0276-3755','BI-6000-0276-3756','BI-6000-0276-3757','BI-6000-0313-1099','BI-6000-0315-0043','BI-6000-0313-9150','BI-6000-0313-9138','BI-6000-0051-1729','BI-6000-0313-4104','ARID-B42-00142-1','BI-6000-0312-9243','BI-6000-0313-1530','BI-6000-0313-0473','BI-6000-0311-3114','ARID-B42-00142-1','BI-6000-0313-1831','BI-6000-0313-8333','BI-6000-0313-8346','PTI-M11-01199-1','PTI-M14-01202-1','3000000640','3474A','3474B','3474D1','GE-012109-00','GE-012110-00','SXV0004552','3260D4','3532A','3532D1','3532D2','3533A','3533D1','3533D2','3532D3','3000000672','BXV-SAB005'
        ])
        ->pluck('id');

        $difference = $queryWithoutConditions->diff($queryWithConditions);
        
        $cancelled_2023 = Accountsection_2023::whereIn('id', $difference) 
 // The missing parenthesis
    ->select(DB::raw('count(*) as count'))

    ->get();

    $no_record_2023 = 10; 
    return view('/2023/GraphDashboard/compare_2022_2023', compact('source','renewal_2023','cancelled_2023','no_record_2023'));
    
}    


    public function country_premium()
    {
        $source = Accountsection_2023::select(DB::raw("SUM(convert_premium_USD) as premium_sum"), 'country_residence')
            ->where('insurance_type','IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
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
        $source_total = Accountsection_2023::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))
        ->where('insurance_type' , 'IPMI')
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])            
            ->get();

        $source_total = Accountsection_2023::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))    
        ->where('insurance_type' , 'IPMI')        
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->get();
    
        return view('/2023/GraphDashboard/country_premium', compact('data','source_total','source_total'));
    }
    
    public function insurer_premium()
    {
        $source = Accountsection_2023::select(DB::raw("SUM(convert_premium_USD) as premium_sum"), 'insurer')
            ->where('status', '!=', 'Not Counted') 
            ->where('insurance_type','IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
            ->groupBy('insurer')
            ->get();
        
        $source_commission = Accountsection_2023::select(DB::raw("SUM(commission_2023) as commission_sum"), 'insurer')
            ->where('status', '!=', 'Not Counted') 
            ->where('insurance_type', 'IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->groupBy('insurer')
            ->get();
            
        $total_sum = $source->sum('premium_sum');
        $total_sum_commission = $source_commission->sum('commission_sum'); // Corrected this line
    
        $data = $source->map(function ($item) use ($total_sum, $source_commission) {
            $commission = $source_commission->where('insurer', $item->insurer)->first()->commission_sum ?? 0;
            return [
                'name' => $item->insurer,
                'premium_sum' => $item->premium_sum,
                'commission' => $commission, // Added commission to the data set
                'percentage' => round($item->premium_sum / $total_sum * 100, 2),
            ];
        });
    
        $source_total = Accountsection_2023::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))
            ->where('insurance_type' , 'IPMI')
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])            
            ->get();
    
        // You can use the $total_sum and $total_sum_commission variables to pass to your view
        // If you need to pass the total sums separately, you can add them to the compact method
    
        return view('/2023/GraphDashboard/insurer_premium', compact('data', 'source_total', 'total_sum', 'total_sum_commission'));
    }
    
        
}
