<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accountsection_travel extends Model
{
    use HasFactory;
    protected $table ='accountsection_travel';
    protected $primaryKey ='id';
    protected $fillable = [
        'membership',
        'full',
        'group_name',
        'gender',
        'birthday',
        'age',
        'country_nationality',
        'country_residence',
        'residence',
        'contact',
        'secondary_contact',
        'email_address',
        'secondary_email_address',
        'applicant_type',
        'client_status',
        'insurer',
        'cover',
        'policy',
        'start_date',
        'end_date',
        'cancellation_date',
        'reason_cancellation',
        'subscription_currency',
        'premium_paid',
        'premium_paid_USD',
        'commission_percentage',
        'commission_received',
        'case_closed',
        'renewal_date',
        'handled_by',
        'broker_account',
        'credentials',
        'placement_handled_by',
        'placement_date',
        'payment_status',
        'source_inquiry',
        'referral_name',
        'encoded_by',
        'encoded_data_status',
        'remarks',
        'updated_by',
        'area_cover',
        'main_applicant_deps',
        'missing_remarks'
        
    ];
    
}
