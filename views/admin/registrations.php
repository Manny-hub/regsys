<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h1 class="h4 mb-1">All Registrations</h1>
        <p class="text-secondary mb-0">Every student-course registration currently stored in the system.</p>
    </div>
    <div class="card-body p-4">
        <?php if (empty($registrations)): ?>
            <p class="text-secondary mb-0">No course registrations yet.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Code</th>
                        <th>Unit</th>
                        <th>Registered At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($registrations as $registration): ?>
                        <tr>
                            <td><?= e($registration['student_name']) ?></td>
                            <td><?= e($registration['email']) ?></td>
                            <td><?= e($registration['course_name']) ?></td>
                            <td><span class="badge text-bg-primary-subtle text-primary-emphasis"><?= e($registration['course_code']) ?></span></td>
                            <td><?= e((string) $registration['unit']) ?></td>
                            <td><?= e($registration['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
