<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\EmailTemplate as ET;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SupportTic extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tic_data = null;
    protected $mes_data = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tic_data, $mes_data)
    {
        $this->tic_data = $tic_data;
        $this->mes_data = $mes_data;
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

        $template = ET::get_template('support-ticket-reply');
        $transaction = $this->tic_data;
        $user = $this->tic_data->user;

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

            '[[ticket_id]]',
            '[[ticket_subject]]',
            '[[reply]]',
            '[[link]]',
            '[[user_name]]',
            '[[user_email]]',
        );
        $replace = array(
            "<br>",
            site_info('name', false),
            site_info('email', false),
            url('/'),

            $this->tic_data->ticket,
            $this->tic_data->subject,
            $this->mes_data->message,
            route('ticket.view',$this->tic_data->ticket),
            $this->tic_data->user->name,
            $this->tic_data->user->email,
        );
        $return = str_replace($shortcode, $replace, $code);
        return $return;
    }
}
