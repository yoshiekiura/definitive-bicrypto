<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    use HasFactory;
    protected $table = 'kycs';
    const KYC_STATUS = ['pending', 'approved', 'missing', 'rejected'];

    protected $fillable = [
        'userId', 'firstName', 'email',
    ];

    public function __construct()
    {
        //
    }

    public static function documents($name=null)
    {
        $names = [
            'passport' => __('Passport'),
            'nidcard' => __('National ID Card'),
            'driving' => __('Driver’s License'),
        ];
        if($name) {
            return isset($names[$name]) ? $names[$name] : null;
        }
        return $names;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function checker_info()
    {
        return $this->belongsTo(User::class, 'reviewedBy', 'id');
    }

    public static function AdvancedFilter($request)
    {
        if($request->s){
            $kycs = KYC::whereNotIn('status', ['deleted'])->where(function($q) use ($request){
                        $id_num = (int)(str_replace(config('icoapp.user_prefix'), '', $request->s));
                        $q->orWhere('userId', $id_num)->orWhere('firstName', 'like', '%'.$request->s.'%')->orWhere('lastName', 'like', '%'.$request->s.'%');
                    });
            return $kycs;
        }

        if ($request->filter) {
            $kycs = KYC::whereNotIn('status', ['deleted'])->where( self::keys_in_filter($request->only(['state', 'doc'])) )
                        ->when($request->search, function($q) use ($request){
                            $where  = (isset($request->by) && $request->by=='name') ? 'name' : 'userId';
                            $search = ($where=='userId') ? (int)(str_replace(config('icoapp.user_prefix'), '', $request->search)) : $request->search;
                            if($where=='name') {
                                $q->where('firstName', 'like', '%'.$search.'%')->orWhere('lastName', 'like', '%'.$search.'%');
                            } else {
                                $q->where($where, $search);
                            }
                        });
            return $kycs;
        }
        return $this;
    }

    protected static function keys_in_filter($request) {
        $result = [];
        $find = ['state', 'doc'];
        $replace = ['status', 'documentType'];
        foreach($request as $key => $value) {
            $set_key = str_replace($find, $replace, $key);
            $val = trim($value);

            if(!empty($val)) {
                $result[] = array($set_key, '=', $val);
            }
        }
        return $result;
    }

    public static function rules()
    {
        $check_doc = ( (get_setting('kyc_document_passport') || get_setting('kyc_document_driving') || get_setting('kyc_document_nidcard')) ? true : false );

        return [
            'first_name' => (field_value('kyc_firstname', 'show') && field_value('kyc_firstname', 'req')) ? 'required|string|min:2' : 'nullable',
            'last_name' => (field_value('kyc_lastname', 'show') && field_value('kyc_lastname', 'req')) ? 'required|string|min:2' : 'nullable',
            'phone' => (field_value('kyc_phone', 'show') && field_value('kyc_phone', 'req')) ? 'required|string|min:5' : 'nullable',
            'dob' => (field_value('kyc_dob', 'show') && field_value('kyc_dob', 'req')) ? 'required|date|date_format:"m/d/Y"' : 'nullable',
            'gender' => (field_value('kyc_gender', 'show') && field_value('kyc_gender', 'req')) ? 'required|string|min:2' : 'nullable',
            'telegram' => (field_value('kyc_telegram', 'show') && field_value('kyc_telegram', 'req')) ? 'required|string|min:2' : 'nullable',

            'email' => auth()->guest() ? ((field_value('kyc_email', 'show') && field_value('kyc_email', 'req')) ? 'required|string|email|max:255|unique:users' : 'nullable') : 'nullable',
            'password' => auth()->guest() ? 'required|string|min:6' : 'nullable',

            'country' => (field_value('kyc_country', 'show') && field_value('kyc_country', 'req')) ? 'required|string|min:4' : 'nullable',
            'state' => (field_value('kyc_state', 'show') && field_value('kyc_state', 'req')) ? 'required|string|min:2' : 'nullable',
            'city' => (field_value('kyc_city', 'show') && field_value('kyc_city', 'req')) ? 'required|string|min:2' : 'nullable',
            'zip' => (field_value('kyc_zip', 'show') && field_value('kyc_zip', 'req')) ? 'required|min:3' : '',
            'address_1' => (field_value('kyc_address1', 'show') && field_value('kyc_address1', 'req')) ? 'required|string|min:4' : 'nullable',
            'address_2' => (field_value('kyc_address2', 'show') && field_value('kyc_address2', 'req')) ? 'required|string|min:4' : 'nullable',

            'documentType' => $check_doc ? 'required' : 'nullable',
            'document' => $check_doc ? 'required' : 'nullable',
            'document2' => (get_setting('kyc_document_nidcard') && request()->input('documentType') == 'nidcard') ? 'required' : 'nullable',
            'document3' => $check_doc ? 'required' : 'nullable',
        ];
    }

    public static function kyc_fields($name = '')
    {
        $fields = [
            'kyc_opt_hide' => 0,
            'kyc_public' => 1,
            'kyc_before_email' => 0,
            'kyc_firstname' => array('show' => 1, 'req' => 1),
            'kyc_lastname' => array('show' => 1, 'req' => 1),
            'kyc_email' => array('show' => 1, 'req' => 1),
            'kyc_phone' => array('show' => 1, 'req' => 0),
            'kyc_dob' => array('show' => 1, 'req' => 0),
            'kyc_gender' => array('show' => 1, 'req' => 1),
            'kyc_country' => array('show' => 1, 'req' => 1),
            'kyc_state' => array('show' => 1, 'req' => 1),
            'kyc_city' => array('show' => 1, 'req' => 1),
            'kyc_zip' => array('show' => 1, 'req' => 1),
            'kyc_address1' => array('show' => 1, 'req' => 1),
            'kyc_address2' => array('show' => 1, 'req' => 0),
            'kyc_telegram' => array('show' => 1, 'req' => 0),
            'kyc_document_passport' => 1,
            'kyc_document_nidcard' => 1,
            'kyc_document_driving' => 1,
        ];
        if ($name == '') {
            return $fields;
        } else {
            return in_array($name, $fields);
        }
    }

}
