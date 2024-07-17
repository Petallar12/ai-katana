<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claims extends Model
{
use HasFactory;
protected $table ='claims';
protected $primaryKey ='id';
protected $fillable = [
    'claim_id', 'user_id', 'type', 'status', 'date_received', 'complete_name', 'policy_number', 'policy_holder', 'policy_currency', 'insurer_id', 'broker', 'referrence_number', 'nature_of_claim', 'provider_name', 'doctor_name', 'invoice_number', 'invoice_date', 'breakdown', 'total_amount', 'currency', 'claim_number', 'unpaid_amount', 'paid_amount', 'paid_amount_in_usd', 'paid_to', 'claim_age', 'date_submitted', 'reason_of_rejection', 'remarks', 'date_updated', 'created_at', 'updated_at'
];
// In Claim model
public function accountSection()
{
    return $this->belongsTo(Accountsection_2024::class, 'full', 'complete_name');
}
}
