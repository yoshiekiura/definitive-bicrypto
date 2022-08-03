<?php

namespace App\Http\Controllers\Admin;

use App\Models\KYC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\KycStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KycController extends Controller
{
    public function index(Request $request, $status = '')
    {
        $per_page   = 10;
        $ordered    = 'DESC';

        $kycs = KYC::when($status, function($q) use ($status){
            $q->where('status', $status);
        })->orderBy('created_at',  $ordered)->paginate(getPaginate(10));

        if($request->s){
            $kycs = KYC::AdvancedFilter($request)
                        ->orderBy('id', $ordered)->paginate(getPaginate(10));
        }

        if ($request->filter) {
            $kycs = KYC::AdvancedFilter($request)
                        ->orderBy('id', $ordered)->paginate(getPaginate(10));
        }

        $is_page = (empty($status) ? 'all' : $status);
        $pagi = $kycs->appends(request()->all());
        return view('admin.kycs', compact('kycs', 'is_page', 'pagi'));
    }

    public function get_documents($id, $doc)
    {
        $user = Auth::user();
        $filename = KYC::where('userId', $id)->document;
        if ($doc == 2) {
            $filename = KYC::where('userId', $id)->document2;
        }
        if ($doc == 3) {
            $filename = KYC::where('userId', $id)->document3;
        }
        if ($filename !== null) {
            if (str_contains($filename, ".env") || str_contains($filename, "../") || str_contains($filename, "/..") || !str_contains($filename, "kyc-files/")) {
                abort(404);
            }

            $path = ('assets/images/kyc/' . $filename);
            if (!file_exists($path)) {
                abort(404);
            }
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = response($file, 200)->header("Content-Type", $type);

            return $response;
        } else {
            return abort(404);
        }
    }

    public function show($id = '', $type = '')
    {
        if ($type == 'kyc_details') {
            if ($id == '') {
                return __('messages.wrong');
            } else {
                $kyc = KYC::where('id', $id)->first();
                return view('admin.kyc_details', compact('kyc'))->render();
            }
        }
    }

    public function ajax_show(Request $request)
    {
        $type = $request->input('req_type');

        if ($type == 'kyc_settings') {
            return view('modals.kyc_settings')->render();
        }
    }

    public function update(Request $request)
    {

        $id = $request->input('kyc_id');
        $kyc = KYC::FindOrFail($id);
        $old_note = $kyc->notes != null ? $kyc->notes : '';
        if ($request->input('status') == 'rejected') {
            $save_note = 'In our verification process, we found the information to be incorrect. It would be great if you resubmit the form. If you face a problem with the submission please contact us with the support team';
        }
        if ($request->input('status') == 'approved') {
            $save_note = 'We successfully approved your application, you can enjoy trading in our platform with no limits';
        }
        if ($request->input('status') == 'missing') {
            $save_note = $request->input('notes') != '' ? str_replace("\n", "<br>", $request->input('notes')) : $old_note;
        }

        if ($kyc) {
            $kyc->status = $request->input('status');
            $kyc->notes = $save_note;
            $kyc->reviewedBy = Auth::id();
            $kyc->reviewedAt = date('Y-m-d H:i:s');
            $kyc->save();

            if ($request->input('status') == 'approved') {
                $kyc->user->save();
            }

            if ($kyc->user) {
                try{
                    $when = now()->addMinutes(1);
                    $kyc->user->notify((new KycStatus($kyc))->delay($when));
                    $notify[] = ['success', 'Client Notified By Mail Successfully'];
                }catch(\Exception $e){
                    $notify[] = ['warning', 'Client Notification By Mail Failed'];
                }
            }
            $notify[] = [($request->input('status') == 'approved') ? 'success' : 'warning', 'Client KYC '.$request->input('status')];
        }

        return back()->withnotify($notify);
    }

    public function delete(Request $request) {
        $id = $request->input('id');
        $delete = KYC::find($id);
        $doc1 = 'assets/images/kyc/'.$delete->document;
        $doc2 = 'assets/images/kyc/'.$delete->document2;
        $doc3 = 'assets/images/kyc/'.$delete->document3;
        if (file_exists($doc1)) {
            File::delete($doc1);
        }
        if (file_exists($doc2)) {
            File::delete($doc2);
        }
        if (file_exists($doc3)) {
            File::delete($doc3);
        }

        $delete->delete();
        $notify[] = ['success', 'KYC Deleted Successfully'];
        return back()->withnotify($notify);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $kycs = KYC::where(function ($q) use ($search) {
            $q->where('firstName', 'like',"%$search%")->orWhere('lastName', 'like',"%$search%")->orWhere('email', 'like',"%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like',"%$search%");
                });
        });

        $per_page   = 10;
        $ordered    = 'DESC';

        if($request->s){
            $kycs = KYC::AdvancedFilter($request)
                        ->orderBy('id', $ordered)->paginate(getPaginate(10));
        }

        if ($request->filter) {
            $kycs = KYC::AdvancedFilter($request)
                        ->orderBy('id', $ordered)->paginate(getPaginate(10));
        }

        $is_page = (empty($status) ? 'all' : $status);

        $kycs = $kycs->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.kycs', compact('page_title', 'empty_message', 'search', 'kycs','is_page'));
    }

}
