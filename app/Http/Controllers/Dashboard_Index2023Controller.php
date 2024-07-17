<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountsection_2023;
use Yajra\DataTables\DataTables;

class Dashboard_Index2023Controller extends Controller
{
    // {{-- automatically gets the data in database --}}
    public function source_index(Request $request)
    {  

        $source_inquiry = $request->query('source_inquiry'); //use in Query Parameter
    
        if ($request->ajax()) {
            // $source_inquiry = $request->query('source_inquiry');
            // $policy = $request->query('policy');
    
            $query = Accountsection_2023::query()
            ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
            ->where('status', '!=', 'Not Counted')
            ->where("insurance_type", "IPMI")
            ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
            ->where(function ($query) use ($source_inquiry) { // Use "use" to pass $source_inquiry
                $query->whereIn('policy', ['Active', 'Pended']);
                if (!empty($source_inquiry)) {
                    $query->where('source_inquiry', $source_inquiry);
                }
                $query->orWhere(function ($query) {
                    $query->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                          ->whereIn('policy', ['Lapsed']);
                });
            });
        //use in Query Parameter
        if (!empty($source_inquiry)) {
            $query->where('source_inquiry', $source_inquiry);
        }
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.source_index', compact('source_inquiry'));
    }

    public function insurer_index(Request $request)
    {  

        $insurer = $request->query('insurer'); //use in Query Parameter
    
        if ($request->ajax()) {
            // $insurer = $request->query('insurer');
            // $policy = $request->query('policy');
    
            $query = Accountsection_2023::query()
            ->where(function ($query) use ($insurer) {
                $query->where(function ($query) {
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
                    });
            });
        
        // Apply insurer filter if not empty
        if (!empty($insurer)) {
            $query->where('insurer', $insurer);
        }
        
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.insurer_index', compact('insurer'));
    }

    public function country_index(Request $request)
    {  

        $country_residence = $request->query('country_residence'); //use in Query Parameter
    
        if ($request->ajax()) {
            // $country_residence = $request->query('country_residence');
            // $policy = $request->query('policy');
    
            $query = Accountsection_2023::query()
            ->where(function ($query) use ($country_residence) {
                $query->where(function ($query) {
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
                    });
            });
        // Apply insurer filter if not empty
        if (!empty($country_residence)) {
            $query->where('country_residence', $country_residence);
        }
        
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.country_index', compact('country_residence'));
    }

    public function age_index(Request $request)
    {  

        $age = $request->query('age'); //use in Query Parameter
    
        if ($request->ajax()) {
            // $age = $request->query('age');
            // $policy = $request->query('policy');
    
            $query = Accountsection_2023::query()
                ->where('policy', 'Active')     
                ->where('insurance_type' , 'IPMI')  
                ->where('type_applicant','Main Applicant')
                ->where('status', '!=', 'Not Counted')
                ->whereBetween('start_date',['2023-01-01' , '2023-12-31']);

        // Apply insurer filter if not empty
        if (!empty($age)) {
            $query->where('age', $age);
        }
        
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.age_index', compact('age'));
    }

    public function country_premium_index(Request $request)
    {  

        $country_residence = $request->query('country_residence'); //use in Query Parameter
    
        if ($request->ajax()) {
            $query = Accountsection_2023::query()
            ->where('insurance_type', 'IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->whereNotNull('convert_premium_USD')
            ->where('convert_premium_USD', '!=', 0);

        // Apply insurer filter if not empty
        if (!empty($country_residence)) {
            $query->where('country_residence', $country_residence);
        }
        
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.country_premium_index', compact('country_residence'));
    }
    
    public function insurer_premium_index(Request $request)
    {

        $insurer = $request->query('insurer'); //use in Query Parameter
    
        if ($request->ajax()) {

            $query = Accountsection_2023::select('*') // Adjust the select columns as needed
            ->where('status', '!=', 'Not Counted') 
            ->where('insurance_type','IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
            ->whereNotNull('convert_premium_USD') // Exclude rows where convert_premium_USD is null
            ->where('convert_premium_USD', '!=', '0'); // Exclude rows where convert_premium_USD is blank


            if ($insurer) {
                $query->where('insurer', $insurer);
            }

            return DataTables::of($query)->make(true);
        }

        // Pass the distinct source inquiries to the view for the dropdown
        return view('2023.dashboard_index.insurer_premium_index', compact('insurer'));
    }

    public function insurer_commission_index(Request $request)
    {
        // Get distinct source inquiries for the dropdown
        $insurer = Accountsection_2023::query()
            ->distinct()
            ->whereNotNull('insurer') 
            ->pluck('insurer');

        if ($request->ajax()) {
            $insurer = $request->query('insurer');

            $query = Accountsection_2023::select('*') // Adjust the select columns as needed
            ->where('status', '!=', 'Not Counted') 
            ->where('insurance_type','IPMI')
            ->whereNotIn('policy', ['Transferred', 'Pended'])
            ->whereBetween('start_date',['2023-01-01' , '2023-12-31'])
            ->whereNotNull('commission_2023') // Exclude rows where convert_premium_USD is null
            ->where('commission_2023', '!=', ''); // Exclude rows where convert_premium_USD is blank


            if ($insurer) {
                $query->where('insurer', $insurer);
            }

            return DataTables::of($query)->make(true);
        }

     
        // Pass the distinct source inquiries to the view for the dropdown
        return view('2023.dashboard_index.insurer_commission_index', compact('insurer'));
    }
    
    public function newlives_2023_index(Request $request)
    {
        $placement_date = $request->query('placement_date');
        if ($request->ajax()) {
            $query = Accountsection_2023::select('*')
            ->whereIn('policy',['Active' , 'Pended', 'Lapsed'])
            ->where('insurance_type' , 'IPMI')
            ->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
            ->where('status', '!=', 'Not Counted')
            ->whereYear("placement_date",['2023-01-01' , '2023-12-31']);
    
            if ($placement_date) {
                // Assuming 'placement_date' is formatted as 'January', 'February', etc.
                // Convert month name to a number
                $monthNumber = date('m', strtotime($placement_date . " 1 2023"));
                $query->whereMonth('placement_date', $monthNumber);
            }
    
            return DataTables::of($query)->make(true);
        }
    
        // Pass the placement_date to the view for the dropdown
        return view('2023.dashboard_index.newlives_2023_index', compact('placement_date'));
    }
    
    public function existing_2023_index(Request $request)
    {
        if ($request->ajax()) {
            $start_date = $request->get('start_date');
            $query = Accountsection_2023::query()
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
            });
    
            if ($start_date) {
                $monthNumber = date('m', strtotime($start_date . " 1 2023"));
                $query->whereMonth('start_date', $monthNumber);
            } else {
                $query->whereYear('start_date', '2023');
            }
    
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.existing_2023_index');
    }
    
    
        



    public function case_closed_inquiry_index(Request $request)
    {
        $case_closedFilter = Accountsection_2023::distinct()
            ->whereNotNull('case_closed')
            ->pluck('case_closed');
    
        if ($request->ajax()) {
            $case_closed = $request->query('case_closed');
            
            $query = Accountsection_2023::select('*')
            ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
            ->whereIn('policy', ['Active', 'Pended', 'Lapsed'])
            ->where('status', '!=', 'Not Counted')
            ->where("insurance_type", "IPMI")
            ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->when($case_closed, function ($query) use ($case_closed) {
                    return $query->where('case_closed', $case_closed);
                });
    
            return DataTables::of($query)->make(true);
        }
    
        return view('2023.dashboard_index.case_closed_inquiry_index', compact('case_closedFilter'));
    }
}

