@extends('frontend.dashboard.layouts.master')

@section('title', 'My Courses')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            @include('frontend.dashboard.layouts.partials.sidebar')

            <!-- Main Content -->
            <div class="px-4 py-4 dash-course col-md-12 col-sm-12 col-xl-10">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 course-title">My Courses</h4>
                        <p class="mb-0 text-muted">You can view all your enrolled courses here</p>
                    </div>
                    <div class="course-stats">
                        <span class="badge bg-primary me-2">Total Courses: {{ count($enrollments) }}</span>
                        <span class="badge bg-success">Active Courses:
                            {{ $enrollments->where('status', 'active')->count() }}</span>
                    </div>
                </div>


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

                                        <a href="{{ route('student.my.courses.show', $course->id) }}"
                                            class="btn btn-primary w-100">
                                            <i class="fa-light fa-play me-1"></i>
                                            Start Learning
                                        </a>
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
