<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id', 'filename', 'mime', 'path', 'size', 'extension', 'original_filename',
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
     * Get the submission that the file belongs to
     */
    public function submission()
    {
        return $this->belongsTo('App\Submission');
    }

    /**
     * Get the user that the file belongs to
     */
    public function user()
    {
        return $this->belongsToThrough('App\User', 'App\Submission');
    }
}
