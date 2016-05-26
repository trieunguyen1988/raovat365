<?php
use App\ErrorHelper;
    /**
     * API response data
     * @param type $responseData
     * @param type $statusCode
     * @param type $message
     * @return response
     */
    function responseApi($responseData, $statusCode = FMNET_API_RETURN_CODE_SUCCESS, $message = '')
    {
        $result = [
                'result_code'   => $statusCode,
                'message' => $message,
                'response_data' => $responseData
        ];

        return response(json_encode($result), $statusCode);
    }
    /**
     * API response error
     * @param type $resultCode
     * @param type $message
     * @return response
     */
    function responseError($resultCode=FMNET_API_RETURN_CODE_EXCEPTION, $message='')
    {
        $errorHelper = new ErrorHelper;
        $result = [
                'result_code'   => $resultCode,
                'message' => $message?$message:$errorHelper->getErrorMessage($resultCode),
                'response_data' => ''
        ];

        return response(json_encode($result), $errorHelper->getStatusCode($resultCode));
    }
    /**
     * Generate UUID version 4
     * @return string
     */
    function getUUIDv4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

          // 32 bits for "time_low"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),

          // 16 bits for "time_mid"
          mt_rand(0, 0xffff),

          // 16 bits for "time_hi_and_version",
          // four most significant bits holds version number 4
          mt_rand(0, 0x0fff) | 0x4000,

          // 16 bits, 8 bits for "clk_seq_hi_res",
          // 8 bits for "clk_seq_low",
          // two most significant bits holds zero and one for variant DCE1.1
          mt_rand(0, 0x3fff) | 0x8000,

          // 48 bits for "node"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    /**
     * Get basic plan payment list
     * @param Datetime $lastPayDate
     * @return array
     */
    function getBasicPlan($lastPayDate = "")
    {
        $period_arr = [1 => Array('name' => trans('user.MONTHLY'), 'period' => 30, 'next_pay_date' => '', 'amount' => 3000, 'recursion_period' => 'month')
                      ,2 => Array('name' => trans('user.YEARLY'), 'period' => 365, 'next_pay_date' => '', 'amount' => 36000, 'recursion_period' => 'year')];
        foreach($period_arr as &$period) {
            if (!empty($lastPayDate)) {
                $payDate = new DateTime($lastPayDate);
                $period['next_pay_date'] = date_add($payDate, date_interval_create_from_date_string($period['period'].' day'))->format(DATE_FORMAT);
            }
        }
        return $period_arr;
    }
    /**
     * Get basic plan payment list
     * @param Datetime $lastPayDate
     * @return array
     */
    function getBasicPlanCSV()
    {
        $period_arr = [1 => Array('name' => trans('admin/user.MONTHLY_CSV'), 'period' => 30, 'next_pay_date' => '', 'amount' => 3000, 'recursion_period' => 'month')
                      ,2 => Array('name' => trans('admin/user.YEARLY_CSV'), 'period' => 365, 'next_pay_date' => '', 'amount' => 36000, 'recursion_period' => 'year')];
        return $period_arr;
    }    
    /**
     * Get payment method list
     * @return array
     */
    function getPaymentMethod()
    {
        return [2=>trans('user.CREDIT_CARD'),
                1=>trans('user.TRANSFER')];
    }
    /**
     * Get payment method list
     * @return array
     */
    function getCardType()
    {
        return [1=>trans('user.CREDIT_CARD_VISA'),
                2=>trans('user.CREDIT_CARD_MASTER'),
                3=>trans('user.CREDIT_CARD_JCB'),
                4=>trans('user.CREDIT_CARD_AMERICAN_EXPRESS'),
                5=>trans('user.CREDIT_CARD_DINNER_CLUB')];
    }
    /**
     * Get user sort list
     * @return array
     */
    function getUserSortList()
    {
        return [1=>Array('name'=>trans('admin/user.REGISTER_DATE_DESC'), 'field' => 'register_date', 'order' => 'DESC'),
                2=>Array('name'=>trans('admin/user.REGISTER_DATE_ASC'), 'field' => 'register_date', 'order' => 'ASC'),
                3=>Array('name'=>trans('admin/user.NEXT_PAY_DATE_ASC'), 'field' => 'next_pay_date', 'order' => 'ASC'),
                4=>Array('name'=>trans('admin/user.NEXT_PAY_DATE_DESC'), 'field' => 'next_pay_date', 'order' => 'DESC')];
    }
    /**
     * Get shop sort list
     * @return array
     */
    function getShopSortList()
    {
        return [1=>Array('name'=>trans('admin/shop.REGISTER_DATE_DESC'), 'field' => 'register_date', 'order' => 'DESC'), 
                2=>Array('name'=>trans('admin/shop.REGISTER_DATE_ASC'), 'field' => 'register_date', 'order' => 'ASC'),
                3=>Array('name'=>trans('admin/shop.EXPIRED_DATE_ASC'), 'field' => 'trial_period', 'order' => 'ASC'),
                4=>Array('name'=>trans('admin/shop.EXPIRED_DATE_DESC'), 'field' => 'trial_period', 'order' => 'DESC')];
    }    
    /**
     * Get payment method list
     * @return array
     */
    function getCardPeriodData($numOfYear)
    {
        for($i = 1; $i <= 12; $i++) {
            $data['month'][$i] = $i;
        }
        $currentYear = date('Y');
        for($i = 0; $i < $numOfYear; $i++) {
            $data['year'][$currentYear + $i] = $currentYear + $i;
        }
        return $data;
    }
    /**
     * Create access token
     * @param Array $data
     * @return String $token
     */
    function getAccessToken($data=array())
    {
        $token = '';
        if(!empty($data)){
            foreach ($data as $v){
                $token .= $v;
            }
        }
        $token = md5($token . time());
        return $token;
    }