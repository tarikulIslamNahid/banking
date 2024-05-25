<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\User\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService;
    public function __construct(
        AuthService $authService,
    ) {
        $this->authService = $authService;
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     *
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="register",
     *      tags={"AUTH"},
     *      summary="register new user",
     *      description="register new user",
     *
     *       @OA\RequestBody(
     *          required=true,
     *          description="enter inputs",
     *
     *            @OA\MediaType(
     *              mediaType="multipart/form-data",
     *           @OA\Schema(
     *                   @OA\Property(
     *                      property="name",
     *                      description="user name",
     *                      type="string",
     *                   ),
     *                   @OA\Property(
     *                      property="email",
     *                      description="user email",
     *                      type="string",
     *                   ),
     *                   @OA\Property(
     *                      property="account_type",
     *                      description="user account type,ex: business,individual",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                     property="password",
     *                    description="user password",
     *                   type="string",
     *                ),
     *               @OA\Property(
     *                 property="password_confirmation",
     *               description="user password confirmation",
     *             type="string",
     *          ),
    *
     *             ),
     *             ),
     *
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful Insert operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          )
     *        )
     *     )
     *
     */
    public function register(AuthRegisterRequest $request){
        $data = $this->authService->register($request);
        return $this->sendResponse($data, 'User registered successfully');
    }

    /**
     *
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="login",
     *      tags={"AUTH"},
     *      summary="Login to the Application",
     *      description="login to the application",
     *       @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *           @OA\Schema(
     *                   @OA\Property(
     *                      property="email",
     *                      description="email",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="password",
     *                      type="string",
     *                   ),
     *               ),
     *               ),
     *
     *         ),
     *
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          )
     *        )
     *     )
     *
     */
    public function login(AuthLoginRequest $request){
        $data = $this->authService->login($request);
        return UserResource::make($data['user'])
        ->token($data['token'])
        ->success(true)
        ->message("Login Success");
    }

    /**
    * @OA\Get(
    *      path="/auth/logout",
    *      summary="Logout From The Application",
    *      description="Logout user and invalidate token",
    *      operationId="logout",
    *      tags={"AUTH"},
    *      security={{"bearer_token":{}}},
    *      @OA\Response(
    *          response=204,
    *          description="Successful operation",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(
    *          response=401,
    *          description="Returns when user is not authenticated",
    *
    *  )
    * )
    */
   public function logout()
   {
    Auth::user()->tokens->each(function ($token, $key) {
        $token->delete();
    });
    return new JsonResponse('Logout successful', 200);
   }

}
