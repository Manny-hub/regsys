<div class="row g-4">
    <div class="col-lg-4">
        <div class="card analytics-card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h1 class="h4 mb-1"><?= $editingCourse ? 'Edit Course' : 'Add New Course' ?></h1>
                <p class="text-secondary mb-0">Create and manage available university courses.</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" novalidate class="js-validate-form">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <?php if ($editingCourse): ?>
                        <input type="hidden" name="course_id" value="<?= e((string) $editingCourse['id']) ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="course_name" class="form-control" value="<?= e($formData['course_name']) ?>" minlength="3" required>
                        <div class="invalid-feedback">Course name should be at least 3 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Course Code</label>
                        <input type="text" name="course_code" class="form-control text-uppercase" value="<?= e($formData['course_code']) ?>" pattern="[A-Za-z]{2,10}[0-9]{1,5}" required>
                        <div class="form-text">Example: CSC101 or MTH204</div>
                        <div class="invalid-feedback">Please use a valid course code like CSC101.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Credit Unit</label>
                        <input type="number" name="unit" class="form-control" min="1" max="10" value="<?= e($formData['unit']) ?>" required>
                        <div class="invalid-feedback">Credit unit must be between 1 and 10.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="save_course" class="btn btn-dark">
                            <?= $editingCourse ? 'Update Course' : 'Add Course' ?>
                        </button>
                        <?php if ($editingCourse): ?>
                            <a href="admin_courses.php" class="btn btn-outline-secondary">Cancel Editing</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card analytics-card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="h4 mb-1">Course List</h2>
                        <p class="text-secondary mb-0">Search, paginate, edit, and delete courses.</p>
                    </div>
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search courses" value="<?= e($search) ?>">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </form>
                </div>
            </div>
            <div class="card-body p-4">
                <?php if (empty($courses)): ?>
                    <p class="text-secondary mb-0">No courses available yet.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-modern align-middle">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><span class="badge text-bg-primary-subtle text-primary-emphasis"><?= e($course['course_code']) ?></span></td>
                                    <td><?= e($course['course_name']) ?></td>
                                    <td><?= e((string) $course['unit']) ?></td>
                                    <td class="text-end">
                                        <a href="?search=<?= urlencode($search) ?>&page=<?= $page ?>&edit=<?= $course['id'] ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                            <input type="hidden" name="delete_course_id" value="<?= e((string) $course['id']) ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm js-confirm-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($totalPages > 1): ?>
                    <nav class="mt-4" aria-label="Admin course pagination">
                        <ul class="pagination justify-content-center">
                            <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++): ?>
                                <li class="page-item <?= $pageNumber === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $pageNumber ?>">
                                        <?= $pageNumber ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
