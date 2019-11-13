<?php namespace App\Services;

use App\Job;
use App\User;
use Exception;
use App\Mail\SendEmailToHrManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailToJobModerator;


class JobService {


    /**
     * SAve new job
     *
     * @param Array $request
     * @return void
     */
    public function save($request)
    {

         // save new job
         try
         {
            $job = Job::create($request->all());
            // find if already job exists with posted email
            $this->check_if_job_already_exists( $job, $request->email );
         }
         catch( Exception $e )
         {
            Log::error('Error occured:' . $e->getMessage() . ' in line ' .$e->getLine() . ' in file ' . $e->getFile());
            return redirect()->back()->with('danger', 'Something went wrong. Job not recorded.');
        }

         return redirect()->back()->with('success', 'Job posted successfully.');

    }

    /**
     * Send email to HR manager
     *
     * @return void
     */
    private function send_email_to_hr_manager()
    {
        Mail::to( $this->user_type_email('hr_manager') )->send( new SendEmailToHrManager() );
    }

    /**
     * Send email to job moderator
     *
     * @param App\Job $job
     * @return void
     */
    private function send_email_to_job_moderator(Job $job)
    {
        Mail::to( $this->user_type_email('job_moderator') )->send( new SendEmailToJobModerator( $job ) );
    }

    /**
     * Approve new job
     *
     * @param integer $job_id
     * @return void
     */
    public function approve($job_id)
    {

        try
        {
            Job::find($job_id)->update(['published' => 1]);
        }
        catch( Exception $e)
        {
            Log::error('Error occured:' . $e->getMessage() . ' in line ' .$e->getLine() . ' in file ' . $e->getFile());
            return redirect('/')->with('danger', 'Something went wrong. Job not approved.');
        }

        return redirect('/')->with('success', 'Job approved successfully.');

    }

     /**
     * Check if posted job already exists with same email
     * @param  string   $email
     * @return boolean  true/false
     */
    private function check_if_job_already_exists(Job $job_obj, $email)
    {

        $job_exists = Job::whereEmail( $email )->count() == 1;

        if( $job_exists )
        {
            $this->send_email_to_hr_manager();
            $this->send_email_to_job_moderator($job_obj);
        }
        else
        {
            $job_obj->update(['published' => 1]);
        }

    }

    /**
     * Mark jos as spam
     *
     * @param integer $job_id
     * @return void
     */
    public function mark_job_as_spam($job_id)
    {

        try
        {
            Job::find($job_id)->update(['spam' => 1]);
        }
        catch( Exception $e)
        {
            Log::error('Error occured:' . $e->getMessage() . ' in line ' .$e->getLine() . ' in file ' . $e->getFile());
            return redirect('/')->with('danger', 'Something went wrong. Job not marked as spam.');
        }

        return redirect('/')->with('success', 'Job marked as spam.');
    }


     /**
     * Find email by user tpe
     * @param  string  $type
     * @return string  User email
     */
    protected function user_type_email($user_type)
    {

        $user = User::with(['usersTypes' => function ($query) use($user_type) {
            $query->where('type_name', '=', $user_type);
        }])->first();

        return $user->email;
    }


}
