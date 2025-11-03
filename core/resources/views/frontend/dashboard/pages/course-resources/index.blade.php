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
                    <!-- Course Resource Table -->
                    <div class="mb-5">
                        <div class="card lms-card">
                            <div class="lms-card-header">
                                Course Resources
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




                <section class="course-section">
                    <div class="row">
                        @forelse($enrollments as $enrollment)
                            @php
                                $course = $enrollment->course;
                                $completedLessons = $enrollment->completed_lessons ?? 0;
                                $totalLessons = $course->lessons->count();
                                $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
                            @endphp
                            <div class="mb-4 col-12 col-md-6 col-lg-4">
                                <div class="overflow-hidden shadow-sm course-card h-100 rounded-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $course->thumbnail ?? 'img/course.jpg') }}"
                                            alt="{{ $course->title }}" class="w-100 object-fit-cover" style="height: 200px;"
                                            loading="lazy">
                                        <span
                                            class="position-absolute top-0 end-0 m-2 badge bg-{{ $enrollment->status === 'active' ? 'success' : 'warning' }}">
                                            {{ $enrollment->status === 'active' ? 'চলমান' : 'স্থগিত' }}
                                        </span>
                                    </div>
                                    <div class="p-3 card-body">
                                        <div class="mb-2 d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light text-dark">
                                                <i class="fa-light fa-folder me-1"></i>
                                                {{ $course->category->name ?? 'ক্যাটাগরি নেই' }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fa-light fa-clock me-1"></i>
                                                {{ $course->duration ?? 'N/A' }}
                                            </small>
                                        </div>

                                        <h5 class="mb-3 course-name line-clamp">{{ $course->title }}</h5>

                                        <div class="mb-3 course-stats">
                                            <div class="mb-2 d-flex justify-content-between text-muted">
                                                <small>
                                                    <i class="fa-light fa-book-open me-1"></i>
                                                    Lesson: {{ $totalLessons }}
                                                </small>
                                                <small>
                                                    <i class="fa-light fa-layer-group me-1"></i>
                                                    Module: {{ $course->chapters->count() }}
                                                </small>
                                            </div>

                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $progress }}%"
                                                    aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                <span class="text-success">{{ number_format($progress, 1) }}%</span>
                                                Completed
                                            </small>
                                        </div>

                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#courseFilesModal-{{ $course->id }}">
                                            View Files
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="courseFilesModal-{{ $course->id }}" tabindex="-1"
                                aria-labelledby="courseFilesModalLabel-{{ $course->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="courseFilesModalLabel-{{ $course->id }}">Files
                                                for
                                                {{ $course->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>File Name</th>
                                                        <th>Type</th>
                                                        <th>Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($course->course_media as $key => $media)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $media->name }}</td>
                                                            <td>{{ $media->mime_type }}</td>
                                                            <td>
                                                                <a href="{{ $media->file_path }}"
                                                                    class="btn btn-sm btn-success" download>
                                                                    Download
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">No files
                                                                available
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <a href="{{ route('student.my.resources.download', $course->id) }}"
                                                class="btn btn-primary">
                                                Download All as ZIP
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="col-12">
                                <div class="py-5 text-center">
                                    <i class="mb-3 fa-light fa-books fa-3x text-muted"></i>
                                    <h5 class="text-muted">You haven't enrolled in any courses yet</h5>
                                    <a href="{{ route('student.my.courses.index') }}" class="mt-3 btn btn-primary">
                                        <i class="fa-light fa-compass me-1"></i>
                                        Browse Courses
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>


            </div>
        </div>
    </div>
@endsection
