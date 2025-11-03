@extends('frontend.dashboard.layouts.master')

@section('title', 'Course Reviews')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            @include('frontend.dashboard.layouts.partials.sidebar')

            <!-- Main Content -->
            <div class="px-4 py-4 dash-course col-md-12 col-sm-12 col-xl-10">
                <section class="course-section">
                    <!-- Course Review Table -->
                    <div class="mb-5">
                        <div class="card lms-card">
                            <div class="lms-card-header">
                                My Course Rating
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle table-hover lms-table">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Category</th>
                                            <th>Lessons</th>
                                            <th>Modules</th>
                                            <th>Review Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($enrollments as $enrollment)
                                            @php
                                                $course = $enrollment->course;
                                                $hasReview = $course->reviews->where('user_id', auth()->id())->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $course->title }}</td>
                                                <td>{{ $course->category->name ?? 'Uncategorized' }}</td>
                                                <td>{{ $course->lessons->count() }}</td>
                                                <td>{{ $course->chapters->count() }}</td>
                                                <td>
                                                    @if ($hasReview)
                                                        <span class="badge bg-success">Reviewed</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Not Reviewed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!$hasReview)
                                                        <button type="button"
                                                            class="btn btn-sm btn-primary open-review-modal"
                                                            data-course-id="{{ $course->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#reviewModal">
                                                            Write Review
                                                        </button>
                                                    @else
                                                        <span class="text-success fw-semibold">Done</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="py-4 text-center text-muted">
                                                    No courses enrolled yet 📭
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- End Course Review Table -->
                </section>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modalEl = document.getElementById('reviewModal');
            const form = document.getElementById('reviewForm');
            const courseIdInput = document.getElementById('modalCourseId');
            const result = document.getElementById('result');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            function displayValue() {
                const val = form.rating.value;
                result.innerText = val == -1 ? "Not chosen" : `You chose: ${val} out of 5.`;
            }

            // When a modal trigger button is clicked
            document.querySelectorAll('.open-review-modal').forEach(btn => {
                btn.addEventListener('click', () => {
                    courseIdInput.value = btn.getAttribute('data-course-id');
                    form.reset();
                    displayValue();
                });
            });

            // Update result on star change
            form.querySelectorAll('input[name="rating"]').forEach(star => {
                star.addEventListener('change', displayValue);
            });

            // Initial display
            displayValue();

            // AJAX form submit
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch("{{ route('student.my.review.submit') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("The review has been submitted successfully.");
                            const bootstrapModal = bootstrap.Modal.getInstance(modalEl);
                            bootstrapModal.hide();
                        } else {
                            alert("Something went wrong: " + (data.message || ''));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("There was a problem submitting the review.");
                    });
            });
        });
    </script>


@endsection
