<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login . PDT0</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login to PDT0</h2>
        <form id="loginForm" class="space-y-5">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span id="usernameError" class="text-red-500 text-xs hidden"></span>
            </div>
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <button type="button" id="togglePassword" class="absolute right-2 top-9 text-gray-500 focus:outline-none">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.442-4.362M6.634 6.634A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-4.293 5.255M3 3l18 18" />
                    </svg>
                </button>
                <span id="passwordError" class="text-red-500 text-xs hidden"></span>
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition duration-200">
                Login
            </button>
            <div id="loginError" class="text-red-500 text-sm text-center hidden"></div>
        </form>
        <div class="mt-6 flex flex-col items-center space-y-2">
            <a href="./signup.html" class="text-blue-600 hover:underline text-sm">Register</a>
            <a href="./forgot-password.html" class="text-blue-600 hover:underline text-sm">Forgot Password?</a>
        </div>
    </div>
    <script>
        // View/Hide password
        $('#togglePassword').on('click', function () {
            const passwordInput = $('#password');
            const eyeOpen = $('#eyeOpen');
            const eyeClosed = $('#eyeClosed');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                eyeOpen.addClass('hidden');
                eyeClosed.removeClass('hidden');
            } else {
                passwordInput.attr('type', 'password');
                eyeOpen.removeClass('hidden');
                eyeClosed.addClass('hidden');
            }
        });

        // Form validation and AJAX login
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            let valid = true;
            $('#usernameError, #passwordError, #loginError').addClass('hidden').text('');

            const username = $('#username').val().trim();
            const password = $('#password').val().trim();

            if (username === '') {
                $('#usernameError').text('Username is required.').removeClass('hidden');
                valid = false;
            }
            if (password === '') {
                $('#passwordError').text('Password is required.').removeClass('hidden');
                valid = false;
            }

            if (!valid) return;

            $.ajax({
                url: './action.php',
                type: 'POST',
                data: { username, password, action:'login' },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect || '/';
                    } else {
                        $('#loginError').text(response.message || 'Invalid credentials.').removeClass('hidden');
                    }
                },
                error: function (xhr) {
                    alert(JSON.stringify(xhr));
                    $('#loginError').text('Server error. Please try again later.').removeClass('hidden');
                }
            });
        });
    </script>
</body>
</html>