<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;

/*

200 =success
500 = network error
422 = unprocessable content
400 = validation errror


*/
class BaseController extends Controller
{

    public function handleResponse($result, $msg)
    {
    	$res = [
            'success' => true,
            'message' => $msg,
            'data'    => $result,
        ];
        return response()->json($res, 200);
    }

    public function handleError($error, $errorMsg = [], $code = 404)
    {
    	$res = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMsg)){
            $res['data'] = $errorMsg;
        }
        return response()->json($res, $code);
    }
    public function handleArrayResponse($response,$message='process success') {

        return array(
            'status'   => true,
            'message'  => $message,
            'response' => $response
        );
    }
    public function handleArrayErrorResponse($response,$message='process fail') {

        return array(
            'status'    => false,
            'message'   => $message,
            'response'  => $response
        );

    }
}
