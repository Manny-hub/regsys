<section class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <span class="badge rounded-pill text-bg-primary mb-2">Course Directory</span>
        <h1 class="h2 mb-1">Browse and register courses</h1>
        <p class="text-secondary mb-0">Search by course name or code, then register or drop courses without reloading the page.</p>
    </div>
    <div class="text-md-end">
        <div class="unit-badge mb-2">
            Current Units: <strong id="current-units"><?= e((string) $courseData['currentUnits']) ?></strong> / <?= MAX_CREDIT_UNITS ?>
        </div>
        <div class="small text-secondary">
            Registered Courses: <span id="registered-count"><?= e((string) $courseData['registeredCount']) ?></span>
        </div>
    </div>
</section>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="form-label">Search Courses</label>
                <input type="text" name="search" class="form-control" placeholder="Search by course name or course code" value="<?= e($courseData['search']) ?>">
            </div>
            <div class="col-md-4 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Search</button>
                <a href="student_courses.php" class="btn btn-outline-secondary flex-fill">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($courseData['courses'])): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <h2 class="h5">No courses found</h2>
                    <p class="text-secondary mb-0">Try a different keyword or ask the admin to add more courses.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($courseData['courses'] as $course): ?>
        <?php $isRegistered = in_array((int) $course['id'], $courseData['registeredIds'], true); ?>
        <div class="col-md-6 col-xl-4">
            <div class="card course-card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge text-bg-light border"><?= e($course['course_code']) ?></span>
                        <span class="badge text-bg-warning"><?= e((string) $course['unit']) ?> Units</span>
                    </div>
                    <h2 class="h5"><?= e($course['course_name']) ?></h2>
                    <p class="text-secondary flex-grow-1">ESAE Bénin approved course available for online registration.</p>
                    <button
                        type="button"
                        class="btn <?= $isRegistered ? 'btn-outline-danger' : 'btn-primary' ?> js-course-action"
                        data-course-id="<?= e((string) $course['id']) ?>"
                        data-action="<?= $isRegistered ? 'drop' : 'register' ?>"
                        data-register-label="Register Course"
                        data-drop-label="Drop Course"
                    >
                        <?= $isRegistered ? 'Drop Course' : 'Register Course' ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($courseData['totalPages'] > 1): ?>
    <nav class="mt-5" aria-label="Course pagination">
        <ul class="pagination justify-content-center">
            <?php for ($pageNumber = 1; $pageNumber <= $courseData['totalPages']; $pageNumber++): ?>
                <li class="page-item <?= $pageNumber === $courseData['page'] ? 'active' : '' ?>">
                    <a class="page-link" href="?search=<?= urlencode($courseData['search']) ?>&page=<?= $pageNumber ?>">
                        <?= $pageNumber ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
