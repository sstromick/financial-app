<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'API'], function () {
    Route::apiResources([
        'users' => UserController::class,
        'submissions' => SubmissionController::class,
        'credit-accounts' => CreditAccountController::class,
        'expenses' => ExpenseController::class,
        'files' => FileController::class,
        'payments' => PaymentController::class,
    ]);
    Route::post("/submissions-swagger", "SubmissionController@swaggerSubmit");
    Route::post("/credit-pull", "CreditAccountController@creditPull");
    Route::post("/infusionsoft-client", "SubmissionController@addInfusionsoftClient");
    Route::post("/infusionsoft-completion", "SubmissionController@addInfusionsoftCompletionTag");
});

Route::group(['namespace' => 'API'], function () {

    // Get current user model data
    Route::get('/user', 'UserController@current')->middleware('auth:api');

    // Get the submission for this user
    Route::get('/submission', 'SubmissionController@current')->middleware('auth:api');

    // Get most data related to this user
    // Route::get('/info', 'InfoController@all')->middleware('auth:api');

    // Get the valid submission reasons
    Route::get('/submission-reasons', 'InfoController@getSubmissionReasons');

    // Get the valid income types
    Route::get('/income-types', 'InfoController@getSubmissionIncomeTypes');

    Route::get('/expense-types', 'InfoController@getExpenseTypes');

    // Get the expense categories
    Route::get('/expense-categories', 'InfoController@getExpenseCategories');

    // Get the valid US states
    Route::get('/us-states', 'InfoController@getStates');

    // Get the valid credit account debt types
    Route::get('/credit-account-types', 'InfoController@getCreditAccountDebtTypes');
});

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware(['guest'])->name('password.email');

// Handle the reset password form submission
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) use ($request) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();

            $user->setRememberToken(Str::random(60));

            event(new PasswordReset($user));
        }
    );

    return $status == Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware(['guest'])->name('password.update');
