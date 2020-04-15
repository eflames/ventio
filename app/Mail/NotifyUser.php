<?php

namespace App\Mail;

use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUser extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param $mailData
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $store_email = Config::where('key', 'store_email')->pluck('value')->first();
        $store_name = Config::where('key', 'store_name')->pluck('value')->first();

        return $this->markdown('mails.loanNotify')
            ->from($store_email, $store_name)
            ->to($this->data['email'])
            ->subject('Recordatorio de crédito');
    }
}
