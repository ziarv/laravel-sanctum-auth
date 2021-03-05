<?php


namespace App\Http\Controllers\Api;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends ApiController
{
    /**
     * Register New User
     * @param UserRegisterRequest $userRegisterRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerAction(UserRegisterRequest $userRegisterRequest)
    {
        $userData = $userRegisterRequest->validated();
        $user = User::create($userData);
        return $this->respondSuccess('Successfully Registered', new UserCollection($user));
    }

    /**
     * Get Current Login User
     * @return \Illuminate\Http\JsonResponse
     */
    public function meAction()
    {
        $user = request()->user();
        return $this->respondSuccess('User Me', new UserCollection($user));
    }

    /**
     * Login User
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginAction(UserLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->respondValidationError([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $userPlainToken = $user->createToken($request->device_name)->plainTextToken;
        $userData = collect(['auth_token' => $userPlainToken])->merge($user);
        return $this->respondSuccess('Login Success', $userData);
    }

    /**
     * Logout User From All Sources
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutAction()
    {
        $user = request()->user();
        /* Revoke All Tokens */
        $user->tokens()->delete();
        return $this->respondSuccess('User Logged Out');
    }
}
