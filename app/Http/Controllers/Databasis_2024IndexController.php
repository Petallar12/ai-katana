<?php

namespace App\Http\Controllers;
use App\Models\Accountsection_2024;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;



class Databasis_2024IndexController extends Controller
{
    public function case_closed_inquiry_index(Request $request)
    {
    
        // This variable will capture the 'case_closed' query parameter if it exists.
        
        $caseOfficer = $request->query('case_closed'); //use in Query Parameter
    
        if ($request->ajax()) {
            $query = Accountsection_2024::query()
                ->whereIn('lives_2024', ['New Lives and Existing', 'New Lives'])
                ->whereIn('policy', ['Active', 'Pended', 'Lapsed'])
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->whereBetween('placement_date', ['2024-01-01', '2024-12-31']);
    //use in Query Parameter
            if (!empty($caseOfficer)) {
                $query->where('case_closed', $caseOfficer);
            }
    
            return DataTables::of($query)->make(true);
        }
    
        // Only return the view if it's not an AJAX request.
        // This else is not needed because if it's an ajax request it will return before this line.
        return view('2024.databasis_index.case_closed_inquiry_index', compact('caseOfficer'));
    }



    public function case_officer_2024_inquiry_index(Request $request)
    {
    
        // This variable will capture the 'case_officer_2024' query parameter if it exists.
        
        $caseOfficer = $request->query('case_officer_2024'); //use in Query Parameter
    
        if ($request->ajax()) {
            $query = Accountsection_2024::query()
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
    });
    //use in Query Parameter
            if (!empty($caseOfficer)) {
                $query->where('case_officer_2024', $caseOfficer);
            }
    
            return DataTables::of($query)->make(true);
        }
    
        // Only return the view if it's not an AJAX request.
        // This else is not needed because if it's an ajax request it will return before this line.
        return view('2024.databasis_index.case_officer_2024_inquiry_index', compact('caseOfficer'));
    }


}
