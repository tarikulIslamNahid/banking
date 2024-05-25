<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
abstract class Controller
{
        /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="API Documentation",
     *      description="L5 Swagger OpenApi description of this application api",
     *      @OA\Contact(
     *          email="tarikulislamnahid15@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Application API Host"
     * )
     *
     *
     * @OAS\SecurityScheme(
     *      securityScheme="bearer_token",
     *      type="http",
     *      scheme="bearer"
     * )
     */

     public function sendResponse($result = [], $message = '', $code = Response::HTTP_OK)
     {
         $response = [
             'success' => true,
             'message' => $message,
             'code' => $code,
             'data' => $result,
         ];
         if (empty($result)) {
             unset($response['data']);
         }
         // return response()->json($response, 200);
         return new JsonResponse($response, $code);
     }

     public function sendError($error, $errorMessages = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR)
     {
         $response = [
             'success' => false,
             'message' => $error,
             'code' => $code,
         ];
         if (!empty($errorMessages)) {
             $response['errors'] = $errorMessages;
         }
         if (empty($error)) {
             unset($response['message']);
         }

         return new JsonResponse($response, $code);
         //return response()->json($response, $code);
     }
}
