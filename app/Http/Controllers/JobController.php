<?php

namespace App\Http\Controllers;


use App\Services\JobService;
use App\Http\Requests\NewJobRequest;



class JobController extends Controller
{

    /** @var $job */
    protected $job;

    public function __construct(JobService $job)
    {
        $this->job = $job;
    }
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
        return $this->job->save($request);
    }


    /**
     * Approve job
     * @param  integer $job_id
     * @return Response
     */
    public function approve_job($job_id)
    {
        return $this->job->approve($job_id);
    }


    public function mark_as_spam($job_id)
    {
        return $this->job->mark_job_as_spam($job_id);
    }





}
