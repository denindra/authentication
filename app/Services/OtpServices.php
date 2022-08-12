<?php

namespace App\Services;
use Carbon\Carbon;
use Tzsk\Otp\Facades\Otp;
use App\Http\Controllers\BaseController;


/**
 * Class OtpServices
 * @package App\Services
 * ingin melihat dokumentasi klik disini https://github.com/tzsk/otp
 */
class OtpServices extends BaseController
{
    private $OtpExpiredMinute;
    private $OtpTotalDigit;

    public function __construct()
    {
        $this->OtpExpiredMinute = 1; //in minute
        $this->OtpTotalDigit    = 6; //total digit
    }

    public function validateOTP($otp,$unique_secret) {

       $validate =  Otp::digits($this->OtpTotalDigit)->expiry($this->OtpExpiredMinute)->check($otp, $unique_secret);

       if(!$validate) {
           return $this->handleArrayErrorResponse($validate,'validate fail');
       }

        return $this->handleArrayResponse($validate,'validate success');
    }
    public function generateOTP($unique_secret) {

       $generateOtp    = Otp::digits($this->OtpTotalDigit)->expiry($this->OtpExpiredMinute)->generate($unique_secret);

       $requestOtp     = date('Y-m-d H:i:s');
       $expiredOtp     = strtotime(''.$requestOtp.' + '.$this->OtpExpiredMinute.' minute');
       $dateFormatExp  = date('Y-m-d H:i:s', $expiredOtp);

        if(!$generateOtp) {
            return $this->handleArrayErrorResponse($generateOtp,'generate fail');
        }

        $data = array(
            'otp'        => $generateOtp,
            'requestOTP' => $requestOtp,
            'expiredOTP' => $dateFormatExp
        );

        return $this->handleArrayResponse($data,'generate success');

    }
}
