<?php

namespace App\Mail;

use App\Models\Bulletin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulletinReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $bulletin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Bulletin $bulletin)
    {
        $this->bulletin = $bulletin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Reminder: ' . $this->bulletin->title)
                    ->markdown('emails.bulletin_reminder');

        foreach ($this->bulletin->attachments as $attachment) {
            $mail->attachFromStorageDisk('public', $attachment->file_path);
        }

        return $mail;
    }
}
