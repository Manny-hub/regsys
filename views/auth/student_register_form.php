<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card portal-card auth-card border-0 shadow-lg">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="badge rounded-pill text-bg-warning mb-3">Student Registration</span>
                    <h1 class="h3 mb-2">Create your student account</h1>
                    <p class="text-secondary mb-0">Register to access course enrollment, course dropping, and your personalized dashboard.</p>
                </div>

                <form method="POST" novalidate class="js-validate-form">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control form-control-lg" value="<?= old('name') ?>" minlength="3" required>
                        <div class="form-text">Use your official university full name.</div>
                        <div class="invalid-feedback">Please enter a valid full name with at least 3 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" value="<?= old('email') ?>" required>
                        <div class="form-text">Your login email must be unique.</div>
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg js-password-field" minlength="6" required>
                            <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg js-confirm-password" data-match-target="password" required>
                            <div class="invalid-feedback">Passwords must match before you continue.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="small text-secondary">Minimum password length: 6 characters</div>
                        <button type="button" class="btn btn-link btn-sm p-0 js-toggle-password">Show passwords</button>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Create Account</button>
                </form>

                <p class="text-center text-secondary mt-4 mb-0">
                    Already have an account?
                    <a href="student_login.php" class="fw-semibold">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
