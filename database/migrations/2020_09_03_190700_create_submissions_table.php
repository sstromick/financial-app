<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->unique();

            $table->string('submission_type')->nullable();
            $table->string('reason')->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();

            $table->integer('income_dependents')->nullable();
            $table->decimal('gross_employment_income')->nullable();
            $table->decimal('net_employment_income')->nullable();
            $table->decimal('self_employment_income')->nullable();
            $table->decimal('benefits_income')->nullable();
            $table->decimal('retirement_income')->nullable();
            $table->decimal('social_security_income')->nullable();
            $table->decimal('pension_income')->nullable();
            $table->decimal('other_income')->nullable();
            $table->string('ssn')->nullable()->unique(); // @TODO: Make encrypted

            $table->string('co_applicant_first_name')->nullable();
            $table->string('co_applicant_last_name')->nullable();
            $table->string('co_applicant_email')->nullable()->unique();
            $table->string('co_applicant_ssn')->nullable()->unique(); // @TODO: Make encrypted
            $table->string('co_applicant_address_line_1')->nullable();
            $table->string('co_applicant_address_line_2')->nullable();
            $table->string('co_applicant_city')->nullable();
            $table->string('co_applicant_state')->nullable();
            $table->string('co_applicant_zip')->nullable();

            $table->decimal('bankruptcy_session_time')->nullable();
            $table->boolean('credit_approval')->nullable();
            $table->timestamp('credit_approval_at')->nullable();
            $table->boolean('counseling_approval')->nullable();
            $table->timestamp('counseling_approval_at')->nullable();
            $table->boolean('bankruptcy_approval')->nullable();
            $table->timestamp('bankruptcy_approval_at')->nullable();

            $table->boolean('accept_bankruptcy_disclosure')->nullable();
            $table->boolean('military')->nullable();
            $table->boolean('accept_statement_of_counseling')->nullable();
            $table->string('message')->nullable();

            $table->string('ip_address')->nullable();
            $table->text('selected_incomes')->nullable();
            $table->text('selected_expenses')->nullable();
            $table->boolean('credit_pull')->default(false);
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
