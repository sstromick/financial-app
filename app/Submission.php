<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Submission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'submission_type', 'reason', 'first_name', 'last_name', 'address_line_1', 'address_line_2', 'city', 'state', 'zip', 'phone', 'income_dependents', 'gross_employment_income', 'net_employment_income', 'self_employment_income', 'benefits_income', 'retirement_income', 'social_security_income', 'pension_income', 'other_income', 'ssn', 'co_applicant_first_name', 'co_applicant_last_name', 'co_applicant_ssn', 'co_applicant_address_line_1', 'co_applicant_address_line_2', 'co_applicant_city', 'co_applicant_state', 'co_applicant_zip', 'co_applicant_email', 'bankruptcy_session_time', 'credit_approval', 'credit_approval_at', 'counseling_approval', 'counseling_approval_at', 'bankruptcy_approval', 'bankruptcy_approval_at', 'ip_address', 'accept_bankruptcy_disclosure', 'military', 'accept_statement_of_counseling', 'message', 'selected_incomes', 'selected_expenses', 'credit_pull', 'last_saved_step', 'steps_namespace', 'referrer', 'referrer_tag_id', 'joint_coapplicant',
        'date_of_birth', 'co_applicant_date_of_birth', 'co_applicant_email'
    ];

    /**
     * Get the user that submitted the submission.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the payment record associated with the submission.
     */
    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    /**
     * Get the expense(s) associated with the submission.
     */
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    /**
     * Get the credit account(s) associated with the submission.
     */
    public function creditAccounts()
    {
        return $this->hasMany('App\CreditAccount');
    }

    /**
     * Get the expense record(s) associated with the submission.
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getBenefitsIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getGrossEmploymentIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getNetEmploymentIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getSelfEmploymentIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getRetirementIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getSocialSecurityIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getPensionIncomeAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getOtherIncomeAttribute($value)
    {
        return round($value);
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::parse($value)->format('Y/m/d');
    }

    public function getDateOfBirthAttribute($value)
    {
        if ($value)
            return Carbon::parse($value)->format('m/d/Y');
        else
            return null;
    }

    public function setCoApplicantDateOfBirthAttribute($value)
    {
        $this->attributes['co_applicant_date_of_birth'] = Carbon::parse($value)->format('Y/m/d');
    }

    public function getCoApplicantDateOfBirthAttribute($value)
    {
        if ($value)
            return Carbon::parse($value)->format('m/d/Y');
        else
            return null;
    }
}
