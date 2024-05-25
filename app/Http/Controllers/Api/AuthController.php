<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Services\User\AuthService;

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

}
