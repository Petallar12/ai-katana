<?php

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountsection_2023', function (Blueprint $table) {            
                $table->id();
                $table->string('title', 12)->nullable();
                $table->string('membership', 50)->nullable();
                $table->string('full', 100)->nullable();
                $table->string('first', 55)->nullable();
                $table->string('family', 55)->nullable();
                $table->string('insurer', 44)->nullable();
                $table->string('cover', 200)->nullable();
                $table->string('product_type', 255)->nullable();
                $table->string('payment', 55)->nullable();
                $table->string('policy', 44)->nullable();
                $table->string('country_nationality', 55)->nullable();
                $table->string('country_residence', 55)->nullable();
                $table->string('gender', 33)->nullable();
                $table->date('birthday')->nullable();
                $table->string('age', 3)->nullable();
                $table->string('group_name', 100)->nullable();
                $table->string('group_number', 55)->nullable();
                $table->string('type_applicant', 55)->nullable();
                $table->string('main_applicant_deps', 100)->nullable();
                $table->date('original_date')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->date('cancelled_date')->nullable();
                $table->string('contact_number', 55)->nullable();
                $table->string('applicant_email_address', 200)->nullable();
                $table->string('email_address', 200)->nullable();
                $table->string('subscription_currency', 55)->nullable();
                $table->string('mode_payment', 55)->nullable();
                $table->string('payment_frequency', 22)->nullable();
                $table->float('pro_rated_premium')->unsigned()->nullable();
                $table->float('premium')->unsigned()->nullable();
                $table->float('active_premium')->unsigned()->nullable();
                $table->float('active_premium_not_paid')->unsigned()->nullable();
                $table->float('frequency_premium')->unsigned()->nullable();
                $table->string('case_closed', 33)->nullable();
                $table->string('residence', 200)->nullable();
                $table->string('mailing_address', 200)->nullable();
                $table->string('renewal_month', 22)->nullable();
                $table->string('renewal_year', 4)->nullable();
                $table->date('renewal_date')->nullable();
                $table->string('case_officer', 29)->nullable();
                $table->string('placement_done', 33)->nullable();
                $table->date('placement_date')->nullable();
                $table->string('account', 33)->nullable();
                $table->string('account_code', 12)->nullable();
                $table->string('percentage_commission', 11)->nullable();
                $table->string('commission_received', 19)->nullable();
                $table->float('commission_received_in_USD')->unsigned()->nullable();
                $table->string('bank_account_commission', 32)->nullable();
                $table->string('confirmation_commission_received', 40)->nullable();
                $table->string('commission_discount', 19)->nullable();
                $table->string('source_inquiry', 17)->nullable();
                $table->string('sub_agents_name', 33)->nullable();
                $table->string('sub_agent_percentage', 31)->nullable();
                $table->string('commission_paid', 28)->nullable();
                $table->string('referral_name', 55)->nullable();
                $table->string('website', 100)->nullable();
                $table->string('referral_percentage', 30)->nullable();
                $table->string('net_commission', 14)->nullable();
                $table->string('estimated_premium', 25)->nullable();
                $table->string('convert_premium_USD', 50)->nullable();
                $table->date('placement_date2')->nullable();
                $table->string('credentials', 100)->nullable();
                $table->string('dental', 11)->nullable();
                $table->string('maternity', 11)->nullable();
                $table->string('room_discount', 11)->nullable();
                $table->string('direct_billing', 11)->nullable();
                $table->string('bc14', 11)->nullable();
                $table->string('area_cover', 200)->nullable();
                $table->string('application_email', 120)->nullable();
                $table->string('confirmation_email', 120)->nullable();
                $table->string('invoice', 14)->nullable();
                $table->string('payment_status', 14)->nullable();
                $table->string('payment_follow', 22)->nullable();
                $table->string('remarks', 200)->nullable();
                $table->string('lives_2023', 22)->nullable();
                $table->float('commission_2023')->unsigned()->nullable();
                $table->date('start_2023')->nullable();
                $table->string('commission_paid_sub_2023', 32)->nullable();
                $table->string('encoded_by', 22)->nullable();
                $table->string('percentage_loading_2023', 100)->nullable();
                $table->string('company_product_discount', 24)->nullable();
                $table->string('renewal_discount_2023', 100)->nullable();
                $table->string('further_discount', 16)->nullable();
                $table->string('total_members_2023', 18)->nullable();
                $table->string('case_officer_2023', 34)->nullable();
                $table->string('renewal_follow_up', 22)->nullable();
                $table->string('payment_date_subagents_commission', 38)->nullable();
                $table->string('status', 40)->nullable();
                $table->string('missing_remarks', 250)->nullable();
                $table->string('cancelled_remarks', 250)->nullable();        
                $table->string('secondary_personal_email', 100)->nullable();
                $table->string('secondary_contact_person_email', 100)->nullable();
                $table->string('secondary_contact_number', 50)->nullable();
                $table->string('insurance_type', 25)->nullable();  
                $table->string('updated_by', 50)->nullable();
                $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accountsection_2023'); 
    }
}; 
