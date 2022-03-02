<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Submission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\SubmissionResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Http;
use App\Jobs\UpdateInfusionsoftContact;
use App\Jobs\AddInfusionsoftCompletionTag;
use Log;
use Illuminate\Support\Facades\Redis;

class SubmissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'store',
            'getSubmissionReasonsTable',
            'getSubmissionConfig',
            'getSubmissionTypes',
            'getSubmissionReasons',
            'income_types'
        ]]);
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
                return $user->submission;
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
            'user_id' => ['nullable', 'integer'],
            'submission_type' => ['nullable', 'string', Rule::in($this->getSubmissionTypes())],
            'reason' => ['nullable', 'string', Rule::in(array_keys($this->getSubmissionReasons()))],
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'address_line_1' => ['nullable', 'string'],
            'address_line_2' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'zip' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'income_dependents' => ['nullable', 'integer'],
            'gross_employment_income' => ['nullable', 'numeric'],
            'net_employment_income' => ['nullable', 'numeric'],
            'self_employment_income' => ['nullable', 'numeric'],
            'benefits_income' => ['nullable', 'numeric'],
            'retirement_income' => ['nullable', 'numeric'],
            'social_security_income' => ['nullable', 'numeric'],
            'pension_income' => ['nullable', 'numeric'],
            'other_income' => ['nullable', 'numeric'],
            'ssn' => ['nullable', 'string'], // @TODO: Make encrypted? add SSN validation rules
            'co_applicant_first_name' => ['nullable', 'string'],
            'co_applicant_last_name' => ['nullable', 'string'],
            'co_applicant_email' => ['nullable', 'email'],
            'co_applicant_ssn' => ['nullable', 'string'], // @TODO: Make encrypted? add SSN validation rules
            'co_applicant_address_line_1' => ['nullable', 'string'],
            'co_applicant_address_line_2' => ['nullable', 'string'],
            'co_applicant_city' => ['nullable', 'string'],
            'co_applicant_state' => ['nullable', 'string'],
            'co_applicant_zip' => ['nullable', 'string'],
            'bankruptcy_session_time' => ['nullable', 'numeric'],
            'credit_approval' => ['nullable', 'boolean'],
            'credit_approval_at' => ['nullable', 'date'],
            'counseling_approval' => ['nullable', 'boolean'],
            'counseling_approval_at' => ['nullable', 'date'],
            'bankruptcy_approval' => ['nullable', 'boolean'],
            'bankruptcy_approval_at' => ['nullable', 'date'],
            'ip_address' => ['nullable', 'ip'],
            'accept_bankruptcy_disclosure' => ['nullable', 'boolean'],
            'accept_statement_of_counseling' => ['nullable', 'boolean'],
            'military' => ['nullable', 'boolean'],
            'message' => ['nullable', 'string'],
            'selected_incomes' => ['nullable', 'string'],
            'selected_expenses' => ['nullable', 'string'],
            'steps_namespace' => ['nullable', 'string'],
            'last_saved_step' => ['nullable', 'string'],
            'referrer' => ['nullable', 'string'],
            'referrer_tag_id' => ['nullable', 'integer'],
            'joint_coapplicant' => ['nullable', 'boolean'],
            'date_of_birth' => ['nullable', 'date'],
            'co_applicant_date_of_birth' => ['nullable', 'date'],
        ]);

        $create = array_filter($data);

        //if submission for user already exists, return that
        $existingSubmission = Submission::where("user_id", $create['user_id'])->first();

        if ($existingSubmission) {
            return new SubmissionResource($existingSubmission);
        } else {
            return new SubmissionResource(Submission::create($create));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        return new SubmissionResource($submission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'integer'],
            'submission_type' => ['nullable', 'string', Rule::in($this->getSubmissionTypes())],
            'reason' => ['nullable', 'string', Rule::in(array_keys($this->getSubmissionReasons()))],
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'address_line_1' => ['nullable', 'string'],
            'address_line_2' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'zip' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'income_dependents' => ['nullable', 'integer'],
            'gross_employment_income' => ['nullable', 'numeric'],
            'net_employment_income' => ['nullable', 'numeric'],
            'self_employment_income' => ['nullable', 'numeric'],
            'benefits_income' => ['nullable', 'numeric'],
            'retirement_income' => ['nullable', 'numeric'],
            'social_security_income' => ['nullable', 'numeric'],
            'pension_income' => ['nullable', 'numeric'],
            'other_income' => ['nullable', 'numeric'],
            'ssn' => ['nullable', 'string'], // @TODO: Make encrypted? add SSN validation rules
            'co_applicant_first_name' => ['nullable', 'string'],
            'co_applicant_last_name' => ['nullable', 'string'],
            'co_applicant_email' => ['nullable', 'email'],
            'co_applicant_ssn' => ['nullable', 'string'], // @TODO: Make encrypted? add SSN validation rules
            'co_applicant_address_line_1' => ['nullable', 'string'],
            'co_applicant_address_line_2' => ['nullable', 'string'],
            'co_applicant_city' => ['nullable', 'string'],
            'co_applicant_state' => ['nullable', 'string'],
            'co_applicant_zip' => ['nullable', 'string'],
            'bankruptcy_session_time' => ['nullable', 'numeric'],
            'credit_approval' => ['nullable', 'boolean'],
            'credit_approval_at' => ['nullable', 'date'],
            'counseling_approval' => ['nullable', 'boolean'],
            'counseling_approval_at' => ['nullable', 'date'],
            'bankruptcy_approval' => ['nullable', 'boolean'],
            'bankruptcy_approval_at' => ['nullable', 'date'],
            'ip_address' => ['nullable', 'ip'],
            'accept_bankruptcy_disclosure' => ['nullable', 'boolean'],
            'accept_statement_of_counseling' => ['nullable', 'boolean'],
            'military' => ['nullable', 'boolean'],
            'message' => ['nullable', 'string'],
            'selected_incomes' => ['nullable', 'string'],
            'selected_expenses' => ['nullable', 'string'],
            'steps_namespace' => ['nullable', 'string'],
            'last_saved_step' => ['nullable', 'string'],
            'referrer' => ['nullable', 'string'],
            'referrer_tag_id' => ['nullable', 'integer'],
            'joint_coapplicant' => ['nullable', 'boolean'],
            'date_of_birth' => ['nullable', 'date'],
            'co_applicant_date_of_birth' => ['nullable', 'date'],
        ]);

        $jointCoapplicant = null;
        if (isset($data['joint_coapplicant'])) {
            if ($data['joint_coapplicant']) {
                $jointCoapplicant = 1;
            } else {
                $jointCoapplicant = 0;
            }
        }

        // Remove any empty fields, so they don't wipe out existing data
        $update = array_filter($data);
        $update['joint_coapplicant'] = $jointCoapplicant;

        if (!empty($data['ssn'])) {
            // $update['ssn'] = Hash::make($data['ssn']);
        }

        if (!empty($data['co_applicant_ssn'])) {
            // $update['co_applicant_ssn'] = Hash::make($data['co_applicant_ssn']);
        }

        $submission->update($update);
        return new SubmissionResource($submission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return response(null, 204);
    }

    /**
     * Get submission categories
     *
     * @return array|null
     */
    public function getSubmissionConfig()
    {
        return Config::get('field_values.submission');
    }

    /**
     * Get submission types
     *
     * @return array|null
     */
    public function getSubmissionTypes()
    {
        $config = $this->getSubmissionConfig();

        if (!empty($config) && !empty($config['submission_type'])) {
            return $config['submission_type'];
        }

        return;
    }

    /**
     * Get submission reasons from config
     *
     * @return array|null
     */
    public function getSubmissionReasons()
    {
        $config = $this->getSubmissionConfig();

        if (!empty($config) && !empty($config['reason'])) {
            return $config['reason'];
        }

        return;
    }

    /**
     * Get submission for current user
     *
     * @return object
     */
    public function current()
    {
        $submission = Submission::with('user')->where('user_id', Auth::user()->id)->first();
        return response()->json($submission);
    }

    public function swaggerSubmit(Request $request)
    {
        $loginResponse = Http::post(env('SWAGGER_LOGIN_API_URL'), [
            'Username' => env('SWAGGER_USER'),
            'Password' => env('SWAGGER_PASS'),
            'Application' => env('SWAGGER_APP'),
        ]);

        if ($loginResponse->failed()) {
            return response()->json($loginResponse, 500);
        }

        $loginResponse = $loginResponse->json();

        $response = Http::withHeaders([
            'Authorization-Token' => $loginResponse['SignedToken'],
            'Username' => $loginResponse['Username'],
            'ExpiresOn' => $loginResponse['ExpiresOn'],
        ])->post(env('SWAGGER_API_URL') . "/case/CreateOnlineCase", $request['payload']);

        Log::channel('swagger')->info('Swagger Call For Submission ' . $request['id'] . ' return is:');
        Log::channel('swagger')->info($response->json());
        Log::channel('swagger')->info('Swagger Call For Submission ' . $request['id'] . ' request data was:');
        Log::channel('swagger')->info(json_encode($request['payload']));

        if ($response->failed()) {
            return response()->json($response, 500);
        }

        $response = $response->json();

        return response()->json($response);
    }

    public function addInfusionsoftClient(Request $request)
    {
        $s = Submission::findOrFail($request->id);
        UpdateInfusionsoftContact::dispatch($s);
        return response()->json(null, 201);
    }

    public function addInfusionsoftCompletionTag(Request $request)
    {
        $s = Submission::findOrFail($request->id);
        AddInfusionsoftCompletionTag::dispatch($s);
        return response()->json(null, 201);
    }
}
