<?php

namespace App\Http\Controllers;
use App\Models\Accountsection_2023;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;



class Databasis_2023IndexController extends Controller
{
    public function case_closed_inquiry_index(Request $request)
    {
    
        // This variable will capture the 'case_closed' query parameter if it exists.
        
        $caseOfficer = $request->query('case_closed'); //use in Query Parameter
    
        if ($request->ajax()) {
            $query = Accountsection_2023::query()
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->whereIn('policy', ['Active', 'Pended', 'Lapsed'])
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31']);
    //use in Query Parameter
            if (!empty($caseOfficer)) {
                $query->where('case_closed', $caseOfficer);
            }
    
            return DataTables::of($query)->make(true);
        }
    
        // Only return the view if it's not an AJAX request.
        // This else is not needed because if it's an ajax request it will return before this line.
        return view('2023.databasis_index.case_closed_inquiry_index', compact('caseOfficer'));
    }



    public function case_officer_2023_inquiry_index(Request $request)
    {
    
        // This variable will capture the 'case_officer_2023' query parameter if it exists.
        
        $caseOfficer = $request->query('case_officer_2023'); //use in Query Parameter
    
        if ($request->ajax()) {
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
    //use in Query Parameter
            if (!empty($caseOfficer)) {
                $query->where('case_officer_2023', $caseOfficer);
            }
    
            return DataTables::of($query)->make(true);
        }
    
        // Only return the view if it's not an AJAX request.
        // This else is not needed because if it's an ajax request it will return before this line.
        return view('2023.databasis_index.case_officer_2023_inquiry_index', compact('caseOfficer'));
    }


}
