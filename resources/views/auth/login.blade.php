<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaTrack - Credential Management System</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Left Side -->
            <div class="login-left">
                <img src="{{ asset('uploads/images/login_page/icon.JPG') }}" alt="Logo">
                <h2>Credential Management System</h2>
                <p>Securely Manage and Access Your Credentials!</p>
            </div>

            <!-- Right Side -->
            <div class="login-right">
                <h3>Login to NexaTrack</h3>
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <div>
                        <label for="login">Email or Username</label>
                        <input id="login" type="text" name="login" value="{{ old('login') }}"
                            placeholder="Enter your email or username" required autofocus>

                        @error('login')
                            <div style="color:#dc3545; font-size:0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Enter your password"
                            required>
                        @error('password')
                            <div style="color:#dc3545; font-size:0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="forgot-link" id="forgotPasswordLink">Forgot Password?</div>

                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="login-bottom">
        <div class="footer-left">
            <p>
                Need Help?
                <a href="#" id="callHelpdesk">📞 09643 111 222</a> |
                <a href="#" id="emailHelpdesk">📧 helpdesk@totalofftec.com</a>
            </p>
        </div>
        <div class="footer-right">
            <p>Designed & Developed by <a href="#" id="visitDeveloper">TOTALOFFTEC</a></p>
        </div>
    </div>


    <!-- SweetAlert & Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("forgotPasswordLink").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Forgot Password?",
                text: "We'll help you recover it.",
                icon: "info",
                confirmButtonText: "Go to Reset Page"
            }).then(() => {
                window.location.href = "{{ route('password.request') }}";
            });
        });

        document.getElementById("callHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Call Helpdesk",
                text: "Do you want to call 09643 111 222?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Call Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "tel:09643111222";
                }
            });
        });

        document.getElementById("emailHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Email Helpdesk",
                text: "Do you want to email us?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Email Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "mailto:helpdesk@totalofftec.com";
                }
            });
        });

        document.getElementById("visitDeveloper").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Visit TOTALOFFTEC?",
                text: "You are about to leave the page.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Visit"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("https://totalofftec.com", "_blank");
                }
            });
        });
    </script>
</body>

</html>
