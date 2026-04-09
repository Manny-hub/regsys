<section class="hero-panel admin-hero p-4 p-lg-5 rounded-4 mb-4 shadow-sm">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="badge rounded-pill text-bg-warning mb-3">Administrator Analytics</span>
            <h1 class="display-6 fw-bold mb-2">Portal performance at a glance</h1>
            <p class="lead mb-0 text-white-50">Track adoption, monitor registration momentum, and identify the most in-demand courses from one modern dashboard.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="admin_courses.php" class="btn btn-light btn-lg">Manage Courses</a>
        </div>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card metric-card portal-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="metric-label mb-2">Total Students</p>
                <h2 class="display-6 fw-bold mb-1"><?= e((string) $dashboard['totalStudents']) ?></h2>
                <p class="metric-footnote mb-0">Students with active portal accounts</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card metric-card portal-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="metric-label mb-2">Total Courses</p>
                <h2 class="display-6 fw-bold mb-1"><?= e((string) $dashboard['totalCourses']) ?></h2>
                <p class="metric-footnote mb-0">Available courses in the current catalog</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card metric-card portal-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="metric-label mb-2">Total Registrations</p>
                <h2 class="display-6 fw-bold mb-1"><?= e((string) $dashboard['totalRegistrations']) ?></h2>
                <p class="metric-footnote mb-0">Average <?= e((string) $dashboard['avgRegistrationsPerStudent']) ?> registrations per student</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="card analytics-card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h2 class="h4 mb-1">Registration Trend</h2>
                <p class="text-secondary mb-0">Daily registrations across the last 7 days.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas
                    id="registrationTrendChart"
                    height="120"
                    data-chart-type="line"
                    data-chart-label="Registrations"
                    data-chart-labels='<?= e(json_encode(array_column($dashboard['registrationTrend'], 'label'))) ?>'
                    data-chart-values='<?= e(json_encode(array_column($dashboard['registrationTrend'], 'total'))) ?>'
                ></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card analytics-card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h2 class="h4 mb-1">Unit Mix</h2>
                <p class="text-secondary mb-0">How registrations spread across course units.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas
                    id="unitDistributionChart"
                    height="220"
                    data-chart-type="doughnut"
                    data-chart-label="Unit Distribution"
                    data-chart-labels='<?= e(json_encode(array_map(static fn ($item) => $item["unit"] . " Units", $dashboard["unitDistribution"]))) ?>'
                    data-chart-values='<?= e(json_encode(array_map("intval", array_column($dashboard["unitDistribution"], "total")))) ?>'
                ></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-5">
        <div class="card analytics-card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h2 class="h4 mb-1">Top Registered Courses</h2>
                <p class="text-secondary mb-0">Courses drawing the strongest student demand.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas
                    id="topCoursesChart"
                    height="220"
                    data-chart-type="bar"
                    data-chart-label="Registrations"
                    data-chart-labels='<?= e(json_encode(array_column($dashboard['topCourses'], 'course_code'))) ?>'
                    data-chart-values='<?= e(json_encode(array_map("intval", array_column($dashboard['topCourses'], 'total')))) ?>'
                ></canvas>

                <div class="analytics-list mt-4">
                    <?php foreach ($dashboard['topCourses'] as $course): ?>
                        <div class="analytics-list-item">
                            <div>
                                <div class="fw-semibold"><?= e($course['course_code']) ?> - <?= e($course['course_name']) ?></div>
                                <div class="small text-secondary">Total registrations</div>
                            </div>
                            <span class="badge text-bg-primary-subtle text-primary-emphasis"><?= e((string) $course['total']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <div class="card analytics-card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h2 class="h4 mb-1">Recent Activity</h2>
                <p class="text-secondary mb-0">Authentication and course management events happening across the portal.</p>
            </div>
            <div class="card-body p-4">
                <?php if (empty($dashboard['recentActivities'])): ?>
                    <p class="text-secondary mb-0">No activity logged yet.</p>
                <?php else: ?>
                    <div class="activity-feed">
                        <?php foreach ($dashboard['recentActivities'] as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-dot"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between gap-3 flex-wrap">
                                        <div>
                                            <span class="badge text-bg-dark me-2"><?= e(ucfirst($activity['actor_type'])) ?></span>
                                            <strong><?= e($activity['action']) ?></strong>
                                        </div>
                                        <small class="text-secondary"><?= e($activity['created_at']) ?></small>
                                    </div>
                                    <p class="mb-0 text-secondary mt-2"><?= e($activity['description']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
