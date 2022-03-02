<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id', 'uid', 'approved',
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
     * Get the submission that the payment belongs to
     */
    public function submission()
    {
        return $this->belongsTo('App\Submission');
    }

    /**
     * Get the user that the payment belongs to
     */
    public function user()
    {
        return $this->belongsToThrough('App\User', 'App\Submission');
    }
}
