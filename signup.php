<?php
session_start(); // start the PHP session
if (!$_SESSION['authenticated'] || $_SESSION['authenticated'] !== true) {
    // Redirect to the login page if not authenticated
    header('Location: login.php');
    exit();
}
echo($_SESSION['authenticated']);
$_SESSION['authenticated'] = false;

if(isset($_POST['submit'])){ // check if the 'submit' button was clicked
    if(empty($_POST['username']) || empty($_POST['password'])) { // check if all fields were filled out
        $error_message = "Please fill out all the fields"; // error message if all fields not filled out
    } else {
        $username = $_POST['username']; // get the username entered by the user
        $password = $_POST['password']; // get the password entered by the user
        $data = $username . ":" . hash('sha512', $password) . "\n"; // hash the password using SHA-512

        $file_contents = file_get_contents('users.txt'); // open the file 'users.txt' for reading
        $lines = explode("\n", $file_contents); // split the contents of the file into an array using the newline character as a delimiter

        foreach ($lines as $line) {
            if (!empty($line)) {
                $line_parts = explode(":", $line);
                $existing_username = $line_parts[0];
                if ($existing_username === $username) {
                    $error_message = "Username already exists"; // error message if username is already signed up
                    break; // exit the loop
                
                }
            }
        }

        if (!isset($error_message)) {
            $ret = file_put_contents('users.txt', $data, FILE_APPEND | LOCK_EX); // append the new 'username' and hashed 'password' to the end of the 'users.txt' file

            if($ret === false) {
                die('There was an error writing this file'); // error message
            }
            else {
                echo "<div class='success-message'>$username has been registered successfully! Click the login button to route to the login form.</div>"; // success message
            }
        }
    }
}

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Signup - Template</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #1d492a;
		}

		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			max-width: 400px;
			margin: 50px auto;
		}

		h1 {
			text-align: center;
			margin-top: 0;
		}

		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
		}

		input[type="text"],
		input[type="password"] {
			display: block;
			width: 100%;
			padding: 10px;
			border: none;
			border-radius: 5px;
			margin-bottom: 20px;
			box-sizing: border-box;
			font-size: 16px;
			background-color: #f9f9f9;
			box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 10px 60px;
			border: none;
			border-radius: 5px;
			font-size: 16px;
			cursor: pointer;
			box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
		}

		input[type="submit"]:hover {
			background-color: #3e8e41;
		}

		.error {
			color: red;
			font-weight: bold;
			margin-top: 10px;
		}

/* Button styling for the login button routing to the login form */
.login-button {
  display: block;
  margin-top: 20px;
  padding: 12px 24px;
  border: none;
  border-radius: 4px;
  background-color: #4CAF50;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  text-transform: uppercase;
  transition: background-color 0.2s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-button:hover {
  background-color: #3e8e41;
}

.success-message {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
}



	</style>
</head>
<body>
<!-- The following code generates a signup form with input fields for a username and password. If there is an error message, it will be displayed in a paragraph with a class of "error". The form's method is "post" and its action is set to the current PHP script. There is also a link to a login page. -->
<html>
<body>
<h1 style="text-align: center; margin-top: 0; color: white;">Sign up</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" name="submit" value="Signup">
    <br>
    <a href="login.php">Return To Log In!</a>
</form>
</body>
</html>
<?php
ob_end_flush();
?>
