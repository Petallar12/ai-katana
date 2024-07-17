<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountsection_2023;
use App\Models\Accountsection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DataBasis_2023Controller extends Controller
{


    //RETURN VIEW FOR NEW LIVES COUNT 2023
    public function monthly_newlives()
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')) {
            abort(404, 'Cannot Access');
        }
        return view('2023.DataBasis.monthly_newlives');
    }

    //RETURN VIEW FOR RENEWALS COUNT 2023
    public function monthly_renewals()
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')) {
            abort(404, 'Cannot Access');
        }
        return view('2023.DataBasis.monthly_renewals');
    }


    public function cancellation_newlives()
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')) {
            abort(404, 'Cannot Access');
        }
        // Cancellation 2022
        $data = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->WHERE("lives_2023", 'New Lives')
                ->where("insurance_type", "IPMI")
                ->where("policy", "Lapsed")
                ->where('status', '!=', 'Not Counted')
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                ->groupby('insurer')
                ->get();                

        $total_newlives = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->WHERE("lives_2023", 'New Lives')
                ->where("insurance_type", "IPMI")
                ->where("policy", "Lapsed")
                ->where('status', '!=', 'Not Counted')
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                ->count();
        $today_data = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->WHERE("lives_2023", 'New Lives')
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->where("policy", "Lapsed")
                ->whereDate('created_at', Carbon::today())
                ->groupby('insurer')
                ->get();
        $total_today_data = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->where("lives_2023", 'New Lives')
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->where("policy", "Lapsed")
                ->whereDate('created_at', Carbon::today())
                ->count();


        $data2 = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->WHERE("lives_2023", 'Existing')
                ->where("insurance_type", "IPMI")
                ->where("policy", "Lapsed")
                ->whereBetween('original_date', ['0000-00-00', '2022-12-31'])
                ->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                ->groupby('insurer')
                ->get();
        $total_renewal = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->WHERE("lives_2023", 'Existing')
                ->where("insurance_type", "IPMI")
                ->where("policy", "Lapsed")
                ->whereBetween('original_date', ['0000-00-00', '2022-12-31'])
                ->whereBetween('cancelled_date', ['2023-01-01', '2023-12-31'])
                ->count();

        // New Lives January 4 2022
        $data3 = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->where("insurance_type", "IPMI")
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->where('status', '!=', 'Not Counted')
                ->whereIn('policy', ['Active', 'Pended'])
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->groupby('insurer')
                ->get();
        $total_data3 = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->where("insurance_type", "IPMI")
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->where('status', '!=', 'Not Counted')
                ->whereIn('policy', ['Active', 'Pended', 'Lapsed'])
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->count();
        $today_data3 = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->where("insurance_type", "IPMI")
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->where('status', '!=', 'Not Counted')
                ->whereIn('policy', ['Active', 'Pended', 'Lapsed' ])
                ->whereDate('created_at', Carbon::today())
                ->groupby('insurer')
                ->get();
        $total_today_data3 = Accountsection_2023::select('insurer', DB::raw("COUNT(lives_2023) as lives_2023"))
                ->where("insurance_type", "IPMI")
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->where('status', '!=', 'Not Counted')
                ->whereIn('policy', ['Active', 'Pended'])
                ->whereDate('created_at', Carbon::today())
                ->count();


        // AND (policy = 'Active' OR policy = 'Pended')
        // AND (lives_2023='New Lives' OR lives_2023='New Lives and Existing')


        //source of inquiry 2023 (newlives)
        $source_inquiry = Accountsection_2023::select('source_inquiry', DB::raw("source_inquiry"))
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->whereIn('policy', ['Active', 'Pended', 'Lapsed'])
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->groupby('source_inquiry')
                ->havingRaw('COUNT(source_inquiry) > 0')
                ->get();

        $case_closed = Accountsection_2023::select("case_closed")->distinct()
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->whereIn('policy', ['Active', 'Pended', 'Lapsed'])
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->orderby('case_closed')
                //remove 0 that doesnt have a data count
                ->groupby('case_closed')
                ->havingRaw('COUNT(source_inquiry) > 0')
                ->get();

        $accountsection = Accountsection_2023::select(['source_inquiry', 'case_closed', DB::raw("COUNT(source_inquiry) AS count")])
                ->whereIn('lives_2023', ['New Lives and Existing', 'New Lives'])
                ->whereIn('policy', ['Active', 'Pended' , 'Lapsed'])
                ->where('status', '!=', 'Not Counted')
                ->where("insurance_type", "IPMI")
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->groupBy('case_closed', 'source_inquiry')
                ->havingRaw('COUNT(source_inquiry) > 0')
                ->get();




// Source of inquiry 2023 (renewals)
        $source_inquiry2 = Accountsection_2023::select('source_inquiry', DB::raw("source_inquiry"))
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
            ->groupBy('source_inquiry')
            ->get();

        $case_officer_2023 = Accountsection_2023::select("case_officer_2023")
                ->distinct()
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
                ->orderBy('case_officer_2023')
                ->groupBy('case_officer_2023')
                ->havingRaw('COUNT(*) > 0')
                ->get();

        $accountsection2 = Accountsection_2023::select(['source_inquiry', 'case_officer_2023', DB::raw("COUNT(*) AS count")])
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
                ->groupBy('case_officer_2023', 'source_inquiry')
                ->get();

        //Encoder Encoded 
        $encoded = Accountsection_2023::select('encoded_by', DB::raw("COUNT(encoded_by) as count"))
                ->where("policy", "<>", "No Sale")
                ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
                ->groupby('encoded_by')
                ->get();
        $total_encoded = Accountsection_2023::select('encoded_by', DB::raw("COUNT(encoded_by) as created_at"))
                ->where("policy", "<>", "No Sale")
                ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
                ->count();

        //Encoder Encoded For Todays Video
        //created
        $encoded_today = Accountsection_2023::select('encoded_by', DB::raw("COUNT(created_at) as count"))->whereDate('created_at', Carbon::today())->groupby('encoded_by')->get();
        $total_encoded_today = Accountsection_2023::select('encoded_by', DB::raw("COUNT(created_at) as created_at"))->whereDate('created_at', Carbon::today())->count();

        //updated
        $updated_today = Accountsection_2023::select('updated_by', DB::raw("COUNT(updated_at) as count"))->whereDate('updated_at', Carbon::today())->whereNotNull('updated_by')->groupBy('updated_by')->get();
        $total_updated_today = Accountsection_2023::whereDate('updated_at', Carbon::today())->whereNotNull('updated_by')->count('updated_at');
            // Group Count and Individual 2023======================
            // $group_name = Accountsection_2023::select(
            //     DB::raw("COALESCE(group_name, '') as group_name"),
            //     DB::raw("COUNT(lives_2023) as lives_2023")
            // )
            //     ->where("policy", "Active")
            //     ->where("insurance_type", "IPMI")
            //     ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            //     ->groupBy(DB::raw("COALESCE(group_name, '')"))
            //     ->get();

        $group_name = Accountsection_2023::select(
            DB::raw("COALESCE(group_name, '') as group_name"),
            DB::raw("COUNT(lives_2023) as lives_2023")
        )
            ->where(function ($query) {
            $query->where('lives_2023', 'New Lives')
                ->where('status', '!=', 'Not Counted')
                ->where('insurance_type', 'IPMI')
                ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                ->whereIn('policy', ['Active']);
            })
            ->orWhere(function ($query) {
            $query->where('policy', 'Active')
                ->where('status', '!=', 'Not Counted')
                ->whereIn('insurance_type', ['IPMI'])
                ->where('lives_2023', 'Existing')
                ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
        })
        ->groupBy(DB::raw("COALESCE(group_name, '')"))
        ->get();
        $count_group_name = Accountsection_2023::where("policy", "Active")
            ->where("insurance_type", "IPMI")
            ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->count();

        foreach ($group_name as $row) {
            if (empty($row->group_name) || is_null($row->group_name)) {
                $row->group_name = '1 - Individual Counts';
            }


        $premium_per_group = Accountsection_2023::select(
            DB::raw("COALESCE(group_name, '1 - Individual Counts') as group_name"),
            DB::raw("COUNT(lives_2023) as lives_2023"),
            DB::raw("SUM(convert_premium_USD) as total_premium")
        )
            ->where("policy", "Active")
            ->where("insurance_type", "IPMI")
            ->where('status', '!=', 'Not Counted')
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->groupBy(DB::raw("COALESCE(group_name, '1 - Individual Counts')"))
            ->get();

        }




        return view('/2023/DataBasis/cancellation_newlives', [
            'data' => $data, 'data2' => $data2, 'total_newlives' => $total_newlives, 'total_renewal' => $total_renewal, 'data3' => $data3,
            'total_data3' => $total_data3, 'today_data3' => $today_data3, 'total_today_data3' => $total_today_data3, 'today_data' => $today_data, 'total_today_data' => $total_today_data,
            'source_inquiry' => $source_inquiry, 'accountsection' => $accountsection, 'case_closed' => $case_closed, 'source_inquiry2' => $source_inquiry2, 'accountsection2' => $accountsection2, 'case_officer_2023' => $case_officer_2023,
            'encoded' => $encoded, 'total_encoded' => $total_encoded, 'count_group_name' => $count_group_name, 'group_name' => $group_name,
            'encoded_today' => $encoded_today, 'total_encoded_today' => $total_encoded_today, 'updated_today' => $updated_today, 'total_updated_today' => $total_updated_today, 'premium_per_group'=> $premium_per_group
        ]);
    }
}
