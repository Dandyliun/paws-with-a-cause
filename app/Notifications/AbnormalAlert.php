<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Dog;

class AbnormalAlert extends Notification
{
    use Queueable;

    private $dogId;
    private $recordType;
    private $value;
    private $comments;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dogId, $recordType, $value, $comments)
    {
        $this->dogId = $dogId;
        $this->recordType = $recordType;
        $this->value = $value;
        $this->comments = $comments;
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

        $dog = Dog::find($this->dogId);

        return (new MailMessage)
                    ->subject('Abnormality Alert')
                    ->markdown('mail.abnormality', [
                        'dog' => $dog,
                        'recordType' => $this->recordType,
                        'value' => $this->value,
                        'comments' => $this->comments
                    ]);
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
}
