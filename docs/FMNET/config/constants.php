<?php
define('FMNET_EMAIL_CHANGE_EXPIRED_HOURS', 24);
define('FMNET_TEMP_REGISTRATION_EXPIRED_HOURS', 24);
define('FMNET_SHOP_EXPIRED_DAYS', 60);
define('FMNET_API_RETURN_CODE_SUCCESS', 200);
define('FMNET_API_RETURN_CODE_EXCEPTION', 500);
define('FMNET_SHOP_EXPIRED_CODE', 2);
define('FMNET_SHOP_TRIAL_CODE', 1);
define('FMNET_SHOP_PAYMENT_FINISHED_CODE', 3);
define('FMNET_SHOP_PREMIUM_FLG', 1);
define('FMNET_SHOP_NOTPREMIUM_FLG', 0);
define('FMNET_SHOP_ITEM_PER_PAGE', 10);
define('FMNET_USER_PER_PAGE', 10);
define('PASSWORD_MASK', '        　');
define('ADMIN_EMAIL_INQUIRY', 'fmnettester2016@gmail.com');
define('NUM_OF_CARD_PERIOD_YEAR', 14);
define('WEBPAY_PUBLIC_KEY', 'test_public_5K615CcV52UF8nR51UdbQ9tm');
define('WEBPAY_PRIVATE_KEY', 'test_secret_c92fXeam53Hcf7ZciO12t5Ol');
define('DATE_FORMAT', 'Y/m/d');
define('DATE_TIME_FORMAT', 'Y/m/d H:i:s');
define('DATE_FORMAT_DB', 'Y-m-d');
define('DATE_TIME_FORMAT_DB', 'Y-m-d H:i:s');

/**********Error code****************/
define('FMNET_ERROR_CODE_MISSING_PARAMETER', 1001);
define('FMNET_ERROR_CODE_PASSWORD_REQUIRED', 1002);
define('FMNET_ERROR_CODE_SHOP_NOT_EXISTS', 1201);
define('FMNET_ERROR_CODE_TOKEN_EMPTY', 1203);
define('FMNET_ERROR_CODE_WRONG_TOKEN', 1206);
define('FMNET_ERROR_CODE_CANNOT_CREATE_USER', 2001);
define('FMNET_ERROR_CODE_CANNOT_GET_USER_INFO', 2002);
define('FMNET_ERROR_CODE_WRONG_EMAIL', 2004);
define('FMNET_ERROR_CODE_EMAIL_NOT_EXISTS', 2005);
define('FMNET_ERROR_CODE_EMAIL_ALREADY_EXISTS', 2006);
define('FMNET_ERROR_CODE_DELETE_PLAYLIST_FAIL', 2503);
define('FMNET_ERROR_CODE_PLAYLIST_NOT_FOUND', 2505);
define('FMNET_ERROR_CODE_DATABASE_ERROR', 9001);
define('FMNET_ERROR_CODE_SEND_MAIL_ERROR', 9003);
define('FMNET_ERROR_CODE_SYSTEM_ERROR', 9005);
define('FMNET_MESSAGE_CREATE_USER_SUCCESS', 'Create user success!');