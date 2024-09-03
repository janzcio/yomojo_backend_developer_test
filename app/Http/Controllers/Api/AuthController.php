<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    /**
     * @api {post} /api/register Register a new user
     * @apiName RegisterUser
     * @apiGroup Auth
     *
     * @apiBody {String} name User's name.
     * @apiBody {String} email User's email address.
     * @apiBody {String} password User's password.
     * @apiBody {String} password_confirmation Confirmation of user's password.
     *
     * @apiSuccess {Number} status HTTP status code (201).
     * @apiSuccess {String} description Status description ("Created").
     * @apiSuccess {String} message Success message ("User registered successfully").
     * @apiSuccess {Object} data Response data.
     * @apiSuccess {String} data.token Authentication token.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *       "status": 201,
     *       "description": "Created",
     *       "message": "User registered successfully",
     *       "data": {
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
     *       }
     *     }
     *
     * @apiError (422) UnprocessableEntity The given data was invalid.
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *       "status": 422,
     *       "description": "Unprocessable Entity",
     *       "message": "The given data was invalid.",
     *       "errors": {
     *         "name": [
     *           "The name field is required."
     *         ],
     *         "email": [
     *           "The email has already been taken."
     *         ]
     *       }
     *     }
     */
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated(); // Get validated data

        $result = $this->authService->register($validatedData);

        return success('User registered successfully', $result, 201);
    }

    /**
     * @api {post} /api/login User login
     * @apiName LoginUser
     * @apiGroup Auth
     *
     * @apiBody {String} email User's email address.
     * @apiBody {String} password User's password.
     *
     * @apiSuccess {String} message Success message.
     * @apiSuccess {Object} data Login token details.
     * @apiSuccess {String} data.token Authentication token.
     *
     * @apiError (Error 401) Unauthorized Invalid credentials.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $result = $this->authService->login($credentials);

        if ($result) {
            return success('Login successful', $result);
        }

        return error('Unauthorized', 401);
    }

    /**
     * @api {post} /api/logout User logout
     * @apiName LogoutUser
     * @apiGroup Auth
     *
     * @apiHeader {String} Authorization Bearer token.
     *
     * @apiSuccess {String} message Success message.
     *
     * @apiError (Error 401) Unauthorized Unauthorized request.
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        // Call logout method in AuthService
        $this->authService->logout($user);

        return success('Logout successful');
    }
}
