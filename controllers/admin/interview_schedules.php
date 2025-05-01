<?php

session_start();
$heading = 'Interview Schedules';
$config = require 'config.php';
$db = new Database($config['database']);

$uri = $GLOBALS['uri'];
$parts = explode('/', $uri);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    if ($_POST['delete'] ?? '' == true) {
        $db->query("DELETE FROM interviewschedules WHERE schedule_id = :schedule_id", [
            ':schedule_id' => $_POST['schedule_id'],
        ]);
    }
    validate('date', $errors);
    validate('time', $errors);
    validate('location', $errors);
    validate('mode', $errors);
    validate('interview_type', $errors);
    validate('interview_status', $errors);
    if (empty($errors)) {
        // dd($_POST);
        if ($_POST['update'] ?? '' == true) {
            // dd($_POST);
            $db->query("UPDATE interviewschedules SET date = :date, time = :time, location = :location, mode = :mode, interview_type = :interview_type, interview_status = :interview_status WHERE schedule_id = :schedule_id", [
                ':date' => $_POST['date'],
                ':time' => $_POST['time'],
                ':location' => $_POST['location'],
                ':mode' => $_POST['mode'],
                ':interview_type' => $_POST['interview_type'],
                ':interview_status' => $_POST['interview_status'],
                ':schedule_id' => $_POST['schedule_id'],
            ]);
            $success = true;
        }
    }
}

$schedules = $db->query("SELECT
s.*,
a.first_name,
i.username
FROM interviewschedules s INNER JOIN applicants a on s.applicant_id = a.applicant_id
INNER JOIN user_accounts i on i.user_id = s.interviewer_id
ORDER BY created_at DESC
")->fetchAll();

// dd($schedules);


require 'views/admin/interview_schedules.view.php';
