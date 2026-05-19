
@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <h3 class="font-weight-bolder text-info text-gradient text-center">NRRIS Login</h3>
                    <form role="form" method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" required>
                        </div>
                        <div class="mb-3">
                            {{-- <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" required> --}}
                            <div class="input-group">
                                <input type="password" name="password" id="password-field" class="form-control" placeholder="Password" required>
                                <button class="btn btn-outline-secondary mb-0" type="button" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <script>
                            function togglePassword() {
                                const passwordField = document.getElementById('password-field');
                                const icon = document.getElementById('toggleIcon');
                                if (passwordField.type === "password") {
                                    passwordField.type = "text";
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = "password";
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            }
                        </script>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection