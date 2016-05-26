<?php
namespace App;
Class ErrorHelper {
    private $errorData = array(
        FMNET_ERROR_CODE_MISSING_PARAMETER      => array('message' => 'errors.MISSING_PARAMETER',
                                                         'code' => 400),
        FMNET_ERROR_CODE_PASSWORD_REQUIRED      => array('message' => 'errors.PASSWORD_REQUIRED',
                                                         'code' => 400),
        FMNET_ERROR_CODE_SHOP_NOT_EXISTS        => array('message' => 'errors.SHOP_NOT_EXISTS',
                                                         'code' => 404),
        FMNET_ERROR_CODE_TOKEN_EMPTY            => array('message' => 'errors.TOKEN_EMPTY',
                                                         'code' => 400),
        FMNET_ERROR_CODE_WRONG_TOKEN            => array('message' => 'errors.WRONG_TOKEN',
                                                         'code' => 404),
        FMNET_ERROR_CODE_CANNOT_CREATE_USER     => array('message' => 'errors.CANNOT_CREATE_USER',
                                                         'code' => 500),
        FMNET_ERROR_CODE_CANNOT_GET_USER_INFO   => array('message' => 'errors.CANNOT_GET_USER_INFO',
                                                         'code' => 500), 
        FMNET_ERROR_CODE_EMAIL_ALREADY_EXISTS   => array('message' => 'errors.EMAIL_ALREADY_EXISTS',
                                                         'code' => 403),   
        FMNET_ERROR_CODE_WRONG_EMAIL            => array('message' => 'errors.WRONG_EMAIL',
                                                         'code' => 422),   
        FMNET_ERROR_CODE_DATABASE_ERROR         => array('message' => 'errors.DATABASE_ERROR',
                                                         'code' => 500),   
        FMNET_ERROR_CODE_SEND_MAIL_ERROR        => array('message' => 'errors.SEND_MAIL_ERROR',
                                                         'code' => 500),   
        FMNET_ERROR_CODE_SYSTEM_ERROR           => array('message' => 'errors.SYSTEM_ERROR',
                                                         'code' => 500),   
        FMNET_ERROR_CODE_DELETE_PLAYLIST_FAIL   => array('message' => 'errors.DELETE_PLAYLIST_FAIL',
                                                         'code' => 500),   
        FMNET_ERROR_CODE_PLAYLIST_NOT_FOUND     => array('message' => 'errors.PLAYLIST_NOT_FOUND',
                                                         'code' => 404),           
        FMNET_ERROR_CODE_EMAIL_NOT_EXISTS       => array('message' => 'errors.EMAIL_NOT_EXISTS',
                                                         'code' => 404),        
    );

    public function __construct()
    {
    }
    public function getErrorMessage($errorCode)
    {
        return (isset($this->errorData[$errorCode]['code']))?trans($this->errorData[$errorCode]['message']):'';
    }
    public function getStatusCode($errorCode)
    {
        return (isset($this->errorData[$errorCode]['code']))?$this->errorData[$errorCode]['code']:FMNET_API_RETURN_CODE_EXCEPTION;
    }
}