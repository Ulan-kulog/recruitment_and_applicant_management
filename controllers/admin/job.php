<?php
session_start();
$heading = 'Job Posting';
$config = require 'config.php';
$db = new Database($config['database']);

$errors = [];
// $delete = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete']) && $_POST['delete'] == true) {

        // DELETE SQL STATEMENT. DECLARE THE TABLE_NAME THEN WHERE CONDITION TO DEFINE THE SPECIFIC RECORD TO BE DELETED. 
        $db->query("DELETE FROM jobpostings WHERE posting_id = :posting_id", [
            ':posting_id' => $_POST['id']
        ]);
        header('location: /admin/jobs');
        exit();
        $_SESSION['job-delete'] = true;
    }


    // DATA VALIDATION (IF EMPTY == errors[]);
    validate('job_title', $errors);
    validate('company', $errors);
    validate('description', $errors);
    validate('location', $errors);
    validate('salary', $errors);
    validate('requirements', $errors);
    validate('employment_type', $errors);

    // IF ERRORS IS EMPTY THIS BLOCK WILL RUN
    if (empty($errors)) {
        // dd($_POST);
        // UPDATE SQL STATEMENT FOR UPDATING RECORDS. ADD THE WHERE CONDITION IF NECESSARY.
        $db->query('UPDATE jobpostings SET job_title = :job_title, company = :company, location = :location, salary = :salary, employment_type = :employment_type WHERE posting_id = :posting_id', [
            ':job_title' => $_POST['job_title'],
            ':company' => $_POST['company'],
            ':location' => $_POST['location'],
            ':salary' => $_POST['salary'],
            ':employment_type' => $_POST['employment_type'],
            ':posting_id' => $_GET['id']
        ]);

        $db->query('UPDATE prerequisites SET description = :description, requirements = :requirements WHERE posting_id = :posting_id', [
            ':description' => $_POST['description'],
            ':requirements' => $_POST['requirements'],
            ':posting_id' => $_GET['id']
        ]);
        $success = true;
    }
}

// FETCHING THE DATA FROM THE DATABASE.
$job = $db->query('SELECT 
j.*,
u.username,
u.user_id,
p.*
FROM jobpostings j INNER JOIN user_accounts u on u.user_id = j.posted_by 
INNER JOIN prerequisites p on p.posting_id = j.posting_id
WHERE j.posting_id = :posting_id', [
    ':posting_id' => $_GET['id'],
])->fetch();

// $test = $db->query('SELECT 
// j.*,
// p.*
// FROM jobpostings j INNER JOIN prerequisites p on p.posting_id = j.posting_id
//  WHERE j.posting_id = :posting_id', [
//     ':posting_id' => $_GET['id'],
// ])->fetch();
// dd($test);

require 'views/admin/job.view.php';
