<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\EmailTemplate as ET;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Withdraw extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tnx_data = null;
    protected $withd = null;
    protected $template = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tnx_data, $withd, $template)
    {
        $this->tnx_data = $tnx_data;
        $this->withd = $withd;
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

        $template = ET::get_template('withdraw-' . $this->template);
        $transaction = $this->tnx_data;
        $user = $this->tnx_data->user;

        $template->message = $this->replace_shortcode($template->message);
        $template->regards = ($template->regards == 'true' ? get_setting('site_mail_footer', "Best Regards, \n[[site_name]]") : '');

        return (new MailMessage)
            ->greeting($this->replace_shortcode($template->greeting))
            ->salutation($this->replace_shortcode($template->regards))
            ->from($from_email, $from_name)
            ->subject($this->replace_shortcode($template->subject))
            ->markdown('mail.transaction', compact('template', 'transaction', 'user'));
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
        $shortcode = array(
            "\n",
            '[[site_name]]',
            '[[site_email]]',
            '[[site_url]]',

            '[[amount]]',
            '[[currency]]',
            '[[method_name]]',
            '[[charge]]',
            '[[rate]]',
            '[[method_currency]]',
            '[[method_amount]]',
            '[[trx]]',
            '[[delay]]',
            '[[post_balance]]',
            '[[user_name]]',
            '[[user_email]]',
            '[[admin_details]]',
        );
        $replace = array(
            "<br>",
            site_info('name', false),
            site_info('email', false),
            url('/'),

            getAmount($this->tnx_data->amount),
            $this->withd->symbol,
            $this->withd->method->name,
            getAmount($this->tnx_data->charge),
            getAmount($this->withd->rate),
            $this->withd->currency ?? '$',
            getAmount($this->withd->amount),
            $this->tnx_data->trx,
            $this->withd->method->delay,
            getAmount($this->tnx_data->post_balance),
            $this->tnx_data->user->name,
            $this->tnx_data->user->email,
            $this->withd->admin_feedback,

        );
        $return = str_replace($shortcode, $replace, $code);
        return $return;
    }
}
