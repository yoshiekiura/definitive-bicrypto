<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\EmailTemplate as ET;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DepositNote extends Notification implements ShouldQueue
{
    use Queueable;

    protected $dp_data = null;
    protected $template = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dp_data, $template)
    {
        $this->dp_data = $dp_data;
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

        $template = ET::get_template($this->template);
        $transaction = $this->dp_data;
        $user = $this->dp_data->user;

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

            '[[username]]',
            '[[amount]]',
            '[[currency]]',
            '[[method_name]]',
            '[[charge]]',
            '[[rate]]',
            '[[method_currency]]',
            '[[method_amount]]',
            '[[trx]]',
            '[[post_balance]]',
            '[[user_name]]',
            '[[user_email]]',
            '[[rejection_message]]',
        );
        $replace = array(
            "<br>",
            site_info('name', false),
            site_info('email', false),
            url('/'),

            $this->dp_data->details,
            getAmount($this->dp_data->amount),
            $this->dp_data->currency,
            $this->dp_data->details,
            getAmount($this->dp_data->charge),
            getAmount($this->dp_data->rate),
            $this->dp_data->method_currency,
            getAmount($this->dp_data->final_amo),
            $this->dp_data->trx,
            getAmount($this->dp_data->post_balance),
            $this->dp_data->user->name,
            $this->dp_data->user->email,
            $this->dp_data->admin_feedback,
        );
        $return = str_replace($shortcode, $replace, $code);
        return $return;
    }
}
