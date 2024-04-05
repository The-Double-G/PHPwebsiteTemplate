<?php
session_start(); // Start the PHP session

if(isset($_POST['submit'])) { // Check if the 'submit' button was clicked
    $username = $_POST['username']; // Get the username entered by the user
    $password = $_POST['password']; // Get the password entered by the user
    $hashed_password = hash('sha512', $password); // Hash the password using SHA-512

    // Open the file 'users.txt' for reading
    $file = fopen("users.txt", "r");

    // Check if the entered username and hashed password match any line in the file
    $credentials_matched = false;
    while(!feof($file)) { // Loop through the file line by line until the end of the file is reached
        $line = fgets($file); // Get the current line from the file
        $line = trim($line); // Remove any whitespace from the beginning and end of the line
        $arr = explode(":", $line); // Split the line into an array using ':' as the delimiter
        if(isset($arr[0]) && isset($arr[1]) && $arr[0] == $username && $arr[1] == $hashed_password) {
            // Check if the username and hashed password match the current line in the file
            $credentials_matched = true;
            break;
        }
    }

    // If the entered credentials match
    if($credentials_matched) {
        // Set the 'username' session variable
        $_SESSION['username'] = $username;
        // Redirect the user to 'index.php'
        header("Location: index.php");
        // Exit the PHP script
        exit();
    } else {
        // If credentials do not match set the error message and alert the user
        $error_message = "Invalid Credentials";
        echo "<script>alert('$error_message');</script>";

    }

    // Close the file
    fclose($file);
}

ob_start(); // Start output buffering
?>
<!DOCTYPE html>
<html>
<head>
  <!--
  This code contains CSS styling for a login form. It sets the font family and background color for the page, and styles the form with a white background, rounded corners, and a box shadow. The "h1" tag is centered and has no margin at the top. Labels for the username and password input fields are bolded and have a margin-bottom of 10px. The input fields have a width of 100%, a padding of 10px, and a background color of #f9f9f9. The submit button has a green background color, white text, and rounded corners. The button also has a box-shadow and changes background-color when hovered over. Finally, there is a "signup-button" class that styles a button with the same properties as the submit button but with different colors.-->
  <title>School Helper</title>
  <style>
    body {
      font-family: Arial, sans-serif;
        background-image: url(background.jpg);
        background-size: 1500px;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
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
    .signup-button {
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

    .signup-button:hover {
      background-color: #3e8e41;
    }
  </style>
</head>
<body>
<!-- This code is an HTML form for a login page. -->

<html>
<body>

<!-- This tag defines a centered heading at the top of the page that says "Login". The style attribute sets the text alignment, top margin, and color of the heading. -->
<h1 style="text-align: center; margin-top: 0; color: white;">Login</h1>

<!-- This tag defines a form that will be submitted to the current PHP script when the user clicks the "Login" button. The method attribute is set to "post" to indicate that the form data will be sent in the HTTP POST request. The action attribute is set to the value of the PHP_SELF server variable, which is the name of the current script. -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <!-- This PHP code checks if an error message exists and displays it as a paragraph with class "error". -->
    <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

    <!-- This tag defines an input field for the username, with name "username". -->
    Username: <input type="text" name="username"><br>

    <!-- This tag defines an input field for the password, with name "password". -->
    Password: <input type="password" name="password"><br>

    <!-- This tag defines a submit button with name "submit" and value "Login". When the button is clicked, the form data is sent to the script specified in the action attribute of the <form> tag. -->
    <input type="submit" name="submit" value="Login">

    <!-- This tag defines a hyperlink to the sign up page. -->
    <br>
    <a href="admin.php"">Admin? Click Here!</a>

</form>
</body>
</html>

<?php
ob_end_flush(); // Flush the output buffer and turn off output buffering
?>
