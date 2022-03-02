<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use App\Rules\ReCaptchaRule;
use Log;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' =>
        [
            'store',
        ],]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return UserResource::collection(User::all());
        return auth()->user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = User::where([['email', "=", $request->email], ["has_password", "=", 1]])->count();

        if ($count == 1) {
            $data = $request->validate([
                'email' => 'required|unique:users',
                // Initial account creation does not require password
                'password' => 'nullable|min:8',
                'recaptcha_token' => ['required', new ReCaptchaRule($request->get('recaptcha_token'))]
            ]);
        } else {
            $data = $request->validate([
                'email' => 'required',
                // Initial account creation does not require password
                'password' => 'nullable|min:8',
                'recaptcha_token' => ['required', new ReCaptchaRule($request->get('recaptcha_token'))]
            ]);
        }

        $create = array_filter($data);

        if (!empty($data['password'])) {
            $create['password'] = Hash::make($data['password']);
            $create['has_password'] = true;
        } else {
            $create['has_password'] = false;
        }

        if (!empty($data['email'])) {
            $create['has_email'] = true;
        } else {
            $create['has_email'] = false;
        }

        $user = User::create($create);

        $tokenResult = $user->createToken('authToken');

        /**
         * re-assign submissions from old user if a new user was created
         * with same email
         */
        $previousUsers = User::where('email', $create['email'])->get();
        if ($previousUsers) {
            foreach ($previousUsers as $previousUser) {
                $submissions = Submission::where('user_id', $previousUser->id)->get();
                if ($submissions) {
                    foreach ($submissions as $item) {
                        $item->user_id = $user->id;
                        $item->save();
                    }
                }
            }
        }

        new UserResource($user);

        // New 1-time passwordless login
        $generator = new LoginUrl($user);

        $url = $generator->generate();

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'url' => $url,
            'has_password' => $create['has_password'],
            'has_email' => $create['has_email'],
            'access_token' => $tokenResult->accessToken,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'email' => 'required',
            // Initial account creation does not require password
            'password' => 'nullable|min:8',
            'recaptcha_token' => ['required', new ReCaptchaRule($request->get('recaptcha_token'))]
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
            $data['has_password'] = true;
        } else {
            $data['has_password'] = false;
        }

        if (!empty($data['email'])) {
            $data['has_email'] = true;
        } else {
            $data['has_email'] = false;
        }

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }

    /**
     * Get the current user
     *  @param  Request  $request
     * @return object|null
     */
    public function current(Request $request)
    {
        if (Auth::check())
            return new UserResource($request->user());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Logged Out', 'logged_out' => true], 200);
    }
}
