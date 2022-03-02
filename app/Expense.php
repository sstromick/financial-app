<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $with = ['expenseType'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id', 'expense_type', 'expense_value', 'expense_type_id'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the submission that the expense belongs to
     */
    public function submission()
    {
        return $this->belongsTo('App\Submission');
    }

    /**
     * Get the expense type that the expense belongs to
     */
    public function expenseType()
    {
        return $this->belongsTo('App\ExpenseType');
    }

    /**
     * Get the user that the expense belongs to
     */
    public function user()
    {
        return $this->belongsToThrough('App\User', 'App\Submission');
    }

    /**
     * Round value to whole number when retrieved from db.
     */
    public function getExpenseValueAttribute($value)
    {
        return round($value);
    }
}
