<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>New job posted</title>
	
</head>
<body>

	<p>Hello,</p>
	<p>just want to inform you that new job posted on platform. </p>

	<p>Job title: {{ $job->title }} </p>
	<p>Job description: {{ $job->description }}</p>

	<p> If you want to approve this job, click <a href="{{ $approve_link }}">here </a> or <a href="{{ $spam_link }}">mark</a> as spam.</p>
	
</body>
</html>