<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="shadow-lg modal-content rounded-3">
            <h3 id="authTitle" class="mt-4 mb-2 text-center text-secondary fw-bold">
                <span class="text-primary">Log in</span> to your account
            </h3>
            <div class="pb-0 border-0 modal-header">
                <ul class="nav nav-tabs nav-fill w-100" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab"
                            data-bs-target="#loginTabPane" type="button" role="tab"
                            aria-controls="loginTabPane" aria-selected="true"
                            style="border-radius: 5px 0px 0 0;">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="signup-tab" data-bs-toggle="tab"
                            data-bs-target="#signupTabPane" type="button" role="tab"
                            aria-controls="signupTabPane" aria-selected="false"
                            style="border-radius: 0 5px 0 0;">Sign Up</button>
                    </li>
                </ul>
                <button type="button" class="top-0 m-3 btn-close position-absolute end-0" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="authTabContent">

                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="loginTabPane" role="tabpanel"
                        aria-labelledby="login-tab">
                        <form id="loginForm">
                            @csrf
                            <div class="mb-3 form-floating">
                                <input type="email" name="email" class="form-control" id="loginEmail"
                                    placeholder="Email">
                                <label for="loginEmail">Email</label>
                                <span id="loginEmailError" class="error-message text-danger d-none"></span>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="password" name="password" class="form-control" id="loginPassword"
                                    placeholder="Password">
                                <label for="loginPassword">Password</label>
                                <span id="loginPasswordError" class="error-message text-danger d-none"></span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        id="rememberMe">
                                    <label style="font-size: medium;" class="form-check-label"
                                        for="rememberMe">Remember me</label>
                                </div>
                                <div>
                                    <a style="font-size: medium;color: #2da0da !important" href="#"
                                        data-bs-toggle="modal" data-bs-target="#forgotPasswordModal"
                                        class="text-decoration-none small text-muted">Forgot your password?</a>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="loginSubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" id="loginSpinner" aria-hidden="true"></span>
                                <span class="btn-text">Continue</span>
                            </button>
                        </form>
                    </div>

                    <!-- Signup Tab -->
                    <div class="tab-pane fade" id="signupTabPane" role="tabpanel" aria-labelledby="signup-tab">
                        <form class="row g-1" id="registerForm">
                            @csrf
                            <div class="mb-3 form-floating">
                                <input type="text" name="name" class="form-control" id="signupName"
                                    placeholder="Name">
                                <label for="signupName">Name</label>
                                <div class="text-danger small" id="signupNameError"></div>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="email" name="email" class="form-control" id="signupEmail"
                                    placeholder="Email">
                                <label for="signupEmail">Email</label>
                                <div class="text-danger small" id="signupEmailError"></div>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="password" name="password" class="form-control" id="signupPassword"
                                    placeholder="Password">
                                <label for="signupPassword">Password</label>
                                <div class="text-danger small" id="signupPasswordError"></div>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="signupPasswordConfirm" placeholder="Confirm Password">
                                <label for="signupPasswordConfirm">Confirm Password</label>
                                <div class="text-danger small" id="signupPasswordConfirmError"></div>
                            </div>
                            <div class="mb-3 form-floating">
                                <select name="role" class="form-select" id="signupRole">
                                    <option value="">Select Role</option>
                                    <option value="student">Student</option>
                                    <option value="instructor">Instructor</option>
                                </select>
                                <label for="signupRole">Choose Role</label>
                                <div class="text-danger small" id="signupRoleError"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="registerSubmitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" id="registerSpinner" aria-hidden="true"></span>
                                <span class="btn-text">Continue</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
