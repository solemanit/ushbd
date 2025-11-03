<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="forgotPasswordForm" class="row g-1" action="{{ route('password.email') }}">
                @csrf
                <div class="border-0 modal-header d-flex justify-content-between align-items-center" style="padding-top: 25px;">
                    <h3 class="m-0 text-center text-secondary fw-bold flex-grow-1">
                        Reset <span class="text-primary">Password</span>
                    </h3>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="padding: 15px 20px !important;">
                    <p class="text-muted">Forgot your password? A reset link will be sent to your email.</p>
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" id="resetEmail"
                            placeholder="Enter your email" autofocus>
                        <label for="resetEmail">Enter your email</label>
                        <div class="mt-2 alert alert-danger alert-sm d-none" id="resetEmailError"></div>
                        <div class="mt-2 alert alert-success alert-sm d-none" id="resetSuccessMsg"></div>
                    </div>
                    <style>
                        .alert-sm {
                            padding: 0.25rem 0.5rem;
                            font-size: 0.875rem;
                            border-radius: 0.2rem;
                        }
                    </style>
                </div>

                <div class="pt-0 border-0 modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
