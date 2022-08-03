<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Ext\InstallController;
use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\SidebarMenu;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        $page_title = 'Extension';
        $extensions = Extension::orderByDesc('status')->get();
        $api = new InstallController;
        return view('admin.extension.index', compact('page_title', 'extensions','api'));
    }

    public function update(Request $request, $id)
    {
        $extension = Extension::findOrFail($id);

        foreach ($extension->shortcode as $key => $val) {
            $validation_rule = [$key => 'required'];
        }
        $request->validate($validation_rule);

        $shortcode = json_decode(json_encode($extension->shortcode), true);
        foreach ($shortcode as $key => $code) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $extension->shortcode = $shortcode;
        $extension->save();
        $notify[] = ['success', $extension->name . ' has been updated'];
        return redirect()->route('admin.extensions.index')->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $extension = Extension::findOrFail($request->id);
        if($extension->installed == 1){
            $extension->status = 1;
            $extension->save();
            $sidebars = SidebarMenu::where('addon',$request->id)->get();
            foreach($sidebars as $sidebar){
                $sidebar->status = 1;
                $sidebar->save();
                if($sidebar->id == 27){
                    $item = SidebarMenu::where('id',26)->first();
                    $item->status = 0;
                    $item->save();
                }
            }
            $notify[] = ['success', $extension->name . ' has been activated'];
        }
        return redirect()->route('admin.extensions.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $extension = Extension::findOrFail($request->id);
        if($extension->installed == 1){
            $extension->status = 0;
            $extension->save();
            $sidebars = SidebarMenu::where('addon',$request->id)->get();
            foreach($sidebars as $sidebar){
                $sidebar->status = 0;
                $sidebar->save();
                if($sidebar->id == 27){
                    $item = SidebarMenu::where('id',26)->first();
                    $item->status = 1;
                    $item->save();
                }
            }
            $notify[] = ['success', $extension->name . ' has been disabled'];
        }
        return redirect()->route('admin.extensions.index')->withNotify($notify);
    }
}
