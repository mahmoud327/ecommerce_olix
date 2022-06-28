<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    /**
       * success response method.
       *
       * @return \Illuminate\Http\Response
       */
    public function sendResponse($result, $message)
    {
        $response = [
              'success' => true,
              'data'    => $result,
              'message' => $message,
          ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($errorMessages, $code = 200)
    {
        $response = [
              'success' => false,
              'message' => $errorMessages,
              'data' => null,
          ];

        return response()->json($response, $code);
    }
}
