<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card portal-card auth-card border-0 shadow-lg">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="badge rounded-pill text-bg-primary mb-3">Student Login</span>
                    <h1 class="h3 mb-2">Welcome back</h1>
                    <p class="text-secondary mb-0">Log in to register courses, manage your selections, and track your current units.</p>
                </div>

                <form method="POST" novalidate class="js-validate-form">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" value="<?= old('email') ?>" required>
                        <div class="invalid-feedback">Please enter the email address linked to your account.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg js-password-field" required>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>

                    <div class="d-flex justify-content-end mb-4">
                        <button type="button" class="btn btn-link btn-sm p-0 js-toggle-password">Show password</button>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
                </form>

                <p class="text-center text-secondary mt-4 mb-0">
                    New student?
                    <a href="student_register.php" class="fw-semibold">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</div>
