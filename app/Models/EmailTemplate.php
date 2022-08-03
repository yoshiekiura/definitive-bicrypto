<?php

namespace App\Models;

use IcoData;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    /*
     * Table Name Specified
     */
    protected $table = 'email_templates';

    /*
     * All Templates Name
     */
    protected static $names = [
        'welcome-email','kyc-approved-email', 'kyc-rejected-email', 'kyc-missing-email', 'kyc-submit-email', 'send-user-email', 'support-ticket-reply', 'users-unusual-login-email', 'automated-deposit-successful', 'manual-deposit-user-requested', 'manual-deposit-admin-approved', 'manual-deposit-admin-rejected', 'withdraw-user-requested', 'withdraw-admin-rejected', 'withdraw-admin-approved', 'balance-add-by-admin', 'balance-subtracted-by-admin', 'Commission Bonus',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'subject', 'message', 'greeting', 'regards',
    ];

    /**
     * Get the email template
     *
     * @version 1.0.0
     * @since 1.0
     * @return void
     */
    public static function get_template($name)
    {
        $template = self::where('slug', $name)->orWhere('id', $name)->first();
        if (!$template) {
            $template = IcoData::default_email_template($name);
            if(!$template) {
                $template = (object) [
                    'name' => str_replace('-', ' ', $name),
                    'slug' => $name,
                    'subject' => "Email From ".site_info(),
                    'greeting' => "Hello",
                    'message' => "",
                    'regards' => true,
                ];
            }
        }

        return $template;
    }
}
