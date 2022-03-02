<?php

namespace App\Http\Controllers\API;

use App\Expense;
use App\ExpenseType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getExpenseTypeConfig', 'getExpenseCategories', 'getExpenseTypes', 'categories', 'types']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        if ($user_id) {

            $user = User::find($user_id);

            if ($user) {
                return $user->expenses;
            }
        }

        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->input('expense_category');
        $type = $request->input('expense_type');

        $data = $request->validate([
            'submission_id' => ['bail', 'required', 'integer'],
            'expense_category_id' => ['bail', 'required', 'integer'],
            'expense_category' => ['bail', 'required', 'string', Rule::in($this->getExpenseCategories())],
            'expense_type' => ['bail', 'required', 'string', Rule::in($this->getExpenseTypes($category))],
            'expense_value' => ['bail', 'required', 'numeric'],
        ]);

        $expenseType = ExpenseType::where([["category_id", $data['expense_category_id']], ["expense_type", $data['expense_type']]])->first();

        $exp = Expense::create([
            'submission_id' => $data['submission_id'],
            'expense_type' => $data['expense_type'],
            'expense_category' => $data['expense_category'],
            'expense_type_id' => $expenseType->id,
            'expense_value' => $data['expense_value'],
        ]);
        return new ExpenseResource($exp);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        // $data = $request->validate([
        //     'email' => 'required|email',
        // ]);
        $data = $request->validate([
            'submission_id' => ['bail', 'required', 'integer'],
            'expense_category' => ['bail', 'required', 'string', Rule::in($this->getExpenseCategories())],
            'expense_type' => ['bail', 'required', 'string', Rule::in($this->getExpenseTypes($category))],
            'expense_value' => ['bail', 'required', 'numeric'],
        ]);

        $expense->update($data);

        return new ExpenseResource($expense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response(null, 204);
    }

    /**
     * Get expense categories
     *
     * @return array|null
     */
    public function getExpenseTypeConfig()
    {
        return Config::get('field_values.expenses.expense_type');
    }

    /**
     * Get expense categories
     *
     * @return array|null
     */
    public function getExpenseCategories()
    {
        $expenseCategories = $this->getExpenseTypeConfig();
        if (!empty($expenseCategories)) {
            return array_keys($expenseCategories);
        }

        return;
    }

    /**
     * Get expense types for an expense category
     * @param string category
     * @return array|null
     */
    public function getExpenseTypes($category)
    {
        $expenseCategories = $this->getExpenseTypeConfig();

        if (in_array($category, $this->getExpenseCategories(), true)) {
            return array_keys($expenseCategories[$category]['types']);
        }

        return;
    }
}
