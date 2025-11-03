@extends('frontend.dashboard.layouts.master')

@section('title', $course->title . ' - Final Exam')

@section('content')
    <style>
        :root {
            --primary-color: #5624d0;
            --primary-hover: #4c1fb8;
            --secondary-color: #1c1d1f;
            --text-color: #2d2f31;
            --light-gray: #f7f9fa;
            --border-color: #d1d7dc;
            --success-color: #73aa24;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
        }

        /* Header */
        .lms-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .course-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .course-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Main Container */
        .lms-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .test-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2rem;
            align-items: start;
        }

        /* Sidebar */
        .test-sidebar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .timer-widget {
            text-align: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
            margin-bottom: 1.5rem;
        }

        .timer-display {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
            font-variant-numeric: tabular-nums;
        }

        .progress-section h6 {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .custom-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
            transition: width 0.3s ease;
        }

        .question-navigator {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .question-nav-item {
            width: 40px;
            height: 40px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
            text-decoration: none;
            color: var(--text-color);
        }

        .question-nav-item:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            text-decoration: none;
        }

        .question-nav-item.answered {
            background: var(--success-color);
            border-color: var(--success-color);
            color: white;
        }

        .question-nav-item.current {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Main Content */
        .test-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .test-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, #f8f9ff 0%, #f1f3ff 100%);
            border-radius: 12px;
        }

        .test-title {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-weight: 700;
            font-size: 1.75rem;
        }

        .test-meta {
            display: flex;
            gap: 2rem;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .test-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Question Card */
        .question-card {
            padding: 2rem;
            border-bottom: 1px solid #f1f1f1;
        }

        .question-card:last-child {
            border-bottom: none;
        }

        .question-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .question-number {
            min-width: 32px;
            height: 32px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .question-text {
            font-size: 1.125rem;
            font-weight: 500;
            color: var(--secondary-color);
            line-height: 1.5;
        }

        /* Options */
        .options-grid {
            display: grid;
            gap: 0.75rem;
        }

        .option-item {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
            position: relative;
        }

        .option-item:hover {
            border-color: var(--primary-color);
            background-color: #f8f9ff;
        }

        .option-item.selected {
            border-color: var(--primary-color);
            background-color: #f8f9ff;
        }

        .option-item.selected::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        .option-item.selected::before {
            content: '✓';
            position: absolute;
            right: 1.35rem;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            z-index: 1;
        }

        .option-item.correct {
            border-color: var(--success-color);
            background-color: #f8fff8;
        }

        .option-item.incorrect {
            border-color: var(--danger-color);
            background-color: #fff8f8;
        }

        .option-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .option-letter {
            min-width: 28px;
            height: 28px;
            border: 1px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            background: white;
        }

        .option-item.selected .option-letter {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .option-text {
            font-size: 1rem;
            color: var(--text-color);
        }

        /* Navigation */
        .test-navigation {
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            background: #fafbfc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-lms {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(86, 36, 208, 0.25);
        }

        .btn-outline {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Results */
        .results-container {
            padding: 3rem 2rem;
            text-align: center;
        }

        .results-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
        }

        .results-icon.excellent {
            background: linear-gradient(135deg, #73aa24, #5d8f1f);
        }

        .results-icon.good {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .results-icon.average {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .results-icon.poor {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .results-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .results-score {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .results-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Instructions Modal */
        .instructions-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .instructions-modal {
            background: white;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, #f8f9ff 0%, #f1f3ff 100%);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .test-layout {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .test-sidebar {
                order: -1;
                position: relative;
                top: 0;
            }

            .question-navigator {
                grid-template-columns: repeat(10, 1fr);
            }

            .question-nav-item {
                width: 32px;
                height: 32px;
                font-size: 0.85rem;
            }

            .lms-container {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .test-header {
                padding: 1.5rem;
            }

            .question-card {
                padding: 1.5rem;
            }

            .test-navigation {
                padding: 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }

            .timer-display {
                font-size: 2rem;
            }

            .results-stats {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
    <div class="bg-light min-vh-100">
        @php
            $latestAttempt = $course->examAttemptFor(auth()->id());
            $attemptsLast24h = $course
                ->examAttempts()
                ->where('user_id', auth()->id())
                ->where('created_at', '>=', now()->subDay())
                ->count();
            $canAttempt = !$latestAttempt || (!$latestAttempt->passed && $attemptsLast24h < 2);
        @endphp

        <div class="container py-4">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $course->title }} — Final Assessment</h4>
                <a href="{{ route('student.my.courses.show', ['course' => $course->id]) }}"
                    class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Course</a>
            </div>

            @if (!$canAttempt)
                <div class="p-4 text-center shadow-sm card">
                    <h5 class="mb-2">You have reached the maximum attempts for this exam in the last 24 hours.</h5>
                    @if ($latestAttempt && $latestAttempt->passed)
                        <p class="mb-3 text-success">Score: <strong>{{ $latestAttempt->score }}%</strong> • Passed ✅</p>
                        <button class="btn btn-success" id="downloadCertificate"
                            data-url="{{ route('student.courses.certificate.download', $course->id) }}">
                            <i class="fas fa-file-download me-1"></i> Download Certificate
                        </button>
                    @else
                        <p class="mb-3 text-warning">Score: <strong>{{ $latestAttempt->score ?? 'N/A' }}%</strong> • Not
                            Passed ❌</p>
                    @endif
                </div>
            @else
                <div id="examInterface">
                    {{-- Your existing exam HTML layout goes here --}}
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="overflow-hidden bg-white shadow-sm test-content rounded-3">
                                <div class="p-4 test-header border-bottom">
                                    <h5 class="mb-1">Final Assessment</h5>
                                    <div class="text-muted small">
                                        <i class="fas fa-clock me-1"></i> {{ $timeLimitMin }} minutes •
                                        <i class="fas fa-percentage ms-3 me-1"></i> Passing: {{ $passingScore }}%
                                    </div>
                                </div>
                                <div id="questionsContainer"></div>
                                <div
                                    class="p-3 test-navigation d-flex justify-content-between align-items-center border-top bg-light">
                                    <button id="prevBtn" class="btn btn-outline-primary" style="display:none"><i
                                            class="fas fa-chevron-left me-1"></i> Previous</button>
                                    <div></div>
                                    <button id="nextBtn" class="btn btn-primary">Next <i
                                            class="fas fa-chevron-right ms-1"></i></button>
                                    <button id="submitBtn" class="btn btn-primary" style="display:none"><i
                                            class="fas fa-paper-plane me-1"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="p-3 bg-white shadow-sm test-sidebar rounded-3">
                                <div class="p-3 mb-3 text-center text-white timer-widget rounded-3"
                                    style="background: linear-gradient(to top,#fff,#fbfbff,#f4f8ff,#ecf6fe,#e3f4fc);">
                                    <div><i class="fas fa-clock"></i></div>
                                    <div id="timerDisplay" class="timer-display"
                                        style="font-size:2rem;font-weight:700">--:--</div>
                                    <small>Time Remaining</small>
                                </div>
                                <div class="progress-section">
                                    <h6>Progress</h6>
                                    <div class="mb-1 custom-progress">
                                        <div id="progressBar" class="custom-progress-bar" style="width:0%"></div>
                                    </div>
                                    <small class="text-muted"><span id="progressText">0 of 0</span> questions
                                        completed</small>
                                    <div id="questionNavigator" class="mt-3 question-navigator"></div>
                                </div>
                            </div>
                            <div class="mt-3 alert alert-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Max 2 attempts in 24 hours.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if ($canAttempt)
            <script>
                let mcqs = [];
                let current = 0;
                let userAnswers = {};
                let timeRemaining = 0;
                let timerInterval;
                let isAutoSubmit = false;
                const maxAttempts = 2;
                const attemptsLast24h = {{ $attemptsLast24h }};
                const canAttempt = {{ $canAttempt ? 'true' : 'false' }};

                document.addEventListener('DOMContentLoaded', async () => {
                    if (!canAttempt) {
                        alert("🚫 You have reached the maximum attempts in the last 24 hours.");
                        return;
                    }
                    await loadQuestions();
                    renderQuestion(0);
                    initNavButtons();
                });

                async function loadQuestions() {
                    const res = await fetch("{{ route('student.courses.exam.questions', ['course' => $course->id]) }}");
                    if (!res.ok) {
                        alert('Failed to load questions');
                        return;
                    }
                    const data = await res.json();
                    mcqs = data.questions || [];
                    timeRemaining = data.timeLimit || {{ $timeLimitMin * 60 }};
                    window.examToken = data.exam_token;

                    document.getElementById('progressText').textContent = `0 of ${mcqs.length}`;
                    buildNavigator();
                    startTimer();
                }

                function buildNavigator() {
                    const nav = document.getElementById('questionNavigator');
                    nav.innerHTML = '';
                    mcqs.forEach((q, i) => {
                        const d = document.createElement('div');
                        d.className = 'question-nav-item';
                        d.textContent = i + 1;
                        d.onclick = () => {
                            current = i;
                            renderQuestion(i);
                            updateNavigator();
                        };
                        nav.appendChild(d);
                    });
                    updateNavigator();
                }

                function updateNavigator() {
                    document.querySelectorAll('.question-nav-item').forEach((el, i) => {
                        el.style.background = '#fff';
                        el.style.color = '#2d2f31';
                        el.style.borderColor = '#d1d7dc';
                        if (i === current) {
                            el.style.background = '#5624d0';
                            el.style.color = '#fff';
                            el.style.borderColor = '#5624d0';
                        } else if (userAnswers[mcqs[i]?.id]) {
                            el.style.background = '#73aa24';
                            el.style.color = '#fff';
                            el.style.borderColor = '#73aa24';
                        }
                    });
                }

                function renderQuestion(index) {
                    const c = document.getElementById('questionsContainer');
                    const q = mcqs[index];
                    if (!q) {
                        c.innerHTML = '<div class="p-4">No questions found.</div>';
                        return;
                    }
                    const opts = q.options || {};
                    c.innerHTML = `
        <div class="p-4 question-card">
            <div class="gap-2 mb-3 d-flex align-items-start">
                <div class="text-white question-number bg-primary rounded-circle d-flex align-items-center justify-content-center">${index+1}</div>
                <div class="question-text fw-semibold">${q.question}</div>
            </div>
            <div class="options-grid d-grid" style="gap:.75rem;">
                ${Object.entries(opts).map(([k,v]) => `
                                            <div class="option-item border rounded p-3 ${userAnswers[q.id]===k?'selected':''}" data-q="${q.id}" data-opt="${k}">
                                                <div class="gap-2 d-flex align-items-center">
                                                    <div class="border option-letter rounded-circle d-flex align-items-center justify-content-center">${k}</div>
                                                    <div class="option-text">${v}</div>
                                                </div>
                                            </div>
                                        `).join('')}
            </div>
        </div>
    `;
                    document.querySelectorAll('.option-item').forEach(el => {
                        el.addEventListener('click', () => {
                            if (!canAttempt) {
                                alert("🚫 Max attempts reached!");
                                return;
                            }
                            const id = el.getAttribute('data-q');
                            const opt = el.getAttribute('data-opt');
                            userAnswers[id] = opt;
                            document.querySelectorAll('.option-item').forEach(i => i.classList.remove('selected'));
                            el.classList.add('selected');
                            updateProgress();
                            updateNavigator();
                        });
                    });
                    updateButtons();
                }

                function updateButtons() {
                    document.getElementById('prevBtn').style.display = current > 0 ? 'inline-block' : 'none';
                    const last = current === mcqs.length - 1;
                    document.getElementById('nextBtn').style.display = last ? 'none' : 'inline-block';
                    document.getElementById('submitBtn').style.display = last ? 'inline-block' : 'none';
                }

                function initNavButtons() {
                    document.getElementById('prevBtn').onclick = () => {
                        if (current > 0) {
                            current--;
                            renderQuestion(current);
                            updateNavigator();
                        }
                    };
                    document.getElementById('nextBtn').onclick = () => {
                        if (current < mcqs.length - 1) {
                            current++;
                            renderQuestion(current);
                            updateNavigator();
                        }
                    };
                    document.getElementById('submitBtn').onclick = () => {
                        isAutoSubmit = false;
                        submitExam();
                    };
                }

                function updateProgress() {
                    const answered = Object.keys(userAnswers).length;
                    const pct = mcqs.length ? (answered / mcqs.length) * 100 : 0;
                    document.getElementById('progressBar').style.width = pct + '%';
                    document.getElementById('progressText').textContent = `${answered} of ${mcqs.length}`;
                }

                function startTimer() {
                    updateTimerDisplay();
                    timerInterval = setInterval(() => {
                        timeRemaining--;
                        updateTimerDisplay();
                        if (timeRemaining <= 0) {
                            clearInterval(timerInterval);
                            autoSubmit();
                        }
                    }, 1000);
                }

                function updateTimerDisplay() {
                    const m = Math.floor(timeRemaining / 60);
                    const s = timeRemaining % 60;
                    const display = `${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
                    const el = document.getElementById('timerDisplay');
                    el.textContent = display;
                    if (timeRemaining <= 300) el.style.color = '#e74c3c';
                    else if (timeRemaining <= 600) el.style.color = '#f39c12';
                }

                function autoSubmit() {
                    isAutoSubmit = true;
                    submitExam();
                }

                async function submitExam() {
                    if (!canAttempt) {
                        alert("🚫 Max attempts reached!");
                        return;
                    }
                    if (!isAutoSubmit && Object.keys(userAnswers).length === 0 && !confirm(
                            'You have not answered any questions. Submit anyway?')) return;

                    const examToken = window.examToken;
                    const res = await fetch("{{ route('student.courses.exam.submit', ['course' => $course->id]) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            answers: userAnswers,
                            exam_token: examToken
                        })
                    });

                    if (!res.ok) {
                        const err = await res.json();
                        alert('Submission failed: ' + JSON.stringify(err));
                        return;
                    }
                    const data = await res.json();
                    showResults(data);
                }

                function showResults(data) {
                    clearInterval(timerInterval);
                    const {
                        score,
                        correct,
                        total,
                        passed,
                        certificateUrl
                    } = data;
                    const container = document.querySelector('.test-content');
                    container.innerHTML = `
        <div class="p-5 text-center results-container">
            <div class="results-icon mx-auto mb-3 ${passed?'excellent':'poor'} rounded-circle d-flex align-items-center justify-content-center" style="width:100px;height:100px;color:#fff;background:${passed?'linear-gradient(135deg,#73aa24,#5d8f1f)':'linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%)'}">
                <i class="${passed?'fas fa-trophy':'fas fa-book'}" style="font-size:2rem"></i>
            </div>
            <h2 class="mb-1 results-title fw-bold">${passed?'Congratulations!':'Keep Learning!'}</h2>
            <div class="mb-4 results-score text-muted">You scored ${correct} / ${total} — <strong>${score}%</strong></div>
            <div class="flex-wrap gap-2 d-flex justify-content-center">
                <a class="btn btn-outline-primary" href="{{ route('student.my.courses.show', ['course' => $course->id]) }}">
                    <i class="fas fa-arrow-left me-1"></i> Back to Course
                </a>
                ${passed?`<button class="btn btn-success" id="downloadCertificate" data-url="{{ route('student.courses.certificate.download', $course->id) }}"><i class="fas fa-file-download me-1"></i> Download Certificate</button>`:''}
            </div>
            ${passed?`<div class="mt-4 alert alert-success"><i class="fas fa-certificate me-1"></i>You passed the assessment and earned a certificate.</div>`:
            `<div class="mt-4 alert alert-warning"><i class="fas fa-circle-exclamation me-1"></i>Passing score is {{ $passingScore }}%. Review lessons and request a retake if enabled.</div>`}
        </div>
    `;
                }

                // Anti-Cheat
                document.addEventListener('contextmenu', e => e.preventDefault());
                document.addEventListener('copy', e => e.preventDefault());
                document.addEventListener('cut', e => e.preventDefault());
                document.addEventListener('paste', e => e.preventDefault());
                document.addEventListener('selectstart', e => e.preventDefault());
                document.addEventListener('keydown', e => {
                    if ((e.ctrlKey && ['c', 'v', 'x', 's', 'u', 'p'].includes(e.key.toLowerCase())) || e.key === 'F12' || (e
                            .ctrlKey && e.shiftKey && ['i', 'j'].includes(e.key.toLowerCase()))) {
                        e.preventDefault();
                        alert("🚫 Cheating attempt blocked!");
                    }
                });
                window.addEventListener('beforeunload', e => {
                    e.preventDefault();
                    e.returnValue = "⚠️ You are leaving the exam! This may mark your attempt as failed.";
                });
            </script>
        @endif

    </div>


    @push('scripts')
        <script src="{{ asset('assets/frontend/jspdf.umd.min.js') }}"></script>
        <script src="{{ asset('assets/frontend/html2canvas.min.js') }}"></script>
        <script src="{{ asset('assets/frontend/certificate.js') }}"></script>
    @endpush
@endsection
