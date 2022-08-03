<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use App\Models\frontend_images;
use App\Models\FrontendPages;
use App\Models\FrontendSections;
use App\Models\FrontendTemplates;
use App\Models\GeneralSetting;
use App\Models\Pairs;
use App\Models\Platform;
use App\Models\ThirdpartyProvider;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function __construct()
    {

        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
            $exchange_class = "\\ccxt\\$thirdparty->title";
            $this->api = new $exchange_class(array(
                'apiKey' => $thirdparty->api,
                'secret' => $thirdparty->secret,
                'password' => $thirdparty->password,
            ));
            $this->provider = $thirdparty->title;
        } else {
            $this->provider = null;
        }
        #$this->api->set_sandbox_mode('enable');
    }
    public function home()
    {
        $page_title = "Home";
        $template = FrontendTemplates::where('status', 1)->first();
        $page = FrontendPages::where('template_id', $template->template_id)->first();
        $sections = FrontendSections::where('template_id', $template->template_id)->where('page_id', $page->page_id)->get();
        $images = frontend_images::where('template_id', $template->template_id)->where('page_id', $page->page_id)->get();
        $platform['frontend'] = json_decode(Platform::where('option', 'frontend')->first()->settings);
        $platform = arrayToObject($platform);
        return view('frontends.' . $template->title . '.content', compact('page_title', 'sections', 'images', 'template', 'platform'));
    }

    public function trade($symbol, $currency)
    {
        $page_title = $symbol . '/' . $currency . " Trade";
        $user = Auth::user();
        $gnl = GeneralSetting::first();
        $limits = json_decode(GeneralSetting::where('id', '1')->first()->limits);
        if ($this->provider != null) {
            $jsonString = file_get_contents(public_path('data/markets/markets.json'));
            $exchange = $this->provider;
            if ($this->provider == 'coinbasepro') {
                $provide = 'COINBASE';
                $provider = $this->provider;
                $markets = json_decode($jsonString, true)[$this->provider];
            } else if ($this->provider == 'kucoin') {
                $provide = 'KUCOIN';
                $provider = $this->provider;
                $markets = json_decode($jsonString, true)[$this->provider];
            } else {
                $provide = 'KUCOIN';
                $provider = 'kucoin';
                $markets = json_decode($jsonString, true)['kucoin'];
            }
            return view('frontends.trade', compact('page_title', 'exchange', 'gnl', 'symbol', 'currency', 'provider', 'provide', 'markets'));
        } else {
            return view('frontends.trade_noparty', compact('page_title', 'gnl', 'symbol', 'currency'));
        }
    }

    public function about(Request $request)
    {
        return view('frontends.about');
    }

    public function banned(Request $request)
    {
        return view('errors.407');
    }

    public function terms()
    {
        return view('frontends.terms');
    }
    public function seoEdit()
    {
        $page_title = 'SEO Metadata';
        $seo = Frontend::where('data_keys', 'seo.data')->first();
        if (!$seo) {
            $data_values = '{"keywords":["admin","blog"],"description":"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit","social_title":"WEBSITENAME","social_description":"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit","image":null}';
            $data_values = json_decode($data_values, true);
            $frontend = new Frontend();
            $frontend->data_keys = 'seo.data';
            $frontend->data_values = $data_values;
            $frontend->save();
        }
        return view('admin.setting.seo', compact('page_title', 'seo'));
    }
    public function frontendContent(Request $request, $key)
    {
        $purifier = new \HTMLPurifier();
        $valInputs = $request->except('_token', 'image_input', 'key', 'status', 'type', 'id');
        foreach ($valInputs as $keyName => $input) {
            if (gettype($input) == 'array') {
                $inputContentValue[$keyName] = $input;
                continue;
            }
            $inputContentValue[$keyName] = $purifier->purify($input);
        }
        $type = $request->type;
        if (!$type) {
            abort(404);
        }
        $validation_rule = [];
        $validation_message = [];
        foreach ($request->except('_token', 'video') as $input_field => $val) {
            if ($input_field == 'has_image' && $imgJson) {
                foreach ($imgJson as $imgValKey => $imgJsonVal) {
                    $validation_rule['image_input.' . $imgValKey] = ['nullable', 'image', 'mimes:jpeg,jpg,png'];
                    $validation_message['image_input.' . $imgValKey . '.image'] = inputTitle($imgValKey) . ' must be an image';
                    $validation_message['image_input.' . $imgValKey . '.mimes'] = inputTitle($imgValKey) . ' file type not supported';
                }
                continue;
            } elseif ($input_field == 'seo_image') {
                $validation_rule['image_input'] = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
                continue;
            }
            $validation_rule[$input_field] = 'required';
        }
        $request->validate($validation_rule, $validation_message, ['image_input' => 'image']);
        if ($request->id) {
            $content = Frontend::findOrFail($request->id);
        } else {
            $content = Frontend::where('data_keys', $key . '.' . $request->type)->first();
            if (!$content || $request->type == 'element') {
                $content = new Frontend();
                $content->data_keys = $key . '.' . $request->type;
                $content->save();
            }
        }
        if ($type == 'data') {
            $inputContentValue['image'] = @$content->data_values->image;
            if ($request->hasFile('image_input')) {
                try {
                    $inputContentValue['image'] = uploadImage($request->image_input, imagePath()['seo']['path'], imagePath()['seo']['size'], @$content->data_values->image);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the Image.'];
                    return back()->withNotify($notify);
                }
            }
        } else {
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    $imgData = @$request->image_input[$imgKey];
                    if (is_file($imgData)) {
                        try {
                            $inputContentValue[$imgKey] = $this->storeImage($imgJson, $type, $key, $imgData, $imgKey, @$content->data_values->$imgKey);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Could not upload the Image.'];
                            return back()->withNotify($notify);
                        }
                    } else if (isset($content->data_values->$imgKey)) {
                        $inputContentValue[$imgKey] = $content->data_values->$imgKey;
                    }
                }
            }
        }
        $content->data_values = $inputContentValue;
        $content->save();
        $notify[] = ['success', 'Content has been updated.'];
        return back()->withNotify($notify);
    }
}
