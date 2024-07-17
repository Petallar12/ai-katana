<?php

namespace App\Http\Controllers;
use App\Mail\RenewalMail;
use App\Mail\RenewalRigMail;
use Illuminate\Http\Request;
use App\Mail\RenewalBriconMail;
use App\Mail\RenewalLukeMedMail;
use App\Mail\HappyBirthdayRigMail;
use Illuminate\Support\Facades\DB;
use App\Models\Accountsection_2023;
use App\Models\Accountsection_2024;
use Illuminate\Support\Facades\Mail;
use App\Mail\HappyBirthdayLukeMedMail;
use App\Mail\HappyBirthdayLukeMedikalMail;

use App\Mail\HappyBirthdayLukeInternationalMail;

use App\Mail\HappyBirthdayJuscallMail;
use Illuminate\Support\Facades\Config;
use App\Mail\HappyBirthdayMail; // Make sure to create this Mailable
use App\Mail\HappyBirthdayBriconMail; // Make sure to create this Mailable
use Carbon\Carbon;


class Notification_2023Controller extends Controller
{
    public function renewals(Request $request)
    {
        $group_identifier = $request->query('group_identifier');

        $group_name = $request->query('group_name');

        $case_officer = $request->query('case_officer');


        $query_2023 = Accountsection_2023::select('id', 'membership', 'full', 'renewal_date', 'case_officer', 'email_address', 'contact_number', 'applicant_email_address', 'account', 'group_name', 'convert_premium_USD', 'group_identifier', 'start_date', 'case_officer_2023')
        ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
        ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year

        ->where('group_name', '!=', '')
        ->where('insurance_type', 'IPMI')
        ->where('policy', 'Active')
        ->where(function ($query) use ($request) { // Pass $request into the closure
            $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
                  ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                  ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                      $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                            ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
                  });
        })
        ->orWhere(function ($query) use ($request) { // Use "orWhere" for the second condition
            $query    ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year


            ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
                  ->where(function ($query) { // Add a condition for blank or null group_name
                      $query->where('group_name', '=', '') // Blank group_name
                            ->orWhereNull('group_name'); // Null group_name
                  })
                  ->where('insurance_type', 'IPMI')
                  ->where('policy', 'Active')
                  ->where(function ($query) use ($request) { // Pass $request into the closure
                      $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
                            ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                            ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                                $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                                      ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
                            });
                  });
        });
        $query_2024 = Accountsection_2024::select('id','membership','full','renewal_date','case_officer','email_address','contact_number','applicant_email_address','account','group_name','convert_premium_USD','group_identifier','start_date','case_officer_2024')
        ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
        ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year
        ->where('group_name', '!=', '') // Not equal to blank group_name
        ->where('insurance_type','IPMI')
        ->where('policy','Active')
        ->where(function ($query) use ($request) { // Pass $request into the closure
            $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
                  ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                  ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                      $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing']) 
                            ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
                  });
        })
        ->orWhere(function ($query) use ($request) { // Use "orWhere" for the second condition
            $query    ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year


            ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
            ->where(function ($query) { // Add a condition for blank or null group_name
                $query->where('group_name', '=', '') // Blank group_name
                      ->orWhereNull('group_name'); // Null group_name
            })                  ->where('insurance_type', 'IPMI')
                  ->where('policy', 'Active')
                  ->where(function ($query) use ($request) { // Pass $request into the closure
                      $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
                            ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                            ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                                $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing'])
                                      ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
                            });
                  });
        });
    
        if (!empty($group_identifier)) {
            $query_2023->where('group_identifier', $group_identifier);
            $query_2024->where('group_identifier', $group_identifier);
        }
        if (!empty($group_name)) {
            $query_2023->where('group_name', $group_name);
            $query_2024->where('group_name', $group_name);
        }
        if (!empty($case_officer)) {
            $query_2023->where('case_officer', $case_officer);
            $query_2024->where('case_officer', $case_officer);
        }

        $query_2023 = $query_2023->toBase();
        $query_2024 = $query_2024->toBase();

        $query_2023->addSelect('case_officer_2023 as case_officer_renewals');
        $query_2024->addSelect('case_officer_2024 as case_officer_renewals');
        $combinedQuery = $query_2023->unionAll($query_2024);

        $renewals = DB::query()->fromSub($combinedQuery, 'combined')->get();


            // Get the distinct values for the filters from both years
    $group_identifiers_2023 = Accountsection_2023::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                        ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
              });
    })->pluck('group_identifier');
    $group_names_2023 = Accountsection_2023::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                        ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
              });
    })->pluck('group_name');
    $case_officers_2023 = Accountsection_2023::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                        ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
              });
    })->pluck('case_officer');

    $group_identifiers_2024 = Accountsection_2024::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing'])
                        ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
              });
    })->pluck('group_identifier');
    $group_names_2024 = Accountsection_2024::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing']) 
                        ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
              });
    })->pluck('group_name');
    $case_officers_2024 = Accountsection_2024::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing']) 
                        ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
              });
    })->pluck('case_officer');

    // Combine and get unique values across both years
    $Group_Identifierfilter = $group_identifiers_2023->merge($group_identifiers_2024)->unique()->values();
    $Group_Namefilter = $group_names_2023->merge($group_names_2024)->unique()->values();
    $Case_Officerfilter = $case_officers_2023->merge($case_officers_2024)->unique()->values();


        return view('2023.Notification.renewals', compact('renewals', 'Group_Identifierfilter','Group_Namefilter','Case_Officerfilter'));
    }


    

    public function sendEmailRenewal(Request $request)
    {
        $emailAddress = $request->email;
        $recipientName = $request->name;
        $account = $request->account;

        // Determine which email to send based on the account
        if ($account === 'Jusmedical Sdn Bhd') {
            // Send email using Medishure settings
            Mail::to($emailAddress)->send(new RenewalMail($recipientName));
        } elseif ($account === 'Bricon Associates Pte Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new RenewalBriconMail($recipientName));
        } elseif ($account === 'Rig Associates Pte Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new RenewalRigMail($recipientName));
        } elseif ($account === 'Luke Medical Pte Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new RenewalLukeMedMail($recipientName));    
        } else {
            // Optionally handle other cases or log an error
            return response()->json(['error' => 'Unrecognized account'], 422);
        }

        return response()->json(['message' => 'Email sent successfully to ' . $emailAddress]);
    }

    public function sendRenewalEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to primary SMTP configuration (smtp)
        Config::set('mail.default', 'smtp');

        // Send email using primary SMTP
        Mail::to($emailAddress)->send(new RenewalMail($recipientName));

        return response()->json(['message' => 'Renewal email sent successfully to ' . $emailAddress]);
    }

    public function sendRenewalbriconEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_bricon)
        Config::set('mail.default', 'smtp_bricon');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new RenewalBriconMail($recipientName));

        return response()->json(['message' => 'Renewal email sent successfully to ' . $emailAddress]);
    }

    public function sendRenewalrigEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_rig)
        Config::set('mail.default', 'smtp_rig');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new RenewalRigMail($recipientName));

        return response()->json(['message' => 'Renewal email sent successfully to ' . $emailAddress]);
    }

    public function sendRenewallukemedEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_lukemed)
        Config::set('mail.default', 'smtp_lukemed');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new RenewalLukeMedMail($recipientName));

        return response()->json(['message' => 'Renewal email sent successfully to ' . $emailAddress]);
    }
    

public function sendCsvEmail(Request $request)
{
    // The CSV data sent from the client
    $csvData = $request->input('csvData');
    
    // Convert the URI-encoded CSV string back to a CSV format
    $csvData = urldecode($csvData);

    // Prepare recipient name or any other data needed for the email
    $recipientName = 'Name Here';

    // Send the email with the CSV data attached
    Mail::to('calvin@medishure.com')->send(new RenewalLukeMedMail($csvData, $recipientName));

    return response()->json(['message' => 'Email sent successfully!']);
}

    
    private function generateCsvData()
{
    $fileName = 'Renewals.csv';

    // Initialize the output buffer and open it for writing
    $output = fopen('php://temp', 'r+');

    // Column headers
    $headers = ['Membership Number', 'Client\'s Name','Renewal Date','Contact Number','Personal Email Address', 'Group Name','Case Officer', 'Premium USD','Account'];

    // Write the headers to the output
    fputcsv($output, $headers);

    // Here, instead of a static example, you would fetch your data from the database
    $renewals = Accountsection_2024::all(); // Assuming you have a Renewal model and each renewal corresponds to the data you want to export

    // Loop through the data and write to the output buffer
    foreach ($renewals as $renewal) {
        $line = [
            $renewal->membership,
            $renewal->full,
            $renewal->renewal_date,
            $renewal->contact_number,
            $renewal->applicant_email_address,
            $renewal->group_name,
            $renewal->case_officer,
            $renewal->convert_premium_USD,
            $renewal->account
        ];
        fputcsv($output, $line);
    }

    // Rewind the buffer and read its contents into a variable
    rewind($output);
    $csvData = stream_get_contents($output);
    fclose($output);

    // Return the CSV content
    return $csvData;
}



//renewals per month Controller 



public function renewals_per_month(Request $request)
{
    $group_identifier = $request->query('group_identifier');

    $group_name = $request->query('group_name');

    $case_officer = $request->query('case_officer');


    $query_2023 = Accountsection_2023::select('id', 'membership', 'full', 'renewal_date', 'case_officer', 'email_address', 'contact_number', 'applicant_email_address', 'account', 'group_name', 'convert_premium_USD', 'group_identifier', 'start_date', 'case_officer_2023')
    // ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year

    ->where('group_name', '!=', '')
    ->where('insurance_type', 'IPMI')
    ->where('policy', 'Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                        ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
              });
    })
    ->orWhere(function ($query) use ($request) { // Use "orWhere" for the second condition
        $query    ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year


        // ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
              ->where(function ($query) { // Add a condition for blank or null group_name
                  $query->where('group_name', '=', '') // Blank group_name
                        ->orWhereNull('group_name'); // Null group_name
              })
              ->where('insurance_type', 'IPMI')
              ->where('policy', 'Active')
              ->where(function ($query) use ($request) { // Pass $request into the closure
                  $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
                        ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
                        ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                            $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                                  ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
                        });
              });
    });
    $query_2024 = Accountsection_2024::select('id','membership','full','renewal_date','case_officer','email_address','contact_number','applicant_email_address','account','group_name','convert_premium_USD','group_identifier','start_date','case_officer_2024')
    // ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year
    ->where('group_name', '!=', '') // Not equal to blank group_name
    ->where('insurance_type','IPMI')
    ->where('policy','Active')
    ->where(function ($query) use ($request) { // Pass $request into the closure
        $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
              ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
              ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                  $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing']) 
                        ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
              });
    })
    ->orWhere(function ($query) use ($request) { // Use "orWhere" for the second condition
        $query    ->whereYear('renewal_date', date('Y')) // Only consider renewal dates in the current year


        // ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
        ->where(function ($query) { // Add a condition for blank or null group_name
            $query->where('group_name', '=', '') // Blank group_name
                  ->orWhereNull('group_name'); // Null group_name
        })                  ->where('insurance_type', 'IPMI')
              ->where('policy', 'Active')
              ->where(function ($query) use ($request) { // Pass $request into the closure
                  $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
                        ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
                        ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
                            $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing'])
                                  ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
                        });
              });
    });

    if (!empty($group_identifier)) {
        $query_2023->where('group_identifier', $group_identifier);
        $query_2024->where('group_identifier', $group_identifier);
    }
    if (!empty($group_name)) {
        $query_2023->where('group_name', $group_name);
        $query_2024->where('group_name', $group_name);
    }
    if (!empty($case_officer)) {
        $query_2023->where('case_officer', $case_officer);
        $query_2024->where('case_officer', $case_officer);
    }

    $query_2023 = $query_2023->toBase();
    $query_2024 = $query_2024->toBase();

    $query_2023->addSelect('case_officer_2023 as case_officer_renewals');
    $query_2024->addSelect('case_officer_2024 as case_officer_renewals');
    $combinedQuery = $query_2023->unionAll($query_2024);

    $renewals = DB::query()->fromSub($combinedQuery, 'combined')->get();


        // Get the distinct values for the filters from both years
$group_identifiers_2023 = Accountsection_2023::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
->where('insurance_type','IPMI')
->where('policy','Active')
->where(function ($query) use ($request) { // Pass $request into the closure
    $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
          ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
          ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
              $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                    ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
          });
})->pluck('group_identifier');
$group_names_2023 = Accountsection_2023::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
->where('insurance_type','IPMI')
->where('policy','Active')
->where(function ($query) use ($request) { // Pass $request into the closure
    $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
          ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
          ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
              $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                    ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
          });
})->pluck('group_name');
$case_officers_2023 = Accountsection_2023::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
->where('insurance_type','IPMI')
->where('policy','Active')
->where(function ($query) use ($request) { // Pass $request into the closure
    $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
          ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
          ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
              $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
                    ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
          });
})->pluck('case_officer');

$group_identifiers_2024 = Accountsection_2024::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
->where('insurance_type','IPMI')
->where('policy','Active')
->where(function ($query) use ($request) { // Pass $request into the closure
    $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
          ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
          ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
              $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing'])
                    ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
          });
})->pluck('group_identifier');
$group_names_2024 = Accountsection_2024::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
->where('insurance_type','IPMI')
->where('policy','Active')
->where(function ($query) use ($request) { // Pass $request into the closure
    $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
          ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
          ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
              $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing']) 
                    ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
          });
})->pluck('group_name');
$case_officers_2024 = Accountsection_2024::distinct()->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
->where('insurance_type','IPMI')
->where('policy','Active')
->where(function ($query) use ($request) { // Pass $request into the closure
    $query->whereIn('lives_2024', ['New Lives', 'New Lives and Existing'])
          ->whereBetween('placement_date', ['2024-01-01', '2024-12-31'])
          ->orWhere(function ($query) use ($request) { // Pass $request into the nested closure as well
              $query->whereIn('lives_2024', ['Existing', 'New Lives and Existing']) 
                    ->whereBetween('start_date', ['2024-01-01', '2024-12-31']);
          });
})->pluck('case_officer');

// Combine and get unique values across both years
$Group_Identifierfilter = $group_identifiers_2023->merge($group_identifiers_2024)->unique()->values();
$Group_Namefilter = $group_names_2023->merge($group_names_2024)->unique()->values();
$Case_Officerfilter = $case_officers_2023->merge($case_officers_2024)->unique()->values();


    return view('2023.Notification.renewals_per_month', compact('renewals', 'Group_Identifierfilter','Group_Namefilter','Case_Officerfilter'));
}























    public function age()
    {
        $data = DB::table('accountsection_2023')
            ->select('group_name', DB::raw('COUNT(birthday) as count'))
            ->whereBetween('birthday', ['1900-01-01', '1961-12-31'])
            ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
            ->groupBy('group_name')
            ->get();

        $total = DB::table('accountsection_2023')
        ->select('group_name', DB::raw('COUNT(birthday) as count'))
        ->whereBetween('birthday', ['1900-01-01', '1961-12-31'])
        ->whereBetween('start_date', ['2023-01-01', '2023-12-31'])
        ->count();
        return view('2023.Notification.age', ['data' => $data, 'total' =>$total]);
    }

    // ---------------------====================-----------------------------
    //this is without the url query ==============this is without the url query =================this is without the url query 
    // public function birthday()
    // {
    //     $currentDate = date('Y-m-d');
    
    //     $birthdays = DB::table('accountsection_2023')
    //     ->where('policy', 'Active')
    //     ->where('insurance_type','IPMI')
    //     ->whereRaw('MONTH(current_date) = MONTH(birthday) AND DAY(current_date) <= DAY(birthday)')
    //     ->where(function ($query) {
    //         $query->whereIn('lives_2023', ['New Lives', 'New Lives and Existing'])
    //               ->whereBetween('placement_date', ['2023-01-01', '2023-12-31'])
    //               ->orWhere(function ($query) {
    //                   $query->whereIn('lives_2023', ['Existing', 'New Lives and Existing'])
    //                         ->whereBetween('start_date', ['2023-01-01', '2023-12-31']);
    //               });
    //     })
    //     ->get();
    
    
    //     // Calculate age for each birthday
    //     $ageBirthdays = $birthdays->map(function ($birthday) {
    //         $birthDate = new \DateTime($birthday->birthday);
    //         $currentDate = new \DateTime();
    //         $age = $currentDate->diff($birthDate)->y;
    //         $birthday->age = $age;
    //         return $birthday;
    //     });
    
    //     $count = $ageBirthdays->count();
    
    //     return view('2023.notification.birthday', compact('count', 'ageBirthdays','birthdays'));
    // }


    public function birthday(Request $request)
    {
        $currentDate = date('Y-m-d');
        // Retrieve the 'account' query parameter from the request
        $account = $request->query('account');
    
    // Define base query for 2023
    $query_2023 = Accountsection_2023::select('membership', 'full', 'birthday', 'applicant_email_address', 'account')
        ->where('policy', 'Active')
        ->whereIn('account', ['Jusmedical Sdn Bhd', 'Rig Associates Pte Ltd', 'Bricon Associates Pte Ltd', 'Bricon Associates','PT Luke Medikal Internasional','Juscall International Inc','Luke International Consultant Company Ltd',
                    'PT Luke Medikal Internasional','Juscall Insurance Agency Inc','Luke Medical Pte Ltd','Medishure Global'])
        ->where('insurance_type', 'IPMI')
        ->whereRaw('MONTH(current_date) = MONTH(birthday) AND DAY(current_date) <= DAY(birthday)')
        ->when($account, function ($query) use ($account) {
            if ($account !== '') {
                $query->where('account', $account);
            }
        });

    // Define base query for 2024 with the same logic
    $query_2024 = Accountsection_2024::select('membership', 'full', 'birthday', 'applicant_email_address', 'account')
        ->where('policy', 'Active')
        ->whereIn('account', ['Jusmedical Sdn Bhd', 'Rig Associates Pte Ltd', 'Bricon Associates Pte Ltd', 'Bricon Associates','PT Luke Medikal Internasional','Juscall International Inc','Luke International Consultant Company Ltd',
                            'PT Luke Medikal Internasional','Juscall Insurance Agency Inc','Luke Medical Pte Ltd','Medishure Global'])
        ->where('insurance_type', 'IPMI')
        ->whereRaw('MONTH(current_date) = MONTH(birthday) AND DAY(current_date) <= DAY(birthday)')
        ->when($account, function ($query) use ($account) {
            if ($account !== '') {
                $query->where('account', $account);
            }
        });

            

    // Unionall is to display all data 
            // $query = $query_2024->unionall($query_2023);
    //Union is to display Distinct data
            $query = $query_2023->union($query_2024);



    
    // Apply the account filter if provided and not empty
    if ($request->has('account') && $request->query('account') != '') {
        $query->where('account', $request->query('account'));
    }
    
        // Execute the query
        $birthdays = $query->get();
    
        // Calculate age for each birthday
        $ageBirthdays = $birthdays->map(function ($birthday) {
            $birthDate = new \DateTime($birthday->birthday);
            $currentDate = new \DateTime();
            $age = $currentDate->diff($birthDate)->y;
            $birthday->age = $age;
            return $birthday;
        });
    
        $count = $ageBirthdays->count();
    
        // Ensure 'Accountfilter' data is being passed to the view correctly
        $Accountfilter = ['Jusmedical Sdn Bhd', 'Rig Associates Pte Ltd', 'Bricon Associates Pte Ltd', 'Bricon Associates','PT Luke Medikal Internasional','Juscall International Inc','Luke International Consultant Company Ltd',
                        'PT Luke Medikal Internasional','Juscall Insurance Agency Inc','Luke Medical Pte Ltd','Medishure Global']; // Add or query this from the database as needed
    
        // Return the view with necessary data
        return view('2023.Notification.birthday', compact('count', 'ageBirthdays', 'birthdays', 'Accountfilter'));
    }
    public function sendEmail(Request $request)
    {
        $emailAddress = $request->email;
        $recipientName = $request->name;
        $account = $request->account;

        // Determine which email to send based on the account
        if ($account === 'Jusmedical Sdn Bhd') {
            // Send email using Medishure settings
            Mail::to($emailAddress)->send(new HappyBirthdayMail($recipientName));
        } elseif ($account === 'Bricon Associates Pte Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new HappyBirthdayRigMail($recipientName));
        } elseif ($account === 'Rig Associates Pte Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new HappyBirthdayBriconMail($recipientName));
        } elseif ($account === 'Luke Medical Pte Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new HappyBirthdayLukeMedMail($recipientName));  
        } elseif ($account === 'Luke International Consultant Company Ltd') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new HappyBirthdayLukeInternationalMail($recipientName)); 
        } elseif ($account === 'PT Luke Medikal Internasional') {
            // Send email using Bricon settings
            Mail::to($emailAddress)->send(new HappyBirthdayLukeMedikalMail($recipientName));     
        } else {
            // Optionally handle other cases or log an error
            return response()->json(['error' => 'Unrecognized account'], 422);
        }

        return response()->json(['message' => 'Email sent successfully to ' . $emailAddress]);
    }
    

    public function sendBirthdayEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to primary SMTP configuration (smtp)
        Config::set('mail.default', 'smtp');

        // Send email using primary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }

    public function sendBirthdaybriconEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_bricon)
        Config::set('mail.default', 'smtp_bricon');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayBriconMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }

    public function sendBirthdayRigEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_bricon)
        Config::set('mail.default', 'smtp_rig');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayRigMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }
    public function sendBirthdayLukeMedEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_bricon)
        Config::set('mail.default', 'smtp_lukemed');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayLukeMedMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }


    public function sendBirthdayJuscallEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_bricon)
        Config::set('mail.default', 'smtp_juscall');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayJuscallMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }
    public function sendBirthdayLukeMedikalEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_bricon)
        Config::set('mail.default', 'smtp_lukemedikal');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayLukeMedikalMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }
    public function sendBirthdayLukeInternationalEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $emailAddress = $request->email;
        $recipientName = $request->name;

        // Set to secondary SMTP configuration (smtp_lukeinternational)
        Config::set('mail.default', 'smtp_lukeinternational');

        // Send email using secondary SMTP
        Mail::to($emailAddress)->send(new HappyBirthdayLukeInternationalMail($recipientName));

        return response()->json(['message' => 'Happy Birthday email sent successfully to ' . $emailAddress]);
    }





    
}