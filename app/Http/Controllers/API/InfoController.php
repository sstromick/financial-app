<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Submission;
use App\Expense;
use App\CreditAccount;
use App\Payment;
use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Gathers/gets information from reference tables
class InfoController extends Controller
{
    /**
     * Get all of the user info
     *
     * @return array
     */
    public function all()
    {
        $user = Auth::user();
        $submission = Submission::with('user')->where('user_id', Auth::user()->id)->first();
        $payment = Payment::with('submission')->where('submission_id', $submission->id)->first();
        $expenses = Expense::with('submission')->where('submission_id', $submission->id)->get();
        $files = File::with('submission')->where('submission_id', $submission->id)->get();
        $creditAccounts = CreditAccount::with('submission')->where('submission_id', $submission->id)->get();

        return response()->json([
            'user' => $user,
            'submission' => $submission,
            'expenses' => $expenses,
            'files' => $files,
            'creditAccounts' => $creditAccounts,
            'payment' => $payment,
        ]);
    }

    /**
     * Get US state names and their postal codes
     *
     * @return array
     */
    public function getStates()
    {
        return DB::table('u_s_states')->get();
    }

    /**
     * Get expense categories
     * @return array
     */
    public function getExpenseCategories()
    {
        return DB::table('expense_categories')->get();
    }

    /**
     * Get expense types
     * @return array
     */
    public function getExpenseTypes()
    {
        return DB::table('expense_types')->get();
    }

    /**
     * Get submission reasons from table
     *
     * @return array
     */
    public function getSubmissionReasons()
    {
        return DB::table('submission_reasons')->get();
    }

    /**
     * Get income types
     *
     * @return array
     */
    public function getSubmissionIncomeTypes()
    {
        return DB::table('income_types')->get();
    }

    /**
     * Get credit account debt types
     *
     * @return array
     */
    public function getCreditAccountDebtTypes()
    {
        return DB::table('credit_account_types')->get();
    }
}
