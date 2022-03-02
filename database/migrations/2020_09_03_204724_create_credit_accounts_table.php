<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained();
            $table->string('account_number')->nullable();
            $table->string('creditor')->nullable();
            $table->string('original_creditor')->nullable();
            $table->string('debt_type')->nullable();
            $table->decimal('balance_owed', 14, 2)->nullable();
            $table->decimal('asset_value', 14, 2)->nullable();
            $table->decimal('monthly_payment', 14, 2)->nullable();
            $table->decimal('interest_rate', 14, 2)->nullable();
            $table->boolean('past_due')->nullable();
            $table->boolean('joint_account')->nullable();
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
        Schema::dropIfExists('credit_accounts');
    }
}
