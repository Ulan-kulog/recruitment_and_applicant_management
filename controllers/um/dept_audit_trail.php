<?php
session_start();
$config = require 'config.php';
$heading = 'Department Audit Trail';
$usm = new Database($config['usm']);
$socreg = new Database($config['socreg']);
// $audit = [];
$audit = $usm->query('SELECT * FROM department_audit_trail')->fetchAll();
// $audit['ram_audit'] = $ram_audit;
// $socreg_audit = $socreg->query('SELECT * FROM department_audit_trail')->fetchAll();
// $audit['socreg_audit'] = $socreg_audit;
// dd($audit['ram_audit']);
// dd($socreg_audit);
// dd($audit);
require 'views/um/dept_audit_trail.view.php';
