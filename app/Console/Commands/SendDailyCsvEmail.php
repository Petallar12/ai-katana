<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Mail\RenewalLukeMedMail;
use App\Models\Accountsection_2024;

use App\Models\Accountsection_2023;
use Mail;

class SendDailyCsvEmail extends Command
{
    protected $signature = 'email:senddaily';
    protected $description = 'Send a daily CSV email at midnight';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Generate the CSV data
        $csvData = $this->generateCsvData(); // Use your existing method

        // Recipient name for the email
        $recipientName = 'Calvin Petallar';

        // Recipient email address
        $recipientEmail = 'calvin@medishure.com';

        // Send the email with the CSV data attached
        Mail::to($recipientEmail)->send(new RenewalLukeMedMail($csvData, $recipientName));

        $this->info('Daily CSV email has been sent.');
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


    $renewals_2023 = Accountsection_2023::select('membership', 'full', 'renewal_date', 'contact_number', 'applicant_email_address', 'group_name', 'case_officer', 'convert_premium_USD', 'account')
    ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->whereIn('account', ['Jusmedical Sdn Bhd', 'Rig Associates Pte Ltd', 'Bricon Associates Pte Ltd', 'Bricon Associates','PT Luke Medikal Internasional','Juscall International Inc','Luke International Consultant Company Ltd',
                            'PT Luke Medikal Internasional','Juscall Insurane Agency Inc','Luke Medical Pte Ltd','Medishure Global'])
    ->where('policy','Active')
    ->get();
    
    $renewals_2024 = Accountsection_2024::select('membership', 'full', 'renewal_date', 'contact_number', 'applicant_email_address', 'group_name', 'case_officer', 'convert_premium_USD', 'account')
    ->whereRaw('month(current_date) = month(renewal_date) - 3 and year(current_date) = year(renewal_date)')
    ->where('insurance_type','IPMI')
    ->whereIn('account', ['Jusmedical Sdn Bhd', 'Rig Associates Pte Ltd', 'Bricon Associates Pte Ltd', 'Bricon Associates','PT Luke Medikal Internasional','Juscall International Inc','Luke International Consultant Company Ltd',
                            'PT Luke Medikal Internasional','Juscall Insurane Agency Inc','Luke Medical Pte Ltd','Medishure Global'])
    ->where('policy','Active')
    ->get();


    $combinedQuery = $renewals_2024->merge($renewals_2023);

    // Loop through the data and write to the output buffer
    foreach ($renewals_2023 as $renewal) {
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
}
