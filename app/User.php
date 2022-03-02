<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'has_password', 'has_email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the submission record associated with the user.
     */
    public function submission()
    {
        return $this->hasOne('App\Submission');
    }

    /**
     * Get the expense(s) associated with the user submission.
     */
    public function expenses()
    {
        return $this->hasManyThrough('App\Expense', 'App\Submission');
    }

    /**
     * Get the files(s) associated with the user submission.
     */
    public function files()
    {
        return $this->hasManyThrough('App\File', 'App\Submission');
    }

    /**
     * Get the credit account(s) associated with the user submission.
     */
    public function creditAccounts()
    {
        return $this->hasManyThrough('App\CreditAccount', 'App\Submission');
    }

    /**
     * Get the payment associated with the user submission.
     */
    public function payment()
    {
        return $this->hasOneThrough('App\Payment', 'App\Submission');
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        if ($this->is_admin == 1) {
            return true;
        }

        return false;
    }

    /**
     * Check if user is not an admin
     */
    public function isUser()
    {
        if ($this->is_admin == 0) {
            return true;
        }

        return false;
    }

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }
}