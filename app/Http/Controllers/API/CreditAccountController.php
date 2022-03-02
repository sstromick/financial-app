<?php

namespace App\Http\Controllers\API;

use App\CreditAccount;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\CreditAccountResource;
use App\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Config;
use Illuminate\Support\Facades\Http;
use Log;
use Carbon\Carbon;


class CreditAccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getCreditAccountConfig', 'getDebtTypes']]);
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
                return $user->creditAccounts->sortBy("debt_type");
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
        $data = $request->validate([
            'submission_id' => ['integer'],
            'account_number' => ['nullable', 'string'],
            'creditor' => ['nullable', 'string'],
            'original_creditor' => ['nullable', 'string'],
            'debt_type' => ['nullable', 'string'],
            'balance_owed' => ['nullable', 'numeric'],
            'asset_value' => ['nullable', 'numeric'],
            'monthly_payment' => ['nullable', 'numeric'],
            'interest_rate' => ['nullable', 'numeric'],
            'past_due' => ['nullable', 'boolean'],
            'joint_account' => ['nullable', 'boolean'],
        ]);

        $create = array_filter($data);

        return new CreditAccountResource(CreditAccount::create($create));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CreditAccount  $creditAccount
     * @return \Illuminate\Http\Response
     */
    public function show(CreditAccount $creditAccount)
    {
        return new CreditAccountResource($creditAccount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CreditAccount  $creditAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditAccount $creditAccount)
    {
        $data = $request->validate([
            'submission_id' => ['required', 'integer'],
            'account_number' => ['nullable', 'string'],
            'creditor' => ['nullable', 'string'],
            'original_creditor' => ['nullable', 'string'],
            'debt_type' => ['nullable', 'string'],
            'balance_owed' => ['nullable', 'numeric'],
            'asset_value' => ['nullable', 'numeric'],
            'monthly_payment' => ['nullable', 'numeric'],
            'interest_rate' => ['nullable', 'numeric'],
            'past_due' => ['nullable', 'boolean'],
            'joint_account' => ['nullable', 'boolean'],
        ]);

        // Remove any empty fields, so they don't wipe out existing data
        $update = array_filter($data);

        $creditAccount->update($update);
        return new CreditAccountResource($creditAccount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CreditAccount  $creditAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditAccount $creditAccount)
    {
        $creditAccount->delete();
        return response(null, 204);
    }

    /**
     * Get credit account categories
     *
     * @return array|null
     */
    public function getCreditAccountConfig()
    {
        return Config::get('field_values.credit_accounts');
    }

    /**
     * Get different debt categories
     *
     * @return array|null
     */
    public function getDebtTypes()
    {
        $config = $this->getCreditAccountConfig();

        if (!empty($config) && !empty($config['debt_type'])) {
            return $config['debt_type'];
        }

        return;
    }

    public function creditPull(Request $request)
    {
        $submissionId = $request->submission_id;

        Log::channel('experian')->info("experian debug");
        Log::channel('experian')->info(env('EXPERIAN_LOGIN_API_URL'));
        Log::channel('experian')->info(env('EXPERIAN_USER'));
        Log::channel('experian')->info(env('EXPERIAN_PASS'));
        $loginResponse = Http::post(env('EXPERIAN_LOGIN_API_URL'), [
            'username' => env('EXPERIAN_USER'),
            'password' => env('EXPERIAN_PASS'),
            'client_id' => env('EXPERIAN_CLIENT_ID'),
            'client_secret' => env('EXPERIAN_CLIENT_SECRET'),
        ]);

        if ($loginResponse->failed()) {
            Log::channel('experian')->info('Experian Login Failed For Submission ' . $submissionId . ' return is:');
            Log::channel('experian')->info($loginResponse->json());
            return response()->json($loginResponse->json(), 500);
        }

        $loginResponse = $loginResponse->json();

        //prepare payload for experian post
        $data = array(
            'consumerPii' =>
            array(
                'primaryApplicant' =>
                array(
                    'name' =>
                    array(
                        'lastName' => $request->last_name,
                        'firstName' => $request->first_name,
                        'middleName' => '',
                        'generationCode' => '',
                    ),
                    'dob' =>
                    array(
                        'dob' => '',
                    ),
                    'ssn' =>
                    array(
                        'ssn' => $request->ssn,
                    ),
                    'currentAddress' =>
                    array(
                        'line1' => $request->addr1,
                        'line2' => $request->addr2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zipCode' => $request->zip,
                    ),
                ),
            ),
            'requestor' =>
            array(
                'subscriberCode' => '1697080',
            ),
            'permissiblePurpose' =>
            array(
                'type' => '34',
            ),
        );

        $response = Http::withToken($loginResponse['access_token'])->post(env('EXPERIAN_API_URL'), $data);

        Log::channel('experian')->info('Experian Call For Submission ' . $submissionId . ' return is:');
        Log::channel('experian')->info($response->status());
        Log::channel('experian')->info($response->json());

        if ($response->failed()) {
            return response()->json($response->json(), 500);
        }

        $response = $response->json();

       if (isset($response['creditProfile'][0]['tradeline'])) {
            $this->createRowsFromResponse($response, $submissionId);

            $dob = null;

            foreach ($response['creditProfile'][0]['consumerIdentity'] as $key => $value) {
                if ($key == "dob") {
                    if (isset($value['day']) && isset($value['month']) && isset($value['year'])) {
                        $dob = Carbon::createFromFormat('mdY', $value['month'] . $value['day'] . $value['year']);
                        $dob = $dob->format('m/d/Y');
                    }
                }
            }

            //update credit pull flag on submission
            $submission = Submission::find($submissionId);

            if ($request->coapplicant) {
                if ($dob) {
                    $submission->update(['credit_pull' => true, 'co_applicant_date_of_birth' => $dob]);
                }
                else {
                    $submission->update(['credit_pull' => true]);
                }
            }
            else {
                if ($dob) {
                    $submission->update(['credit_pull' => true, 'date_of_birth' => $dob]);
                }
                else {
                    $submission->update(['credit_pull' => true]);
                }
            }

            return response()->json(['message' => 'Credit pull successful'], 200);
        }
        else if (isset($response['creditProfile'][0]['informationalMessage'])) {
            $msg = $response['creditProfile'][0]['informationalMessage'][0]['messageText'];
            return response()->json(['message' => $msg], 401);
        }
        else
            return response()->json(['message' => 'Credit pull unsuccessful'], 401);
    }

    private function createRowsFromResponse($data, $submissionId)
    {
        $addedAccounts = [];

        $skipAccountTypes = array('7B', '95', '8A', '85', '9B', '10', '98', '6B', '93', '6C', '6A', '7A', '14', '5C', '34', '8B', '43', '16', 'OC', '71', '73', '72', '69', '74', '70', '1B', '13', '3C', '1A', '86', '83', '77', '29', '7C', '87', '30', '96', '50', '92', '94', '2A');

        foreach ($data['creditProfile'][0]['tradeline'] as $debt) {
            if (isset($debt['balanceAmount'])) {
                if ($debt['balanceAmount'] == 0) {
                    continue;
                }
            }

            if (isset($debt['accountType'])) {
                if (in_array($debt['accountType'], $skipAccountTypes)) {
                    continue;
                }
            }

            $create = [];
            $create['submission_id'] = $submissionId;

            if (isset($debt['accountNumber'])) {
                $create['account_number'] = $debt['accountNumber'];
            }

            if (isset($debt['subscriberName'])) {
                $create['creditor'] = $debt['subscriberName'];
            }

            $dt = "";
            if (isset($debt['accountType'])) {
                switch ($debt['accountType']) {
                    case "3A":
                    case "00":
                        $dt = "Car Loan/Lease";
                        break;
                    case "OF":
                    case "05":
                    case "2C":
                    case "89":
                    case "4":
                    case "60":
                    case "17":
                    case "26":
                    case "8":
                    case "19":
                    case "27":
                    case "5B":
                    case "25":
                    case "5A":
                    case "9A":
                        $dt = "Mortgage";
                        break;
                    case "37":
                    case "7":
                    case "15":
                    case "18":
                    case "OG":
                        $dt = "Credit Cards";
                        break;
                    case "47":
                    case "91":
                    case "23":
                    case "22":
                    case "78":
                    case "6":
                    case "21":
                    case "20":
                    case "3":
                    case "1C":
                    case "11":
                    case "09":
                    case "68":
                    case "02":
                    case "66":
                    case "0A":
                    case "67":
                    case "65":
                    case "01":
                        $dt = "Personal Loans";
                        break;
                    case "12":
                        $dt = "Student Loans";
                        break;
                    case "40":
                    case "48":
                    case "31":
                    case "92":
                        $dt = "Collection Accounts";
                        break;
                    case "90":
                        $dt = "Medical Bills";
                        break;
                    case "4f":
                        $dt = "Taxes";
                        break;
                }
                $create['debt_type'] = $dt;
            }

            if (isset($debt['monthlyPaymentAmount'])) {
                $create['monthly_payment'] = $debt['monthlyPaymentAmount'];
            }

            if (isset($debt['balanceAmount'])) {
                $create['balance_owed'] = $debt['balanceAmount'];
            }

            if (isset($debt['status'])) {
                switch ($debt['status']) {
                    case '71':
                        $pd = true;
                        break;
                    case '72':
                        $pd = true;
                        break;
                    case '73':
                        $pd = true;
                        break;
                    case '74':
                        $pd = true;
                        break;
                    case '75':
                        $pd = true;
                        break;
                    case '76':
                        $pd = true;
                        break;
                    case '77':
                        $pd = true;
                        break;
                    case '22':
                        $pd = true;
                        break;
                    case '23':
                        $pd = true;
                        break;
                    case '24':
                        $pd = true;
                        break;
                    case '25':
                        $pd = true;
                        break;
                    case '26':
                        $pd = true;
                        break;
                    case '27':
                        $pd = true;
                        break;
                    case '28':
                        $pd = true;
                        break;
                    case '29':
                        $pd = true;
                        break;
                    case '86':
                        $pd = true;
                        break;
                    case '78':
                        $pd = true;
                        break;
                    case '80':
                        $pd = true;
                        break;
                    case '82':
                        $pd = true;
                        break;
                    case '83':
                        $pd = true;
                        break;
                    case '84':
                        $pd = true;
                        break;
                    case '79':
                        $pd = true;
                        break;
                    case '81':
                        $pd = true;
                        break;
                    case '42':
                        $pd = true;
                        break;
                    default:
                        $pd = false;
                }
                $create['past_due'] = $pd;
            }

            $dupeCreditAccounts = CreditAccount::where("submission_id", $submissionId)
                ->where("account_number", $create['account_number'])
                ->where("creditor", $create['creditor'])
                ->get();

            if ($dupeCreditAccounts->count()) {
                continue;
            } else {
                CreditAccount::create($create);
                array_push($addedAccounts, $create);
            }
        }
    }
}
