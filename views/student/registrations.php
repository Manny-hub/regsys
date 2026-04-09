<section class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <span class="badge rounded-pill text-bg-success mb-2">My Registrations</span>
        <h1 class="h2 mb-1">Registered courses</h1>
        <p class="text-secondary mb-0">Review your current schedule and drop courses when needed.</p>
    </div>
    <div class="unit-badge">
        Current Units: <strong id="current-units"><?= e((string) $currentUnits) ?></strong> / <?= MAX_CREDIT_UNITS ?>
    </div>
</section>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <?php if (empty($registeredCourses)): ?>
            <div class="empty-state text-center py-5">
                <h2 class="h5">You have not registered for any courses</h2>
                <p class="text-secondary">Visit the course directory to start building your semester load.</p>
                <a href="student_courses.php" class="btn btn-primary">Browse Courses</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Unit</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($registeredCourses as $course): ?>
                        <tr>
                            <td><span class="badge text-bg-primary-subtle text-primary-emphasis"><?= e($course['course_code']) ?></span></td>
                            <td><?= e($course['course_name']) ?></td>
                            <td><?= e((string) $course['unit']) ?></td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-danger btn-sm js-course-action"
                                    data-course-id="<?= e((string) $course['id']) ?>"
                                    data-action="drop"
                                    data-register-label="Register Course"
                                    data-drop-label="Drop Course"
                                >
                                    Drop Course
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
