<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/models/Registration.php';

require_admin_auth();

$registrations = Registration::getAllDetailed();
$pageTitle = 'All Registrations';

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/admin/registrations.php';
require __DIR__ . '/views/partials/footer.php';
