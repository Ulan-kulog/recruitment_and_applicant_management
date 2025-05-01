<?php

session_start();

$heading = 'Job';
$config = require 'config.php';
$db = new Database($config['database']);

$job = $db->query('SELECT
j.*,
p.*
FROM jobpostings j INNER JOIN prerequisites p on p.posting_id = j.posting_id
WHERE j.posting_id = :posting_id', [
    ':posting_id' => $_GET['id'],
])->fetch();

// dd($job);

$postings = $db->query('SELECT * FROM jobpostings ORDER BY created_at desc')->fetchAll();
$applications = $db->query('SELECT * from applicants where user_id = :user_id', [
    'user_id' => $_SESSION['user_id']
])->fetchAll();

$applications = $db->query("SELECT * FROM applicants")->fetchAll();

// dd($applications);

require 'views/job-details.view.php';
