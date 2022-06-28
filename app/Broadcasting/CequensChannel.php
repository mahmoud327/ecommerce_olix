<?php

namespace App\Broadcasting;

use App\Jobs\SendOtpSms;
use Illuminate\Notifications\Notification;

class CequensChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (is_null($mobile = $notifiable->getRawOriginal('mobile'))) {
            return;
        }

        $message = (string) $notification->toSms($notifiable);
        $mobile = str_replace('+', '', $mobile);

        dispatch(new SendOtpSms($message, $mobile));
    }
}
