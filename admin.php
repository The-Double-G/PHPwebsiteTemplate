<?php


// Define the correct password
$correctPassword = 'adminIsGod123';

// Maximum number of allowed failed attempts
$maxFailedAttempts = 3;

// Lockout time in seconds after reaching maximum failed attempts
$lockoutTime = 60; // 1 minute in this example

// Initialize error message
$errorMsg = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start or resume the session
    session_start();

    // Check if the user is currently locked out
    if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
        $errorMsg = 'Account locked. Please try again later.';
    } else {
        // Get the entered password from the form
        $enteredPassword = $_POST['password'];

        // Check if the entered password is correct
        if ($enteredPassword === $correctPassword) {
            // Reset failed attempts on successful login
            unset($_SESSION['failed_attempts']);

            // Redirect to a specified page
            $_SESSION['authenticated'] = true;
            header('Location: signup.php');
            exit();
        } else {
            // Increment failed attempts
            $_SESSION['failed_attempts'] = isset($_SESSION['failed_attempts']) ? ($_SESSION['failed_attempts'] + 1) : 1;

            // Check if maximum failed attempts reached
            if ($_SESSION['failed_attempts'] >= $maxFailedAttempts) {
                // Set lockout time
                $_SESSION['lockout_time'] = time() + $lockoutTime;

                $errorMsg = 'Account locked. Please try again later.';
            } else {
                // Incorrect password, set an error message
                $errorMsg = 'Incorrect password. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Form</title>
</head>
<body>

    <form method="post" action="">
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Submit</button>
    </form>

    <?php echo $errorMsg; ?>
   <a href="login.php">Return To Log In!</a>

</body>
</html>
