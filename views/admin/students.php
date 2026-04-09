<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h1 class="h4 mb-1">All Students</h1>
        <p class="text-secondary mb-0">Registered student accounts and their current number of registered courses.</p>
    </div>
    <div class="card-body p-4">
        <?php if (empty($students)): ?>
            <p class="text-secondary mb-0">No students have registered yet.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered Courses</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= e($student['name']) ?></td>
                            <td><?= e($student['email']) ?></td>
                            <td><?= e((string) $student['registered_courses']) ?></td>
                            <td><?= e($student['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
