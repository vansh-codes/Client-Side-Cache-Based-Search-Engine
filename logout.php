<?php
session_start();
session_unset();  // Unset all session variables
session_destroy();

// Optionally, clear the session cookie to ensure it is destroyed
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
// You can redirect after clearing cache to ensure the logout process is smooth
/* header('Content-Type: application/json'); 
echo json_encode(['status' => 'success']); */
?>

<script>
    // This function clears cache and unregisters the service worker
    function clearCache() {
        sessionStorage.removeItem('searchCache');
        if (navigator.serviceWorker) {
            navigator.serviceWorker.ready.then((registration) => {
                registration.unregister();
            });
        }
    }

    // Call the function to clear cache on logout
    clearCache();
</script>

<?php
header('Location: templates/auth/login.php');
exit();