<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Broadcasting\CequensChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code = null, $message = null)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed   $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CequensChannel::class];
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param  mixed    $notifiable
     * @return string
     */
    public function toSms($notifiable)
    {
        return $this->message ?? ("Your code " . $this->code ?? $notifiable->pin_code . " - Suiiz");
    }
}
