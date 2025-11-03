@extends('frontend.dashboard.layouts.master')

@section('title', $course->title)

@section('content')
    <div class="bg-light min-vh-100">
        <!-- Toast Container -->
        <div id="courseCompleteAlert" class="toast-container position-fixed top-4 end-4" style="z-index: 1050;">
            <div class="text-white border-0 toast align-items-center bg-success fade hide" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        🎉 Course section completed successfully!
                    </div>
                    <button type="button" class="m-auto btn-close btn-close-white me-2" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Header -->
        <div class="sticky-top d-lg-none">
            <div class="px-4 py-3 bg-white shadow-sm d-flex justify-content-between align-items-center">
                <button class="btn btn-primary btn-sm d-flex align-items-center" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" id="offcanvasToggleBtn">
                    <i class="fa-light fa-book-open-lines me-2"></i>
                    <span>Course Content</span>
                </button>
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-home me-1"></i> Dashboard
                </a>
            </div>
        </div>

        @if (!Agent::isMobile())
            <!-- Sidebar for desktop -->
            <aside class="lesson-sidebar-fixed d-none d-lg-block">
                @include('frontend.dashboard.pages.course-learn.partials.course_sidebar')
            </aside>
        @else
            <!-- Offcanvas Sidebar for mobile -->
            <div class="offcanvas offcanvas-start offcanvas-fullscreen" tabindex="-1" id="sidebarOffcanvas"
                aria-labelledby="sidebarOffcanvasLabel">
                <div class="p-0 offcanvas-body position-relative">
                    <button type="button" class="top-0 m-3 btn btn-sm btn-light position-absolute end-0 z-3"
                        data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-light fa-xmark"></i></button>
                    @include('frontend.dashboard.pages.course-learn.partials.course_sidebar')
                </div>
            </div>
        @endif

        <!-- Main content -->
        <main class="lesson-content">
            <div class="min-vh-100">
                @if ($lesson)
                    <!-- Lesson Header -->
                    <div class="px-4 py-3 mb-4 bg-white rounded shadow-sm border-bottom">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-8">
                                <nav aria-label="breadcrumb">
                                    <ol class="mb-2 breadcrumb">
                                        <li class="breadcrumb-item active">Chapter: {{ $lesson->chapter->title }}</li>
                                    </ol>
                                </nav>
                                <h5 class="mb-0 fw-bold text-dark">{{ $lesson->title }}</h5>
                            </div>
                            <div class="mt-3 col-12 col-md-4 mt-md-0">
                                <div class="gap-3 d-flex justify-content-md-end align-items-center">
                                    @php
                                        $isCompleted =
                                            isset($completedLessons) && in_array($lesson->id, $completedLessons);
                                    @endphp

                                    @if (!$isCompleted)
                                        <button id="markCompleteBtn" class="btn btn-primary d-flex align-items-center"
                                            data-course-id="{{ $course->id }}" data-lesson-id="{{ encrypt($lesson->id) }}"
                                            data-complete-url="{{ route('student.my.courses.lesson.complete', ['course' => $course->id, 'lesson' => encrypt($lesson->id)]) }}">
                                            <i class="fas fa-check me-2"></i>
                                            <span>Complete & Continue</span>
                                        </button>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success-subtle text-success d-flex align-items-center">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Completed
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content Section -->
                    <div class="row">
                        <!-- Main Lesson Content Column -->
                        <div class="mb-4 col-lg-12">
                            <div class="border-0 shadow-sm card">
                                <div class="p-4 card-body">
                                    <!-- Lesson Progress -->
                                    <div class="p-3 mb-4 d-flex align-items-center bg-light rounded-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-white rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-book-reader"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-1">Your Progress</h6>
                                                <p class="mb-0 text-muted small">
                                                    @if (isset($progressPercent) && isset($completedLessons))
                                                        {{ $progressPercent }}% Complete • {{ count($completedLessons) }} of
                                                        {{ $course->chapters->sum('lessons_count') }} lessons
                                                    @else
                                                        0% Complete • 0 of {{ $course->chapters->sum('lessons_count') }}
                                                        lessons
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lesson Description -->
                                    <div class="prose-sm prose lesson-description lh-lg">
                                        {!! $lesson->description ?? '<p class="text-muted">No description available for this lesson.</p>' !!}
                                    </div>
                                    @php
                                        $existingAttempt = $course->examAttemptFor(auth()->id());
                                    @endphp

                                    {{-- inside the main lesson card body, after progress/description --}}
                                    @if (isset($progressPercent) && $progressPercent == 100)
                                        @php
                                            $attemptsLast24h = $course
                                                ->examAttempts()
                                                ->where('user_id', auth()->id())
                                                ->where('created_at', '>=', now()->subDay())
                                                ->count();
                                            $latestAttempt = $course->examAttemptFor(auth()->id());
                                        @endphp

                                        <div
                                            class="p-3 mt-4 bg-white border rounded d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>Final Assessment</h6>
                                                <small class="text-muted">Passing score: 80%</small>
                                            </div>
                                            @if (!$latestAttempt || (!$latestAttempt->passed && $attemptsLast24h < 2))
                                                <button id="startExamBtn" class="btn btn-primary"
                                                    data-url="{{ route('student.courses.exam.show', ['course' => $course->id]) }}">
                                                    <i class="fas fa-pen-to-square me-1"></i> Start Exam
                                                </button>
                                                <!-- Instructions Modal -->
<div class="modal fade" id="instructionsModal" tabindex="-1" aria-labelledby="instructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="text-white modal-header bg-primary">
                <h5 class="modal-title" id="instructionsModalLabel"><i class="fas fa-info-circle me-1"></i> Exam Instructions</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">You have <strong>30 minutes</strong> to complete this exam.</li>
                    <li class="list-group-item">Passing score is <strong>80 %</strong>.</li>
                    <li class="list-group-item">You can attempt this exam maximum <strong>2 times per 24 hours</strong>.</li>
                    <li class="list-group-item">Do not refresh or leave the page during the exam. Doing so will mark your attempt as failed.</li>
                    <li class="list-group-item">Answer all questions carefully. Once submitted, answers cannot be changed.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmStartExam" type="button" class="btn btn-primary">Start Exam</button>
            </div>
        </div>
    </div>
</div>
                                            @else
                                                @if ($latestAttempt->passed)
                                                    <button id="downloadCertificate" class="btn btn-primary"
                                                        data-url="{{ route('student.courses.certificate.download', $course->id) }}">
                                                        <i class="fa-light fa-file-certificate"></i> Download
                                                        Certificate
                                                    </button>
                                                    @push('scripts')
                                                        <script src="{{ asset('assets/frontend/jspdf.umd.min.js') }}"></script>
                                                        <script src="{{ asset('assets/frontend/html2canvas.min.js') }}"></script>
                                                        <script src="{{ asset('assets/frontend/certificate.js') }}"></script>
                                                    @endpush
                                                @endif
                                                <span
                                                    class="badge {{ $latestAttempt->passed ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $latestAttempt->passed ? 'Passed' : 'Attempted' }} —
                                                    {{ $latestAttempt->score }}%
                                                </span>
                                            @endif
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row justify-content-center">
                        <div class="text-center col-md-8">
                            <div class="py-5 my-5">
                                <i class="mb-4 fas fa-book-reader fa-3x text-primary"></i>
                                <h3 class="mb-3">Welcome to Your Course</h3>
                                <p class="lead text-muted">Please select a lesson from the sidebar to start learning.</p>
                                <p class="mb-4 text-muted">Your progress will be automatically saved as you complete each
                                    lesson.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>

    {{-- AJAX Script for Mark Complete --}}
    <script>
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

                    fetch("{{ route('student.my.courses.lesson.complete', ['course' => $course->id, 'lesson' => encrypt($lesson->id)]) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                                    transition.className =
                                        'position-fixed top-0 start-0 w-100 h-100 bg-white';
                                    transition.style.zIndex = '9999';
                                    transition.style.opacity = '0';
                                    transition.style.transition = 'opacity 0.3s ease-in-out';
                                    document.body.appendChild(transition);

                                    setTimeout(() => {
                                        transition.style.opacity = '1';
                                        setTimeout(() => {
                                            window.location.href = data
                                                .nextLessonUrl;
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
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
