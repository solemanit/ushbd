@extends('frontend.dashboard.layouts.master')

@section('title', 'UpSkill Academia')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        @include('frontend.dashboard.layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="px-4 py-4 dash-course col-md-12 col-sm-12 col-xl-10">
            <!-- Welcome Section -->
            <div class="p-4 mb-4 text-white welcome-section bg-primary rounded-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">Welcome, {{ auth()->user()->name }}!</h4>
                        <p class="mb-0">Continue your learning journey. What will you learn today?</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('home') }}" class="btn btn-light">
                            <i class="fa-light fa-compass me-2"></i>Browse New Courses
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="mb-4 row">
                <div class="mb-3 col-sm-6 col-md-3">
                    <div class="border-0 shadow-sm card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-3 rounded-circle bg-primary bg-opacity-10">
                                    <i class="text-white fa-light fa-book fa-lg"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Total Courses</h6>
                                    <h4 class="mb-0">{{ count($enrollments) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-sm-6 col-md-3">
                    <div class="border-0 shadow-sm card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-3 rounded-circle bg-success bg-opacity-10">
                                    <i class="fa-light fa-badge-check fa-lg text-success"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Completed Courses</h6>
                                    <h4 class="mb-0">{{ $enrollments->where('status', 'completed')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-sm-6 col-md-3">
                    <div class="border-0 shadow-sm card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-3 rounded-circle bg-warning bg-opacity-10">
                                    <i class="fa-light fa-clock fa-lg text-warning"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Ongoing Courses</h6>
                                    <h4 class="mb-0">{{ $enrollments->where('status', 'active')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-sm-6 col-md-3">
                    <div class="border-0 shadow-sm card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-3 rounded-circle bg-info bg-opacity-10">
                                    <i class="fa-light fa-file-certificate fa-lg text-info"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Certificates</h6>
                                    <h4 class="mb-0">{{ $enrollments->where('certificate_issued', true)->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 course-title">Recent Courses</h5>
                <a href="{{ route('student.my.courses.index') }}" class="btn btn-outline-primary btn-sm">
                    View All <i class="fa-light fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row">
                @forelse($enrollments as $enrollment)
                    @php
                        $course = $enrollment->course;
                        $progress = $enrollment->progressPercent ?? 0;
                    @endphp
                    <div class="mb-4 col-12 col-md-6 col-lg-4">
                        <div class="border-0 shadow-sm course-card h-100 card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$course->thumbnail ?? 'img/course.jpg') }}"
                                     class="card-img-top"
                                     alt="{{ $course->title }}"
                                     style="height: 200px; object-fit: cover;">
                                <div class="top-0 m-2 position-absolute end-0">
                                    <span class="badge bg-{{ $progress == 100 ? 'success' : 'primary' }}">
                                        {{ $progress == 100 ? 'Completed' : 'In Progress' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-2 d-flex justify-content-between align-items-start">
                                    <span class="badge bg-light text-dark">
                                        <i class="fa-light fa-folder me-1"></i>
                                        {{ $course->category->name ?? 'No Category' }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fa-light fa-clock me-1"></i>
                                        {{ $course->duration ?? 'N/A' }}
                                    </small>
                                </div>

                                <h5 class="mb-3 course-name line-clamp">{{ $course->title }}</h5>

                                <div class="mb-3">
                                    <div class="mb-2 d-flex justify-content-between text-muted">
                                        <small>
                                            <i class="fa-light fa-book-open me-1"></i>
                                            Lessons: {{ $course->lessons->count() }}
                                        </small>
                                        <small>
                                            <i class="fa-light fa-layer-group me-1"></i>
                                            Modules: {{ $course->chapters->count() }}
                                        </small>
                                    </div>

                                    <div class="mb-2 progress" style="height: 6px;">
                                        <div class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: {{ $progress }}%"
                                            aria-valuenow="{{ $progress }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <span class="text-success">{{ $progress }}%</span> Completed
                                    </small>
                                </div>

                                <a href="{{ route('student.my.courses.show', $course->id) }}"
                                   class="btn btn-primary w-100">
                                    @if($progress == 0)
                                        <i class="fa-light fa-play me-1"></i>Start Learning
                                    @else
                                        <i class="fa-light fa-arrow-right me-1"></i>Resume Course
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="py-5 text-center">
                            <i class="mb-3 fa-light fa-books fa-3x text-muted"></i>
                            <h5 class="text-muted">You haven’t enrolled in any courses yet</h5>
                            <p class="mb-4 text-muted">Enroll in a course to start your learning journey</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fa-light fa-compass me-2"></i>Browse Courses
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
