<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class EmailSettingController extends Controller
{

    public function index()
    {
        $templates = EmailTemplate::orderBy('id', 'ASC')->get();
        return view('admin.settings-email', compact('templates'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_mail_driver' => 'required',
        ]);

        if ($validator->fails()) {
            $msg = '';
            if ($validator->errors()->has('site_mail_driver')) {
                $msg = $validator->errors()->first();
            } else {
                $msg = __('messages.nothing');
            }
            $notify[] = ['warning', $msg];
        } else {
            Setting::updateValue('site_mail_driver', $request->input('site_mail_driver', null));
            Setting::updateValue('site_mail_host' , $request->input('site_mail_host', null));
            changeEnv('MAIL_HOST',$request->input('site_mail_host', null));

            Setting::updateValue('site_mail_port' , $request->input('site_mail_port', null));
            changeEnv('MAIL_PORT',$request->input('site_mail_port', null));

            Setting::updateValue('site_mail_from_address', $request->input('site_mail_from_address', null));
            changeEnv('MAIL_FROM_ADDRESS',$request->input('site_mail_username', null));

            Setting::updateValue('site_mail_from_name' , $request->input('site_mail_from_name', null));
            changeEnv('MAIL_FROM_NAME',$request->input('site_mail_from_name', null));

            Setting::updateValue('site_mail_encryption', $request->input('site_mail_encryption', null));
            changeEnv('MAIL_ENCRYPTION',$request->input('site_mail_encryption', null));

            Setting::updateValue('site_mail_username' , $request->input('site_mail_username' , null));
            changeEnv('MAIL_USERNAME',$request->input('site_mail_username', null));

            Setting::updateValue('site_mail_password' , $request->input('site_mail_password', null));
            changeEnv('MAIL_PASSWORD',$request->input('site_mail_password', null));

            Setting::updateValue('site_mail_footer' , $request->input('site_mail_footer', null));
            Setting::updateValue('send_notification_to' , $request->input('send_notification_to', null));
            Setting::updateValue('send_notification_mails' , $request->input('send_notification_mails', null));
            Artisan::call('optimize:clear');
            $notify[] = ['success', 'Email Settings Updated Successfully'];
        }


        if ($request->ajax()) {
            return response()->json($notify);
        }
	    return back()->withNotify($notify);
    }

    /**
     * Show the template
     *
     */
    public function show_template(Request $request)
    {
        #email_template
        if ($request->input('get_template') == null) {
            return response()->json(['msg'=>'warning', 'message'=>__('messages.wrong')]);
        } else {
            $template = EmailTemplate::get_template($request->input('get_template'));

            if ($template) {
                return view('modals.email_template', compact('template'))->render();
            } else {
                return response()->json(['msg'=>'warning', 'message'=>__('messages.form.wrong')]);
            }
        }
    }

    /**
     * Update the template
     *
     */
    public function update_template(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
            'subject' => 'required|min:5|max:191',
        ]);

        if ($validator->fails()) {
            $msg = '';
            if ($validator->errors()->hasAny(['slug', 'subject'])) {
                $msg = $validator->errors()->first();
            } else {
                $msg = __('messages.form.wrong');
            }
            $notify[] = ['warning', $msg];

        } else {
            $template = EmailTemplate::where('slug', $request->input('slug'))->orWhere('id', $request->input('id'))->first();
            $template->subject = $request->input('subject');
            $template->greeting = $request->input('greeting');
            $template->message = $request->input('message');
            $template->regards = isset($request->regards) ? 'true' : 'false';
            $template->notify = isset($request->notify) ? 1 : 0;

            if ($template->save()) {
                $notify[] = ['success', 'Email Template Updated Successfully'];
            } else {
                $notify[] = ['warning', 'Email Template Update Failed'];
            }
        }


        if ($request->ajax()) {
            return response()->json($notify);
        }

	    return back()->withNotify($notify);
    }

    /**
     * Set the default data
     *
     */
    private function default_data()
    {
        $data = [
            'site_mail_driver',
            'site_mail_host' ,
            'site_mail_port' ,
            'site_mail_from_address',
            'site_mail_from_name' ,
            'site_mail_encryption',
            'site_mail_username' ,
            'site_mail_password' ,
            'site_mail_footer' ,
            'send_notification_to' ,
            'send_notification_mails' ,
        ];

        return $data;
    }
}
