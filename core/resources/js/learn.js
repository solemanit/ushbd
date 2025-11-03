document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('markCompleteBtn');
    const toast = new bootstrap.Toast(document.querySelector('.toast'));

    if (btn) {
        btn.addEventListener('click', function() {
            // Update button state
            btn.disabled = true;
            const originalContent = btn.innerHTML;
            btn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Marking as complete...
            `;

            const courseId = btn.dataset.courseId;
            const lessonId = btn.dataset.lessonId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const url = `/student/my-courses/${courseId}/lessons/${lessonId}/complete`;
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                // Show success toast
                const toastEl = document.querySelector('.toast');
                if (data.progressPercent === 100) {
                    toastEl.querySelector('.toast-body').innerHTML = `
                        <i class="fas fa-trophy text-warning me-2"></i>
                        🎉 Congratulations! You've completed the course!
                    `;
                } else {
                    toastEl.querySelector('.toast-body').innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>
                        Lesson completed successfully!
                    `;
                }
                toast.show();

                // Redirect after delay
                setTimeout(() => {
                    if (data.nextLessonUrl) {
                        const transition = document.createElement('div');
                        transition.className = 'top-0 bg-white position-fixed start-0 w-100 h-100';
                        transition.style.zIndex = '9999';
                        transition.style.opacity = '0';
                        transition.style.transition = 'opacity 0.3s ease-in-out';
                        document.body.appendChild(transition);

                        setTimeout(() => {
                            transition.style.opacity = '1';
                            setTimeout(() => {
                                window.location.href = data.nextLessonUrl;
                            }, 300);
                        }, 50);
                    } else {
                        location.reload();
                    }
                }, data.progressPercent === 100 ? 2000 : 1000);
            })
            .catch(error => {
                // Show error toast
                const toastEl = document.querySelector('.toast');
                toastEl.classList.remove('bg-success');
                toastEl.classList.add('bg-danger');
                toastEl.querySelector('.toast-body').innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Failed to mark lesson as complete
                `;
                toast.show();

                // Reset button
                btn.disabled = false;
                btn.innerHTML = originalContent;
            });
        });
    }

    // Initialize all tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
