<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\EmailTemplate as ET;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendMail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $mail_user = null;
    protected $mail_subject = null;
    protected $mail_message = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mail_user, $mail_subject, $mail_message)
    {
        $this->mail_user = $mail_user;
        $this->mail_subject = $mail_subject;
        $this->mail_message = $mail_message;
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

        $template = ET::get_template('send-user-email');
        $transaction = $this->mail_user;
        $user = $this->mail_user;

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

            '[[subject]]',
            '[[message]]',
            '[[user_name]]',
            '[[user_email]]',
        );
        $replace = array(
            "<br>",
            site_info('name', false),
            site_info('email', false),
            url('/'),

            $this->mail_subject,
            $this->mail_message,
            $this->mail_user->name,
            $this->mail_user->email,
        );
        $return = str_replace($shortcode, $replace, $code);
        return $return;
    }
}
