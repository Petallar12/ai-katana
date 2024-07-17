<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Accountsection;
use Illuminate\Support\Facades\DB;
use App\Models\Accountsection_2024;

class GraphDashboard_2024Controller extends Controller
{
      //total existing and new lives
      public function index1(){
        $userData = Accountsection_2024::select(DB::raw("COUNT(*) as count"))
        ->whereIn('policy',['Active' , 'Lapsed', 'Pended'])
        ->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
        ->where('status', '!=', 'Not Counted')
        ->where('insurance_type' , 'IPMI')
        ->whereYear("placement_date",['2024-01-01' , '2024-12-31'])
        ->groupBY(DB::raw("Month(placement_date)"))
        ->pluck('count');

        

        $userData1 = Accountsection_2024::select(DB::raw("COUNT(*) as count"))
        ->whereIn('lives_2024', ['Existing', 'New Lives and Existing'])
        ->where('status', '!=', 'Not Counted')
        ->where('insurance_type' , 'IPMI')
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->where('policy', 'Active')
                    ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
            })->orWhere(function ($query) {
                $query->whereIn('policy', ['Lapsed','Active'])
                    ->whereRaw('DATEDIFF(cancelled_date, start_date) >= 180');
            });
        })
        ->groupBY(DB::raw("Month(start_date)"))
        ->pluck('count');

        $total_newlives = Accountsection_2024::select(DB::raw("COUNT(*) as count"))
        ->whereIn('policy',['Active' , 'Pended', 'Lapsed'])
        ->where('insurance_type' , 'IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
        ->whereYear("placement_date",['2024-01-01' , '2024-12-31'])
        ->pluck('count');

        
        $total_existing = Accountsection_2024::select(DB::raw("COUNT(*) as count"))
       
        ->whereIn('lives_2024', ['Existing', 'New Lives and Existing'])
        ->where('insurance_type' , 'IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->where('policy', 'Active')
                    ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
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

        return view('/2024/GraphDashboard/lives_2024',compact('userData','userData1','total_newlives','total_existing', 'userDataAccumulative' , 'userDataAccumulative1'));
    }



        //for premium commission
        public function premium_commission()
        {
            $sum =  Accountsection_2024::whereNotIn('policy', ['Transferred', 'Pended'])
              ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('convert_premium_USD');
              $formattedsum = number_format($sum, 2);  $formattedsum;
              $sum2 =  Accountsection_2024::where('policy','!=','Transferred')
              ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('commission_2024');
              $formattedsum2 = number_format($sum2, 2);  $formattedsum2;
              
              $commissions =  Accountsection_2024::select(DB::raw('sum(commission_2024) as sum'))  
              ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->whereNotIn('policy', ['Transferred', 'Pended'])
              ->where('insurance_type' , 'IPMI')
              ->whereIn('lives_2024', ['New Lives','Existing', 'New Lives and Existing'])
              ->groupBY(DB::raw("Month(start_date)"))
              ->get();   

            $commissionsAccumulative = [];
            $commissionSum = 0;
            foreach ($commissions as $e) {
                $commissionSum += $e->sum;
                $commissionsAccumulative[] = floatval(number_format($commissionSum, 2, '.', ''));
            }
    
    
            $premium =  Accountsection_2024::select(DB::raw('sum(convert_premium_USD) as sum'))
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
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
            $array = Accountsection_2024::select(DB::raw("MONTHNAME(start_date) as month"))
            
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
            ->where('status', '!=', 'Not Counted')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('insurance_type' , 'IPMI')
            ->groupBy('month')
            ->orderByRaw("MONTH(start_date)")
            ->pluck('month')
            ->toArray();
            
    
    
            return view('/2024/GraphDashboard/premium_commission', compact('array','premium','commissions','sum','sum2','formattedsum','formattedsum2','commissionsAccumulative','premiumAccumulative'));
    
        }


        public function premium_commission_normal()
        {
            $sum =  Accountsection_2024::whereNotIn('policy', ['Transferred', 'Pended'])
              ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->sum('convert_premium_USD');


              $formattedsum = number_format($sum, 2);  $formattedsum;


              $sum2 =  Accountsection_2024::whereNotIn('policy', ['Transferred', 'Pended'])
              ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
              ->where('insurance_type' , 'IPMI')
              ->sum('commission_2024');
              $formattedsum2 = number_format($sum2, 2);  $formattedsum2;

              $premium = Accountsection_2024::select(DB::raw("sum(convert_premium_USD) as sum"))
              ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
              ->whereNotIn('policy', ['Transferred', 'Pended'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->groupBY(DB::raw("Month(start_date)"))
              ->pluck('sum');
  
              $commissions = Accountsection_2024::select(DB::raw("sum(commission_2024) as sum"))
              ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
              ->whereNotIn('policy', ['Transferred', 'Pended'])
              ->where('status', '!=', 'Not Counted')
              ->where('insurance_type' , 'IPMI')
              ->groupBY(DB::raw("Month(start_date)"))
              ->pluck('sum');
  
            
           
        return view('/2024/GraphDashboard/premium_commission_normal',compact('premium','commissions','sum','sum2','formattedsum','formattedsum2',));
    }

        //new lives source of inquiry
        public function source_inquiry()
        {
            // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
            //     abort(404, 'Cannot Access');
            // }
        
        //    $source = Accountsection_2024::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
        //    ->whereIn('lives_2024', ['New Lives and Existing', 'New Lives'])
        //    ->whereIn('policy', ['Active', 'Pended'])
        //    ->where("insurance_type", "IPMI")
        //    ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
        //     ->groupBy('source_inquiry')
        //     ->havingRaw('COUNT(source_inquiry) > 0')
        //     ->get('count');

        $source = Accountsection_2024::select(DB::raw("COUNT(source_inquiry) as count"), 'source_inquiry')
            ->whereIn('lives_2024', ['New Lives and Existing', 'New Lives'])
            ->where('status', '!=', 'Not Counted')
            ->where("insurance_type", "IPMI")
            ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
            ->where(function ($query) {
            $query->whereIn('policy', ['Active', 'Pended'])
                ->orWhere(function ($query) {
            $query->whereBetween('cancelled_date', ['2024-01-01', '2024-12-31'])
                ->whereIn('policy', ['Lapsed']);
            });
            })
            ->groupBy('source_inquiry')
            ->havingRaw('COUNT(source_inquiry) > 0')
            ->get('count');

    
            $array = Accountsection_2024::select('source_inquiry')
            ->whereIn('lives_2024', ['New Lives and Existing', 'New Lives'])
            ->where('status', '!=', 'Not Counted')
            ->where("insurance_type", "IPMI")
            ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
            ->where(function ($query) {
            $query->whereIn('policy', ['Active', 'Pended'])
                ->orWhere(function ($query) {
            $query->whereBetween('cancelled_date', ['2024-01-01', '2024-12-31'])
                ->whereIn('policy', ['Lapsed']);
            });
            })
            ->groupBy('source_inquiry')
            //to remove the 0 in y axis
            ->havingRaw('COUNT(source_inquiry) > 0')
            ->pluck('source_inquiry')
            ->toArray();
            
            return view('/2024/GraphDashboard/source_inquiry', compact('source','array'));
            
        }

        //existing source of inquiry
        public function source_inquiry_existing()
        {
            
            $data = Accountsection_2024::select(DB::raw("COUNT(*) as count"), 'source_inquiry')
            
            ->where('policy', 'Active')      
            ->where('insurance_type' , 'IPMI')  
            ->where('status', '!=', 'Not Counted')
            ->Where('lives_2024', 'Existing')
            ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
                ->groupBy('source_inquiry')
                ->get();
    
            // Prepare the data for the graph
            $categories = $data->pluck('source_inquiry');
            $count = $data->pluck('count');
    
            // Render the graph
            return view('/2024/GraphDashboard/source_inquiry', [
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
        $source = Accountsection_2024::select(DB::raw("COUNT(country_residence) as count"), 'country_residence')
        ->where(function ($query) {
            $query->where('lives_2024', 'New Lives')
                ->where('insurance_type', 'IPMI')
                ->where('status', '!=', 'Not Counted')
                ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                ->whereIn('policy', ['Active']);
        })
        ->orWhere(function ($query) {
            $query->where('policy', 'Active')
                ->whereIn('insurance_type', ['IPMI'])
                ->where('status', '!=', 'Not Counted')
                ->where('lives_2024', 'Existing')
                ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
        })
            ->groupBy(DB::raw("country_residence"))
            ->get();
    
        $total_count = $source->sum('count');
    
        $data = $source->map(function ($item) use ($total_count) {
            $percentage = round($item->count / $total_count * 100, 2);
            return ['name' => $item->country_residence,'count' => $item->count,'percentage' => $percentage,];
        });    
        return view('/2024/GraphDashboard/country', compact('data'));
    }   
    
    public function insurer()
    {    
        $source = Accountsection_2024::select(DB::raw("COUNT(insurer) as count"), 'insurer')
        ->where(function ($query) {
                $query->where('lives_2024', 'New Lives')
                    ->where('insurance_type', 'IPMI')
                    ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                    ->where('status', '!=', 'Not Counted')
                    ->whereIn('policy', ['Active']);
            })
            ->orWhere(function ($query) {
                $query->where('policy', 'Active')
                    ->whereIn('insurance_type', ['IPMI'])
                    ->where('status', '!=', 'Not Counted')
                    ->where('lives_2024', 'Existing')
                    ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
            })
            ->groupBy(DB::raw("insurer"))
            ->get();
        $total_count = $source->sum('count');
        $data = $source->map(function ($item) use ($total_count) {
            $percentage = round($item->count / $total_count * 100, 2);
            return [            'name' => $item->insurer,            'count' => $item->count,            'percentage' => $percentage,        ];
        });
        return view('/2024/GraphDashboard/insurer', compact('data'));
    }

    
//Number of Policy per Main applicants Age 2024
    public function age()
    {   
        $source = Accountsection_2024::select(DB::raw("COUNT(age) as count"), DB::raw("CAST(age AS UNSIGNED) as age_int"))
        ->where('policy', 'Active')
        ->where('insurance_type' , 'IPMI')
        ->where('type_applicant','Main Applicant')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
        ->groupBy('age_int')
        ->orderBy('age_int', 'asc')
        ->get('count', 'age_int');

        $array = Accountsection_2024::select('age')
        ->where('policy', 'Active')     
        ->where('insurance_type' , 'IPMI')  
        ->where('type_applicant','Main Applicant')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->groupBy('age')
        ->orderByRaw('CAST(age AS SIGNED)')
        ->pluck('age')
        ->toArray();

        $try = Accountsection_2024::where ('policy', 'Active')        
        ->where('insurance_type' , 'IPMI')
        ->where('status', '!=', 'Not Counted')
        ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
        ->count();


        return view('/2024/GraphDashboard/age', compact('source','array', 'try'));
        
    }    
    public function country_premium()
    {
        $source = Accountsection_2024::select(DB::raw("SUM(convert_premium_USD) as premium_sum"), 'country_residence')
            ->where('insurance_type','IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
            ->where('status', '!=', 'Not Counted')
            ->groupBy(DB::raw("country_residence"))
            ->get();
    
        $total_sum = $source->sum('premium_sum');
    
        $data = $source->map(function ($item) use ($total_sum) {
            if ($total_sum != 0) {
                $percentage = round($item->premium_sum / $total_sum * 100, 2);
            } else {
                $percentage = 0; // or any appropriate default value when the total sum is zero
            }
        
            return [
                'name' => $item->country_residence,
                'premium_sum' => $item->premium_sum,
                'percentage' => $percentage,
            ];
        });
        
        $source_total = Accountsection_2024::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))
        ->where('insurance_type' , 'IPMI')
        // ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])            
            ->get();

        $source_total = Accountsection_2024::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))    
        ->where('insurance_type' , 'IPMI')        
        // ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
            ->get();
    
        return view('/2024/GraphDashboard/country_premium', compact('data','source_total','source_total'));
    }

    public function insurer_premium()
    {
        $source = Accountsection_2024::select(DB::raw("SUM(convert_premium_USD) as premium_sum"), 'insurer')
            ->where('status', '!=', 'Not Counted') 
            ->where('insurance_type','IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date',['2024-01-01' , '2024-12-31'])
            ->groupBy('insurer')
            ->get();
        
        $source_commission = Accountsection_2024::select(DB::raw("SUM(commission_2024) as commission_sum"), 'insurer')
            ->where('status', '!=', 'Not Counted') 
            ->where('insurance_type', 'IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])
            ->groupBy('insurer')
            ->get();
            
        $total_sum = $source->sum('premium_sum');
        $total_sum_commission = $source_commission->sum('commission_sum'); // Corrected this line
    
        $data = $source->map(function ($item) use ($total_sum, $source_commission) {
            $commission = $source_commission->where('insurer', $item->insurer)->first()->commission_sum ?? 0;
            $percentage = $total_sum > 0 ? round($item->premium_sum / $total_sum * 100, 2) : 0;
            return [
                'name' => $item->insurer,
                'premium_sum' => $item->premium_sum,
                'commission' => $commission,
                'percentage' => $percentage,
            ];
        });
    
        $source_total = Accountsection_2024::select(DB::raw("SUM(convert_premium_USD) as premium_sum"))
            ->where('insurance_type' , 'IPMI')
            ->whereBetween('start_date', ['2024-01-01', '2024-12-31'])            
            ->get();
    
        // You can use the $total_sum and $total_sum_commission variables to pass to your view
        // If you need to pass the total sums separately, you can add them to the compact method
    
        return view('/2024/GraphDashboard/insurer_premium', compact('data', 'source_total', 'total_sum', 'total_sum_commission'));
    }
            
}
