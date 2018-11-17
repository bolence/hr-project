<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailToJobModerator;
use App\Http\Requests\NewJobRequest;
use App\Mail\SendEmailToHrManager;
use Illuminate\Http\Request;
use Exception;
use App\User;
use App\Job;
use Mail;
use Log;


class JobController extends Controller
{
    /**
     * Return form for posting a new job
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('index');
    }

    /**
     * Save a new job
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewJobRequest $request)
    {
        // posted data
        $data = $request->all();

        // save new job
        try {

        $new_job = Job::create($data);

        // find if already job exists with posted email
        if( $this->checkJobExisting( $request->email ) ){

            // send emails to hr manager and job moderator because this is first job posted
            Mail::to( $this->userTypeEmail('hr_manager') )->send( new SendEmailToHrManager() );
            Mail::to( $this->userTypeEmail('job_moderator') )->send( new SendEmailToJobModerator( $new_job ) );

        } else {

           Job::find($new_job->id)->update(['published' => 1]);

        }

       }catch( Exception $e ) {

        Log::error('Error occured on line: ' . $e->getLine() . ' in a file ' . $e->getFile() . ' with message ' . $e->getMessage());
        return redirect()->back()->with('danger', 'Something went wrong. Job not recorded.');

       }

        return redirect()->back()->with('success', 'Job posted successfully.');

    }


    /**
     * Check if posted job already exists with same email
     * @param  string   $email
     * @return boolean  true/false
     */
    protected function checkJobExisting( $email )
    {

       return Job::whereEmail( $email )->count() == 1;

    }

    /**
     * Approve job
     * @param  integer $job_id 
     * @return Response
     */
    public function approveJob($job_id)
    {

        try {

            Job::find($job_id)->update(['published' => 1]); 

        } catch( Exception $e) {

            return redirect('/')->with('danger', 'Something went wrong. Job not approved.');

        }

        return redirect('/')->with('success', 'Job approved successfully.');
        
    }


    public function markAsSpam($job_id)
    {

        try {

            Job::find($job_id)->update(['spam' => 1]); 

        } catch( Exception $e) {

            return redirect('/')->with('danger', 'Something went wrong. Job not marked as spam.');

        }

        return redirect('/')->with('success', 'Job marked as spam.');
        
    }


    /**
     * Find email by user tpe
     * @param  string  $type
     * @return string  User email
     */
    protected function userTypeEmail($user_type)
    {

        $user = User::with(['usersTypes' => function ($query) use($user_type) { 
            $query->where('type_name', '=', $user_type); 
        }])->first();

        return $user->email;

    }

   
}
