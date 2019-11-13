<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Job;

class SendEmailToJobModerator extends Mailable
{
    use Queueable, SerializesModels;

     public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Job $job )
    {
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('new_job@jobs.com')
                    ->subject('New job on a platform')
                    ->view('emails.new_job_to_moderator')
                    ->with([
                        'approve_link' => env('APP_URL') . '/job/' . $this->job->id . '/approve',
                        'spam_link'    => env('APP_URL') . '/job/'  . $this->job->id . '/spam',
                        'job' => $this->job
                    ]);
    }
}
