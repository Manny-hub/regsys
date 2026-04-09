<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/controllers/AdminController.php';

require_admin_auth();

$dashboard = AdminController::getDashboardData();
$pageTitle = 'Admin Dashboard';
$includeCharts = true;

require __DIR__ . '/views/partials/header.php';
require __DIR__ . '/views/admin/dashboard.php';
require __DIR__ . '/views/partials/footer.php';
