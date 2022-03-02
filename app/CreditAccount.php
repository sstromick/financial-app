<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditAccount extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id', 'creditor', 'original_creditor', 'debt_type', 'balance_owed', 'asset_value', 'monthly_payment', 'interest_rate', 'past_due', 'joint_account', 'account_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        '_token',
    ];

    /**
     * Get the submission that the credit account belongs to
     */
    public function submission()
    {
        return $this->belongsTo('App\Submission');
    }

    /**
     * Get the user that the credit account belongs to
     */
    public function user()
    {
        return $this->belongsToThrough('App\User', 'App\Submission');
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getBalanceOwedAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getAssetValueAttribute($value)
    {
        return round($value);
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getMonthlyPaymentAttribute($value)
    {
        return round($value);
    }
}
