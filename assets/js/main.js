document.addEventListener('DOMContentLoaded', () => {
    const alertContainer = document.getElementById('ajax-alert-container');

    const showAlert = (message, type = 'success') => {
        if (!alertContainer) {
            return;
        }

        alertContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    };

    document.querySelectorAll('.js-validate-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const confirmPassword = form.querySelector('.js-confirm-password');

            if (confirmPassword) {
                const matchTargetName = confirmPassword.dataset.matchTarget;
                const passwordField = form.querySelector(`[name="${matchTargetName}"]`);

                if (passwordField && confirmPassword.value !== passwordField.value) {
                    confirmPassword.setCustomValidity('Passwords do not match');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    });

    document.querySelectorAll('.js-toggle-password').forEach((toggleButton) => {
        toggleButton.addEventListener('click', () => {
            const form = toggleButton.closest('form');
            const fields = form?.querySelectorAll('.js-password-field, .js-confirm-password') || [];
            let nextType = 'password';

            fields.forEach((field) => {
                nextType = field.type === 'password' ? 'text' : 'password';
            });

            fields.forEach((field) => {
                field.type = nextType;
            });

            toggleButton.textContent = nextType === 'password' ? 'Show password' : 'Hide password';

            if (fields.length > 1) {
                toggleButton.textContent = nextType === 'password' ? 'Show passwords' : 'Hide passwords';
            }
        });
    });

    document.querySelectorAll('canvas[data-chart-type]').forEach((canvas) => {
        if (typeof Chart === 'undefined') {
            return;
        }

        const labels = JSON.parse(canvas.dataset.chartLabels || '[]');
        const values = JSON.parse(canvas.dataset.chartValues || '[]');
        const chartType = canvas.dataset.chartType || 'bar';
        const label = canvas.dataset.chartLabel || 'Dataset';
        const ctx = canvas.getContext('2d');

        const palette = ['#1d4ed8', '#06b6d4', '#f59e0b', '#10b981', '#8b5cf6', '#ef4444'];
        const config = {
            type: chartType,
            data: {
                labels,
                datasets: [{
                    label,
                    data: values,
                    borderColor: '#1d4ed8',
                    backgroundColor: chartType === 'line'
                        ? 'rgba(29, 78, 216, 0.14)'
                        : palette,
                    pointBackgroundColor: '#1d4ed8',
                    tension: 0.35,
                    fill: chartType === 'line',
                    borderWidth: 2,
                    borderRadius: chartType === 'bar' ? 10 : 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: chartType !== 'line',
                        position: 'bottom',
                    },
                },
                scales: chartType === 'doughnut' ? {} : {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        },
                    },
                },
            },
        };

        new Chart(ctx, config);
    });

    document.querySelectorAll('.js-course-action').forEach((button) => {
        button.addEventListener('click', async () => {
            const courseId = button.dataset.courseId;
            const action = button.dataset.action;
            const originalLabel = button.textContent;

            button.disabled = true;
            button.textContent = action === 'drop' ? 'Dropping...' : 'Registering...';

            try {
                const response = await fetch('controllers/course_action.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action,
                        course_id: courseId,
                        csrf_token: window.APP_CSRF_TOKEN,
                    }),
                });

                const data = await response.json();
                showAlert(data.message, data.success ? 'success' : 'danger');

                if (data.success) {
                    // Keep the page state in sync after AJAX registration changes.
                    const currentUnits = document.getElementById('current-units');
                    const registeredCount = document.getElementById('registered-count');
                    const card = button.closest('.course-card');

                    if (currentUnits && typeof data.currentUnits !== 'undefined') {
                        currentUnits.textContent = data.currentUnits;
                    }

                    if (registeredCount && typeof data.registeredCount !== 'undefined') {
                        registeredCount.textContent = data.registeredCount;
                    }

                    if (button.dataset.action === 'register') {
                        button.dataset.action = 'drop';
                        button.textContent = button.dataset.dropLabel || 'Drop Course';
                        button.classList.remove('btn-primary');
                        button.classList.add('btn-outline-danger');
                        card?.classList.add('is-registered');
                    } else {
                        if (window.location.pathname.endsWith('student_registrations.php')) {
                            button.closest('tr')?.remove();
                        } else {
                            button.dataset.action = 'register';
                            button.textContent = button.dataset.registerLabel || 'Register Course';
                            button.classList.remove('btn-outline-danger');
                            button.classList.add('btn-primary');
                            card?.classList.remove('is-registered');
                        }
                    }
                } else {
                    button.textContent = originalLabel;
                }
            } catch (error) {
                showAlert('Unable to complete the action right now. Please try again.', 'danger');
                button.textContent = originalLabel;
            } finally {
                button.disabled = false;
            }
        });
    });

    document.querySelectorAll('.js-confirm-delete').forEach((button) => {
        button.addEventListener('click', (event) => {
            if (!window.confirm('Are you sure you want to delete this course?')) {
                event.preventDefault();
            }
        });
    });
});
