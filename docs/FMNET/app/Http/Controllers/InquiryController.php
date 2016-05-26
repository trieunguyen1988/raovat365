<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\ErrorHelper;
use Mail;
use App\Shop;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    public function create(Request $request)
    {
        $errorHelper = new ErrorHelper;
        $template = 'inquiry.create';
        $data['title'] = trans('inquiry.INQUIRY_REGISTRATION_TITLE');
        $user = \Auth::user();
        $data['user'] = $user;
        if($request->isMethod('post')) {
            //Validates data
            $request->flash();
            $validate = $this->registrationValidator($request->all());
            if($validate->fails()) {
                $data['errors'] = $validate->errors();
            }
            else {
                //Send inquiry
                try{
                    $email = $request->email;
                    $inquiry['email'] = $request->email;
                    $inquiry['subject'] = $request->subject;
                    $inquiry['inquiry_content'] = $request->inquiry_content;
                    $inquiry['user_name'] = $user->user_name;
                    //Send mail
                    Mail::send('email_templates.inquiry', ['inquiry'=>$inquiry], function ($m) use ($inquiry, $user) {
                        $m->from($inquiry['email'], $user->user_name);
                        $m->to(ADMIN_EMAIL_INQUIRY)->subject($inquiry['subject']);
                    });
                    return redirect('inquiry/finish');
                }
                catch (\Swift_TransportException $e) {//Send mail error
                    $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SEND_MAIL_ERROR);
                }
                catch (\Exception $e) {// System error
                    var_dump($e);
                    $data['error_message'] = $errorHelper->getErrorMessage(FMNET_ERROR_CODE_SYSTEM_ERROR);
                }
            }
        }

        return view($template, $data);
    }

    public function finish(Request $request)
    {
        $template = 'inquiry.finish';
        $data['title'] = trans('inquiry.INQUIRY_FINISH_TITLE');

        return view($template, $data);
    }
    /**
     * Get a validator for an incoming inquiry request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function registrationValidator(array $data)
    {
        return Validator::make($data, [
            'email'  => 'required|email',
            'inquiry_content' => 'required',
        ]);
    }
}