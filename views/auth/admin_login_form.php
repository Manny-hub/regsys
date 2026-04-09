<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card portal-card auth-card border-0 shadow-lg">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="badge rounded-pill text-bg-dark mb-3">Admin Login</span>
                    <h1 class="h3 mb-2">Administrator access</h1>
                    <p class="text-secondary mb-0">Manage courses, review registrations, and monitor portal activity.</p>
                </div>

                <form method="POST" novalidate class="js-validate-form">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control form-control-lg" value="<?= old('username') ?>" required>
                        <div class="invalid-feedback">Please enter the admin username.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg js-password-field" required>
                        <div class="invalid-feedback">Please enter the admin password.</div>
                    </div>

                    <div class="d-flex justify-content-end mb-4">
                        <button type="button" class="btn btn-link btn-sm p-0 js-toggle-password">Show password</button>
                    </div>

                    <button type="submit" class="btn btn-dark btn-lg w-100">Login as Admin</button>
                </form>

                <p class="small text-secondary text-center mt-4 mb-0">
                    Default setup account is created via <code>install.php</code> during first-time configuration.
                </p>
            </div>
        </div>
    </div>
</div>
