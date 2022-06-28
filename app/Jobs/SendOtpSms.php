<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendOtpSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $messageType;

    /**
     * @var string
     */
    public $mobileNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $mobileNumber, $messageType = 'text')
    {
        $this->message = $message;
        $this->mobileNumber = $mobileNumber;
        $this->messageType = $messageType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.cequens.com/cequens/api/v1/messaging",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => "{\n \"messageText\":\"$this->message\",\n\"senderName\":\"" . config('cequens.sender_id') . "\",\n\"messageType\":\"$this->messageType\",\n\"recipients\":\"$this->mobileNumber\"   \n}",
            CURLOPT_HTTPHEADER     => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer " . config('cequens.token'),
            ),
        ));

        curl_exec($curl);

        curl_close($curl);
    }
}
