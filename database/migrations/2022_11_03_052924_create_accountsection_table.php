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
        Schema::create('accountsection', function (Blueprint $table) {
            $table->id();
            $table->string('title', 15)->nullable(); 
            $table->string('compliance', 5)->nullable();
            $table->string('membership', 50)->nullable();
            $table->string('full', 50)->nullable();
            $table->string('first',25)->nullable();
            $table->string('family', 25)->nullable();
            $table->string('insurer', 25)->nullable();
            $table->string('cover', 150)->nullable();
            $table->string('product_type', 100)->nullable();
            $table->string('payment', 20)->nullable();
            $table->string('policy', 25)->nullable();
            $table->string('country_nationality', 80)->nullable();
            $table->string('country_residence', 80)->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('age', 5)->nullable();
            $table->string('group_name', 100)->nullable();
            $table->string('group_number', 40)->nullable();
            $table->string('type_applicant',30 )->nullable();
            $table->string('main_applicant_deps', 70)->nullable();
            $table->date('original_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->string('contact_number', 50)->nullable();
            $table->string('applicant_email_address', 100)->nullable();
            $table->string('email_address', 100)->nullable();
            $table->string('subscription_currency', 50)->nullable();
            $table->string('mode_payment', 50)->nullable();
            $table->string('payment_frequency', 40)->nullable();
            $table->float('pro_rated_premium')->unsigned()->nullable();
            $table->float('premium')->unsigned()->nullable();
            $table->string('active_premium', 40)->nullable();
            $table->string('active_premium_not_paid', 40)->nullable();
            $table->string('frequency_premium', 40)->nullable();
            $table->string('case_closed', 50)->nullable();
            $table->string('residence', 200)->nullable();
            $table->string('mailing_address', 250)->nullable();
            $table->string('renewal_month', 20)->nullable();
            $table->string('renewal_year', 5)->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('case_officer', 50)->nullable();
            $table->string('placement_done', 50)->nullable();
            $table->date('placement_date')->nullable();
            $table->string('account', 50)->nullable();
            $table->string('account_code', 50)->nullable();
            $table->string('percentage_commission', 10)->nullable();
            $table->string('commission_received', 50)->nullable();
            $table->string('commission_received_in_USD', 50)->nullable();
            $table->string('bank_account_commission', 50)->nullable();
            $table->string('confirmation_commission_received', 50)->nullable();
            $table->string('commission_discount', 50)->nullable();
            $table->string('source_inquiry', 100)->nullable();
            $table->string('sub_agents_name', 50)->nullable();
            $table->string('sub_agent_percentage',30 )->nullable();
            $table->string('commission_paid', 50)->nullable();
            $table->string('referral_name', 60)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('referral_percentage',30 )->nullable();
            $table->string('net_commission', 50)->nullable();
            $table->string('estimated_premium', 50)->nullable();
            $table->string('convert_premium_USD', 50)->nullable();
            $table->date('placement_date2')->nullable();
            $table->string('credentials', 100)->nullable();
            $table->string('dental', 5)->nullable();
            $table->string('maternity', 5)->nullable();
            $table->string('room_discount', 5)->nullable();
            $table->string('direct_billing', 5)->nullable();
            $table->string('bc14', 5)->nullable();
            $table->string('area_cover', 200)->nullable();
            $table->string('application_email', 150)->nullable();
            $table->string('confirmation_email', 150)->nullable();
            $table->string('invoice', 90)->nullable();
            $table->string('payment_status', 100)->nullable();
            $table->string('payment_follow', 60)->nullable();
            $table->string('ccdc', 30)->nullable();
            $table->string('ccn', 30)->nullable();
            $table->string('cc_holder_name', 50)->nullable();
            $table->string('relationship', 150)->nullable();
            $table->date('cc_exp' )->nullable();
            $table->string('vvc', 60)->nullable();
            $table->string('issuing_bank', 60)->nullable();
            $table->string('bank_account', 60)->nullable();
            $table->date('running_date')->nullable();
            $table->string('remarks', 200)->nullable();
            $table->string('lives_2022',20 )->nullable();
            $table->float('commission_2022')->unsigned()->nullable();
            $table->date('start_2022')->nullable();
            $table->string('commission_paid_sub_2022', 30)->nullable();
            $table->string('encoded_by', 40)->nullable();
            $table->string('if_there_is_loading', 100)->nullable();
            $table->string('percentage_loading_2022', 50)->nullable();
            $table->string('company_product_discount', 50)->nullable();
            $table->string('renewal_discount_2022',50)->nullable();
            $table->string('further_discount', 50)->nullable();
            $table->string('total_members_2022', 70)->nullable();
            $table->string('case_officer_2022', 50)->nullable();
            $table->string('renewal_follow_up',50 )->nullable();
            $table->string('payment_date_subagents_commission', 50)->nullable();
            $table->string('status', 40)->nullable();
            $table->string('missing_remarks', 250)->nullable();
            $table->string('cancelled_remarks', 250)->nullable();
            $table->string('secondary_personal_email', 100)->nullable();
            $table->string('secondary_contact_person_email', 100)->nullable();
            $table->string('secondary_contact_number', 50)->nullable();
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
        Schema::dropIfExists('accountsection');
    }
};
