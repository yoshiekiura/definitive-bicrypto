<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Frontends\FrontendInstallController;
use App\Models\frontend_images;
use App\Models\FrontendPages;
use App\Models\FrontendSections;
use App\Models\FrontendTemplates;
use Illuminate\Http\Request;

class FrontendsController extends Controller
{

    public function index()
    {
        $page_title = 'Frontend Manager';
        $templates = FrontendTemplates::latest()->paginate(getPaginate(20));
        $empty_message = 'No Data Found';
        $api = new FrontendInstallController;
        return view('admin.frontend.index',compact('page_title','templates','empty_message','api'));
    }

    public function pages($template_id)
    {
        $page_title = '';
        $pages = FrontendPages::where('template_id',$template_id)->latest()->paginate(getPaginate(20));
        $empty_message = 'No Data Found';
        return view('admin.frontend.template',compact('page_title','pages','empty_message'));
    }

    public function sections($template_id,$page_id)
    {
        $page_title = 'Page Sections';
        $sections = FrontendSections::where('template_id',$template_id)->where('page_id',$page_id)->latest()->paginate(getPaginate(20));
        $empty_message = 'No Data Found';
        return view('admin.frontend.section',compact('page_title','sections','empty_message','template_id','page_id'));
    }

    public function editor($template_id,$page_id,$section_id)
    {
        $page_title = '';
        $section = FrontendSections::where('template_id',$template_id)->where('page_id',$page_id)->where('section_id',$section_id)->first();
        $fields = FrontendSections::where('template_id',$template_id)->where('page_id',$page_id)->where('section_id',$section_id)->first()->content;
        $images = frontend_images::where('template_id',$template_id)->where('page_id',$page_id)->where('section_id',$section_id)->get();
        return view('admin.frontend.editor',compact('page_title','section','fields','images','template_id','page_id','section_id'));
    }

    public function editorUpdateText(Request $request)
    {
        $section = FrontendSections::where('template_id',$request->template_id)->where('page_id',$request->page_id)->where('section_id',$request->section_id)->first();
        $fields = $request->field;
        $content = array();
        foreach ($fields as $title => $value){
            $content = $fields;
        }
        $section->content = $content;
        $section->update();
        $notify[] = ['success', 'Section Texts Has Been Updated.'];
        return back()->withNotify($notify);
    }

    public function editorUpdateImage(Request $request)
    {
        $images = frontend_images::where('template_id',$request->template_id)->where('page_id',$request->page_id)->where('section_id',$request->section_id)->get();
        $a=0;
        foreach($images as $image){
            if ($request->has('img')) {
                $path = imagePath()['template']['path'];
                try {
                    $filename[$a] = uploadImage($request->img[$a], $path);
                } catch (\Exception $exp) {
                }
                $image->image = 'assets/images/template/'.$filename[$a];
            }
            $image->update();
            $a++;
        }
        $notify[] = ['success', 'Section Images Has Been Updated.'];
        return back()->withNotify($notify);
    }

    public function activate(Request $request)
    {
        if(FrontendTemplates::where('status',1)->exists()){
            $activeTemplate = FrontendTemplates::where('status',1)->first();
            $activeTemplate->status = 0;
            $activeTemplate->save();
        }
        $template = FrontendTemplates::findOrFail($request->id);
        $template->status = 1;
        $template->save();
        $notify[] = ['success', $template->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $template = FrontendTemplates::findOrFail($request->id);
        $template->status = 0;
        $template->save();
        $notify[] = ['success', $template->name . ' has been disabled'];
        return back()->withNotify($notify);
    }

    public function sectionActivate(Request $request)
    {
        $section = FrontendSections::where('template_id',$request->template_id)->where('page_id',$request->page_id)->where('section_id',$request->section_id)->first();
        $section->status = 1;
        $section->save();
        $notify[] = ['success', $section->title . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function sectionDeactivate(Request $request)
    {
        $section = FrontendSections::where('template_id',$request->template_id)->where('page_id',$request->page_id)->where('section_id',$request->section_id)->first();
        $section->status = 0;
        $section->save();
        $notify[] = ['success', $section->title . ' has been disabled'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update(Request $request, $id)
    {
        $template = FrontendTemplates::findOrFail($id);

        foreach ($template->shortcode as $key => $val) {
            $validation_rule = [$key => 'required'];
        }
        $request->validate($validation_rule);

        $shortcode = json_decode(json_encode($template->shortcode), true);
        foreach ($shortcode as $key => $code) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $template->shortcode = $shortcode;
        $template->save();
        $notify[] = ['success', $template->name . ' has been updated'];
        return redirect()->route('admin.frontend.index')->withNotify($notify);
    }


    public function destroy()
    {
        //
    }
}
