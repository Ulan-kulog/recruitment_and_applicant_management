<?php
session_start();
$heading = 'APPLICANTS';
$config = require 'config.php';
$db = new Database($config['database']);

$approved = false;
$rejected = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $status = $db->query('SELECT
   s.status,
   a.applicant_id,
   a.first_name,
   a.last_name
   FROM applicants a INNER JOIN applicationstatus s ON a.applicant_id = s.applicant_id 
   WHERE a.applicant_id = :applicant_id', [
      'applicant_id' => $_POST['applicant_id'],
   ])->fetch();
   if (!empty($_POST['approve']) && $status['status'] == 'applied') {
      $db->query('UPDATE applicationstatus SET status = :status, updated_by =:updated_by WHERE applicant_id = :applicant_id', [
         ':status' => 'approved',
         ':updated_by' => $_SESSION['user_id'],
         ':applicant_id' => $_POST['applicant_id'],
      ]);
      $db->query('INSERT INTO notifications (title,message,status,applicant_id,type,`for`) VALUES (:title,:message,:status,:applicant_id,:type,:for)', [
         ':title' => 'Application Approved',
         ':message' => 'Hello Mr/Ms ' . $status["first_name"] . ' ' . $status["last_name"] . ' Your application have been Approved',
         ':status' => 'unread',
         ':applicant_id' => $status['applicant_id'],
         ':type' => 'application',
         ':for' => 'applicant',
      ]);
      $approved = true;
   } elseif (!empty($_POST['reject']) && $status['status'] == 'applied') {
      $db->query('UPDATE applicationstatus SET status = :status, updated_by =:updated_by WHERE applicant_id = :applicant_id', [
         ':status' => 'rejected',
         ':updated_by' => $_SESSION['user_id'],
         ':applicant_id' => $_POST['applicant_id'],
      ]);
      $db->query('INSERT INTO notifications (title,message,status,applicant_id,type,`for`) VALUES (:title,:message,:status,:applicant_id,:type,:for)', [
         ':title' => 'application rejected',
         ':message' => 'Hello Mr/Ms' . $status['first_name'] . ' ' . $status['last_name'] . 'Sorry to say that your application have been rejected due to some reasons. Thank you for applying, we wish you all the best for your future endeavors',
         ':status' => 'unread',
         ':applicant_id' => $status['applicant_id'],
         ':type' => 'application',
         ':for' => 'applicant',
      ]);
      $rejected = true;
   }
}

$applicants = $db->query(
   'SELECT 
applicants.*,
applicationstatus.status,
jobpostings.job_title,
jobpostings.posted_by
FROM applicants 
INNER JOIN applicationstatus ON applicants.applicant_id = applicationstatus.applicant_id 
INNER JOIN jobpostings ON applicants.posting_id = jobpostings.posting_id
where status = "applied"
ORDER BY created_at desc',
)->fetchAll();

require 'views/hr/applicants.view.php';
