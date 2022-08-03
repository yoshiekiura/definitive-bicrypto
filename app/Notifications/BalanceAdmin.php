<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\EmailTemplate as ET;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BalanceAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tnx_data = null;
    protected $template = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tnx_data, $template)
    {
        $this->tnx_data = $tnx_data;
        $this->template = $template;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $from_name = email_setting('from_name', get_setting('site_name'));
        $from_email = email_setting('from_email', get_setting('site_email'));

        $template = ET::get_template('balance-'.$this->template.'-by-admin');
        $transaction = $this->tnx_data;
        $user = $this->tnx_data->user;

        $template->message = $this->replace_shortcode($template->message);
        $template->regards = ($template->regards == 'true' ? get_setting('site_mail_footer', "Best Regards, \n[[site_name]]") : '');

        return (new MailMessage)
                    ->greeting($this->replace_shortcode($template->greeting))
                    ->salutation($this->replace_shortcode($template->regards))
                    ->from($from_email, $from_name)
                    ->subject($this->replace_shortcode($template->subject))
                    ->markdown('mail.transaction', compact('template', 'transaction','user'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the short-code and replace with data.
     *
     * @param  mixed  $code
     * @return void
     */
    public function replace_shortcode($code)
    {
        $shortcode =array(
            "\n",
            '[[site_name]]',
            '[[site_email]]',
            '[[site_url]]',

            '[[amount]]',
            '[[currency]]',
            '[[trx]]',
            '[[post_balance]]',
            '[[user_name]]',
            '[[user_email]]',
        );
        $replace = array(
            "<br>",
            site_info('name', false),
            site_info('email', false),
            url('/'),

            number_format($this->tnx_data->amount, 2),
            $this->tnx_data->currency,
            $this->tnx_data->trx,
            number_format($this->tnx_data->post_balance, 2),
            $this->tnx_data->user->name,
            $this->tnx_data->user->email,
        );
        $return = str_replace($shortcode, $replace, $code);
        return $return;
    }
}
