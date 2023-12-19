<!-- resources/views/clear-cookies.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Clear Cookies</title>
</head>
<body>
    <h1>Clearing Cookies...</h1>

    <script>  
        function deleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }

        // Remove the 'laravel_session' cookie
        deleteCookie('laravel_session');

        // Optionally, perform additional cleanup or actions here
        // For example, clear local storage or perform other tasks
        localStorage.clear();

        // Redirect to a different page or perform other post-logout actions
        window.location.href = '/login'; // Redirect to a logged-out page
    </script>
</body>
</html>
