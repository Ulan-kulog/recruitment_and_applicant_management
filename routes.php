<?php

return [
    // login / register page route
    '/' => 'controllers/index.php',
    '/register' => 'controllers/register.php',

    // user routes
    '/home' => 'controllers/home.php',
    '/profile' => 'controllers/profile.php',
    '/application' => 'controllers/application.php',
    '/job-details' => 'controllers/job-details.php',
    '/job-application' => 'controllers/job-application.php',
    '/logout' => 'controllers/logout.php',
    '/notifications' => 'controllers/notifications.php',
    '/callback' => 'controllers/callback.php',

    // hr routes
    '/hr/' => 'controllers/hr/index.php',
    '/hr/profile' => 'controllers/hr/profile.php',
    '/hr/job-create' => 'controllers/hr/job-create.php',
    '/hr/job-details' => 'controllers/hr/job-details.php',
    '/hr/applicants' => 'controllers/hr/applicants.php',
    '/hr/hire' => 'controllers/hr/hire.php',
    '/hr/applicants-rejected' => 'controllers/hr/applicants-rejected.php',
    '/hr/set-interview' => 'controllers/hr/set-interview.php',
    '/hr/applicant-view' => 'controllers/hr/applicant-view.php',
    '/hr/applicant-notification' => 'controllers/hr/applicant-notification.php',
    '/hr/applicants-approved' => 'controllers/hr/applicants-approved.php',
    '/hr/applicants-reject' => 'controllers/hr/applicants-reject.php',
    '/hr/applicants-interview' => 'controllers/hr/applicants-interview.php',
    '/hr/applicants-history' => 'controllers/hr/applicants-history.php',

    // hr_hiring routes
    '/hr_hiring/' => 'controllers/hr_hiring/index.php',
    '/hr_hiring/profile' => 'controllers/hr_hiring/profile.php',
    '/hr_hiring/job-details' => 'controllers/hr_hiring/job-details.php',
    '/hr_hiring/applicants-offer' => 'controllers/hr_hiring/applicants-offer.php',
    '/hr_hiring/applicants-offered' => 'controllers/hr_hiring/applicants-offered.php',
    '/hr_hiring/applicants' => 'controllers/hr_hiring/applicants.php',
    '/hr_hiring/set-interview' => 'controllers/hr_hiring/set-interview.php',
    '/hr_hiring/interview-history' => 'controllers/hr_hiring/interview-history.php',
    '/hr_hiring/applicants-interview' => 'controllers/hr_hiring/applicants-interview.php',
    '/hr_hiring/notifications' => 'controllers/hr_hiring/notifications.php',

    // manager routes
    '/manager/' => 'controllers/manager/index.php',
    '/manager/job-details' => 'controllers/manager/job-details.php',
    '/manager/applicants' => 'controllers/manager/applicants.php',
    '/manager/applicant-view' => 'controllers/manager/applicant-view.php',
    '/manager/job-offers' => 'controllers/manager/job-offers.php',
    '/manager/job-offer' => 'controllers/manager/job-offer.php',
    '/manager/applicant-notification' => 'controllers/manager/applicant-notification.php',

    // admin routes
    '/admin/' => 'controllers/admin/index.php',
    '/admin/applicants' => 'controllers/admin/applicants.php',
    '/admin/applicant' => 'controllers/admin/applicant.php',
    '/admin/jobs' => 'controllers/admin/jobs.php',
    '/admin/job' => 'controllers/admin/job.php',
    '/admin/job-offers' => 'controllers/admin/job-offers.php',
    '/admin/job-offer-view' => 'controllers/admin/job-offer-view.php',
    '/admin/users' => 'controllers/admin/users.php',
    '/admin/interview_schedules' => 'controllers/admin/interview_schedules.php',
    '/admin/interview_schedules-create' => 'controllers/admin/interview_schedules-create.php',
];
