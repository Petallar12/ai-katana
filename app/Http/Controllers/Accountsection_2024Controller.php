<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountsection_2024;
use App\Models\Accountsection_2023;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;


class Accountsection_2024Controller extends Controller
{

    // This is For CLients 2024
    
    public function index2024(Request $request)
    {
        $sourceInquiries = Accountsection_2024::distinct()
            ->whereNotNull('source_inquiry')
            ->pluck('source_inquiry');
    
        $Policyfilter = Accountsection_2024::distinct()
            ->whereNotNull('policy')
            ->pluck('policy');
    
        $Insurerfilter = Accountsection_2024::distinct()
            ->whereNotNull('insurer')
            ->pluck('insurer');
    
        $Lives_2024_filter = Accountsection_2024::distinct()
            ->whereNotNull('lives_2024')
            ->pluck('lives_2024');
    
        $Group_name_filter = Accountsection_2024::distinct()
            ->whereNotNull('group_name')
            ->pluck('group_name');
    
        $Group_identifier_filter = Accountsection_2024::distinct()
            ->whereNotNull('group_identifier')
            ->pluck('group_identifier');
    
        $Case_closed_filter = Accountsection_2024::distinct()
            ->whereNotNull('case_closed')
            ->pluck('case_closed');
    
        $Case_officer_2024_filter = Accountsection_2024::distinct()
            ->whereNotNull('case_officer_2024')
            ->pluck('case_officer_2024');
    
        if ($request->ajax()) {
            $source_inquiry = $request->query('source_inquiry');
            $policy = $request->query('policy');
            $insurer = $request->query('insurer');
            $lives_2024 = $request->query('lives_2024');
            $group_name = $request->query('group_name');
            $group_identifier = $request->query('group_identifier');
            $case_closed = $request->query('case_closed');
            $case_officer_2024 = $request->query('case_officer_2024');
    
            $query = Accountsection_2024::select('*'); // or specify columns you need
    
            // Apply filters
            if (!empty($source_inquiry)) {
                $query->where('source_inquiry', $source_inquiry);
            }
            if (!empty($policy)) {
                $query->where('policy', $policy);
            }
            if (!empty($insurer)) {
                $query->where('insurer', $insurer);
            }
            if (!empty($lives_2024)) {
                $query->where('lives_2024', $lives_2024);
            }
            if (!empty($group_name)) {
                $query->where('group_name', $group_name);
            }
            if (!empty($group_identifier)) {
                $query->where('group_identifier', $group_identifier);
            }
            if (!empty($case_closed)) {
                $query->where('case_closed', $case_closed);
            }
            if (!empty($case_officer_2024)) {
                $query->where('case_officer_2024', $case_officer_2024);
            }
    
            $data = $query->get();
            $filters = [
                'source_inquiries' => $data->pluck('source_inquiry')->unique()->filter()->values(),
                'policies' => $data->pluck('policy')->unique()->filter()->values(),
                'insurers' => $data->pluck('insurer')->unique()->filter()->values(),
                'lives_2024' => $data->pluck('lives_2024')->unique()->filter()->values(),
                'group_names' => $data->pluck('group_name')->unique()->filter()->values(),
                'group_identifiers' => $data->pluck('group_identifier')->unique()->filter()->values(),
                'case_closed' => $data->pluck('case_closed')->unique()->filter()->values(),
                'case_officer_2024' => $data->pluck('case_officer_2024')->unique()->filter()->values(),
            ];
    
            return DataTables::of($query)
                ->with('filters', $filters)
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary">Action</button>';
                })
                ->make(true);
        }
    
        return view('2024.accountsection.index', compact(
            'sourceInquiries', 
            'Policyfilter', 
            'Insurerfilter', 
            'Lives_2024_filter', 
            'Group_name_filter',
            'Group_identifier_filter',
            'Case_closed_filter',
            'Case_officer_2024_filter'
        ));
    }
    
  

        //This is for Add Record 2024
        public function create()
        {
            if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {

                abort(404, 'Cannot Access');
            }
            return view('2024.accountsection.create');
        }
    
    
        // To save The Enter Add Record 2024
        public function store(Request $request)
        {
            $fileName = '';
            $fileName2 = '';
            $fileName3 = '';
    
            if ($request->hasFile('file')) {
                $fileName = $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('public/images_2024', $fileName);
            }
    
            if ($request->hasFile('file2')) {
                $fileName2 = $request->file('file2')->getClientOriginalName();
                $request->file('file2')->storeAs('public/attachment_2_2024', $fileName2);
            }
            if ($request->hasFile('file3')) {
                $fileName3 = $request->file('file3')->getClientOriginalName();
                $request->file('file3')->storeAs('public/application_form_2024', $fileName3);
            }  
            $accountsection = $request->all();
            $accountsection['attachment'] = $fileName;
            $accountsection['attachment_2'] = $fileName2;
            $accountsection['attachment_3'] = $fileName3;
    
            Accountsection_2024::create($accountsection);
    
            return redirect('2024/accountsection/index')->with(['message' => 'Post added successfully!', 'status' => 'success']);
        }
        public function show($id)
        {
            $accountsection_2024 = Accountsection_2024::findOrFail($id);
            $renewalDate = new \DateTime($accountsection_2024->renewal_date);
        
            // Check if membership is not empty
            $claimsByCurrency = [];
            $years = [];
            if (!empty($accountsection_2024->membership)) {
                $claims = $this->fetchClaims($accountsection_2024->membership);
        
                foreach ($claims as $claim) {
                    $claimDate = new \DateTime($claim['date_received']);
                    if ($claimDate <= $renewalDate && $claim['status'] !== 'Submitted') {
                        $currency = $claim['currency'];
                        $year = $claimDate->format('Y');
                        if (!in_array($year, $years)) {
                            $years[] = $year;
                        }
                        if (!isset($claimsByCurrency[$currency])) {
                            $claimsByCurrency[$currency] = ['paid_amount' => 0, 'claims' => []];
                        }
        
                        $claimsByCurrency[$currency]['claims'][] = $claim;
                        $claimsByCurrency[$currency]['paid_amount'] += (float) str_replace(',', '', $claim['paid_amount']);
                    }
                }
            }
        
            return view('2024.accountsection.show', [
                'accountsection_2024' => $accountsection_2024,
                'claimsByCurrency' => $claimsByCurrency,
                'years' => $years
            ]);
        }
        
        private function fetchClaims($policyNumber)
        {
            $client = new Client();
            $response = $client->get('https://mibportal.com/claims_api/api/claims/fetchClaimsByPolicyNumber', [
                'query' => ['policy_number' => $policyNumber],
                'headers' => ['X-Api-Key' => '47cfab61-de6b-4260-8857-a30e738c29c3'],
            ]);
        
            $data = json_decode($response->getBody()->getContents(), true);
            return $data['claims'] ?? [];
        }
        
        
        public function edit($id)
        {
    
            $accountsection_2024 = Accountsection_2024::find($id);
            return view('2024.accountsection.edit')->with('accountsection_2024', $accountsection_2024);
        }
    
    
        // This is to update the data you change in Client
        public function update(Request $request, $id)
        {
            if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
                abort(404, 'Cannot Access');
            }
    
            $accountsection_2024 = Accountsection_2024::findOrFail($id);
    
            $fileName = $accountsection_2024->attachment; // Default to the current image filename
            $fileName2 = $accountsection_2024->attachment_2; // Default to the current image filename
            $fileName3 = $accountsection_2024->attachment_3; // Default to the current image filename
            //attachment 1 (Membership Certificate) PDF
            if ($request->hasFile('file')) {
                $fileName = $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('public/images_2024', $fileName);
    
                if ($accountsection_2024->attachment) {
                    Storage::delete('public/images_2024/' . $accountsection_2024->attachment);
                }
            }
    
            //attachment 2 (Invoice) PDF
            if ($request->hasFile('file2')) {
                $fileName2 = $request->file('file2')->getClientOriginalName();
                $request->file('file2')->storeAs('public/attachment_2_2024', $fileName2);
    
                if ($accountsection_2024->attachment_2) {
                    Storage::delete('public/attachment_2_2024/' . $accountsection_2024->attachment_2);
                }
            }
    
            //attachment 2 (Invoice) PDF
            if ($request->hasFile('file3')) {
                $fileName3 = $request->file('file3')->getClientOriginalName();
                $request->file('file3')->storeAs('public/application_form_2024', $fileName3);
    
                if ($accountsection_2024->attachment_3) {
                    Storage::delete('public/attachment_3/' . $accountsection_2024->attachment_3);
                }
            }
    
            $input = $request->except('file'); // Exclude the 'file' field from the update input
            $input['attachment'] = $fileName;
            $input['attachment_2'] = $fileName2;
            $input['attachment_3'] = $fileName3;
    
            $accountsection_2024->update($input);
    
            return redirect('2024/accountsection/index')->with('flash_message', 'Client Updated!');

        }

        public function destroy($id)
        {
            if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
                abort(404, 'Cannot Access');
            }
    
            $accountsection_2024 = Accountsection_2024::findOrFail($id);
    
            // Delete the attachment file
            if ($accountsection_2024->attachment) {
                Storage::delete('public/images_2024/' . $accountsection_2024->attachment);
            }
            if ($accountsection_2024->attachment_2) {
                Storage::delete('public/attachment_2_2024/' . $accountsection_2024->attachment_2);
            }
            if ($accountsection_2024->attachment_3) {
                Storage::delete('public/attachment_3_2024/' . $accountsection_2024->attachment_3);
            }
    
            $accountsection_2024->delete();
    
            return redirect('/2024/accountsection/index')->with('flash_message', 'Client deleted!');
        }

        public function destroy_2($id)
        {
            if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
                abort(404, 'Cannot Access');
            }
    
            $accountsection_2024 = Accountsection_2024::findOrFail($id);
    
            // Delete the attachment file
            if ($accountsection_2024->attachment) {
                Storage::delete('public/images_2024/' . $accountsection_2024->attachment);
            }
            if ($accountsection_2024->attachment_2) {
                Storage::delete('public/attachment_2_2024/' . $accountsection_2024->attachment_2);
            }
            if ($accountsection_2024->attachment_3) {
                Storage::delete('public/attachment_3_2024/' . $accountsection_2024->attachment_3);
            }
    
            $accountsection_2024->delete();
    
            return response()->json([
                'message' => 'Data Deleted'
            ]);
        }

        public function transfer($id)
        {
            if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
                abort(404, 'Cannot Access');
            }
        
            $accountsection_2024 = Accountsection_2024::findOrFail($id);
        
            // Create a new record in accountsection_2023 and copy data
            $accountsection_2023 = new Accountsection_2023;
            $accountsection_2023->policy = $accountsection_2024->policy; // Replace with your actual column names
            $accountsection_2023->membership = $accountsection_2024->membership;
            $accountsection_2023->full = $accountsection_2024->full;
            $accountsection_2023->first = $accountsection_2024->first;
            $accountsection_2023->family = $accountsection_2024->family;
            $accountsection_2023->insurer = $accountsection_2024->insurer;
            $accountsection_2023->source_inquiry = $accountsection_2024->source_inquiry;
            $accountsection_2023->lives_2023 = $accountsection_2024->lives_2023;
            $accountsection_2023->group_name = $accountsection_2024->group_name;
            $accountsection_2023->start_date = $accountsection_2024->start_date;
            // $accountsection_2023->attachment = $accountsection_2024->attachment;
            // $accountsection_2023->attachment_2 = $accountsection_2024->attachment_2;
            // $accountsection_2023->attachment_3 = $accountsection_2024->attachment_3;
            
            // ... Repeat for other columns
        
            // Set the attachment filenames for accountsection_2023
            // $accountsection_2023->attachment = $accountsection_2024->attachment;
            // $accountsection_2023->attachment_2 = $accountsection_2024->attachment_2;
            // $accountsection_2023->attachment_3 = $accountsection_2024->attachment_3;
        
            $accountsection_2023->save();
        
            // Optionally, you can delete the record from accountsection_2024
            // $accountsection_2024->delete();
        
            return redirect('/2024/accountsection/index')->with('flash_message', 'Data transferred!');
        }


        
        public function exportCsv_2024(Request $request)
        {
            $fileName = 'Datalokey_2024.csv';
        
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
        
            $columns = [
                'ID', 'Member ID', 'Full Name', 'Insurer', 'Cover', 'Product Type', 'Policy', 'Nationality', 'Residency',
                'Gender', 'Birthday', 'Age', 'Group Name', 'Group No.', 'Applicant Type', 'Joined Date', 'Start Date',
                'End Date', 'Cancelled Date', 'Contact Number', 'Personal Email Address', 'Applicant Email Address',
                'Subscription Currency', 'Mode of Payment', 'Payment Frequency', 'Active Premium', 'Total Premium',
                'Case Closed By', 'Residence Address', 'Mailing Address', 'Renewal Date', 'Placed by', 'Placement Date',
                'Broker Account', 'Agent Code', 'Premium in USD', 'Area of Cover', 'Business Category', 'Total Commission',
                'Renewal Case Officer', 'Insurance Type',
                // Add other fields here...
            ];
        
            $callback = function() use ($columns, $request) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
        
                $accounts = Accountsection_2024::query();
        
                // Apply filters based on the request
                if ($request->filled('policy')) {
                    $accounts->where('policy', $request->policy);
                }
                if ($request->filled('insurer')) {
                    $accounts->where('insurer', $request->insurer);
                }
                if ($request->filled('source_inquiry')) {
                    $accounts->where('source_inquiry', $request->source_inquiry);
                }
                if ($request->filled('lives_2024')) {
                    $accounts->where('lives_2024', $request->lives_2024);
                }
                if ($request->filled('group_name')) {
                    $accounts->where('group_name', $request->group_name);
                }
                if ($request->filled('group_identifier')) {
                    $accounts->where('group_identifier', $request->group_identifier);
                }
                if ($request->filled('case_closed')) {
                    $accounts->where('case_closed', $request->case_closed);
                }
                if ($request->filled('case_officer_2024')) {
                    $accounts->where('case_officer_2024', $request->case_officer_2024);
                }
        
                foreach ($accounts->cursor() as $account) {
                    $formattedContactNumber = "'".$account->contact_number;
                    $row = [
                        $account->id,
                        $account->membership,
                        $account->full,
                        $account->insurer,
                        $account->cover,
                        $account->product_type,
                        $account->policy,
                        $account->country_nationality,
                        $account->country_residence,
                        $account->gender,
                        $account->birthday,
                        $account->age,
                        $account->group_name,
                        $account->group_number,
                        $account->type_applicant,
                        $account->original_date,
                        $account->start_date,
                        $account->end_date,
                        $account->cancelled_date,
                        $formattedContactNumber,
                        $account->applicant_email_address,
                        $account->email_address,
                        $account->subscription_currency,
                        $account->mode_payment,
                        $account->payment_frequency,
                        $account->active_premium,
                        $account->frequency_premium,
                        $account->case_closed,
                        $account->residence,
                        $account->mailing_address,
                        $account->renewal_date,
                        $account->placement_done,
                        $account->placement_date,
                        $account->account,
                        $account->account_code,
                        $account->convert_premium_USD,
                        $account->area_cover,
                        $account->lives_2024,
                        $account->commission_2024,
                        $account->case_officer_2024,
                        $account->insurance_type,
                        // Add other fields here...
                    ];
                    fputcsv($file, $row);
                }
        
                fclose($file);
            };
        
            return response()->stream($callback, 200, $headers);
        }
        
        

}