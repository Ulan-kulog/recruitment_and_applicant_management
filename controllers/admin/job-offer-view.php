<?php
session_start();
$heading = 'Job offer';
$config = require 'config.php';
$db = new Database($config['database']);

$offer = $db->query('SELECT * FROM job_offer WHERE offer_id = :offer_id', [
    'offer_id' => $_GET['id']
])->fetch();

$applicant = $db->query('SELECT
a.*,
d.*,
s.status,
j.job_title,
j.location,
j.employment_type
FROM applicants a INNER JOIN documents d ON a.applicant_id = d.applicant_id
INNER JOIN applicationstatus s ON a.applicant_id = s.applicant_id
INNER JOIN jobpostings j ON a.posting_id = j.posting_id
WHERE a.applicant_id = :applicant_id', [
    'applicant_id' => $offer['applicant_id']
])->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if ($_POST['hire'] ?? '' == true) {
        $db->query('UPDATE applicationstatus SET status = :status WHERE applicant_id = :applicant_id', [
            'status' => 'Hired',
            'applicant_id' => $applicant['applicant_id']
        ]);
        $db->query("INSERT INTO notifications (title, message, status, applicant_id, type, `for`) VALUES (:title, :message, :status, :applicant_id, :type, :for)", [
            ':title' => 'Congratulations!',
            ':message' => 'You have been hired for the position of ' . $offer['position'],
            'status' => 'unread',
            'applicant_id' => $offer['applicant_id'],
            ':type' => 'hired',
            ':for' => 'applicant'
        ]);
        header('Location: /admin/job-offers');
        exit;
    }
    if ($_POST['delete'] ?? '' == true) {
        $db->query('DELETE FROM job_offer WHERE offer_id = :offer_id', [
            'offer_id' => $_POST['offer_id']
        ]);
        header('Location: /admin/job-offers');
        exit;
    }
}
require 'views/admin/job-offers-view.view.php';
