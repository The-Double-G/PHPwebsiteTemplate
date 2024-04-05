<?php
// Start a new or resume an existing session
session_start();

// Check if the username session variable is set, if not, redirect the user to the login page
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<!-- The HTML code starts here -->

<html>
    <head>
      <title>School Helper</title>

      <!-- Add some styling to the HTML elements -->
      <style>
        body {
          background-color: #000000;
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
        }
        h1 {
          color: #ffffff;
          text-align: center;
          margin-top: 50px;
        }

        /* CSS */
        a {
          background: #FF4742;
          border: 0px solid #FF4742;
          border-radius: 6px;
          box-shadow: rgba(0, 0, 0, 0.1) 1px 2px 4px;
          box-sizing: border-box;
          color: #FFFFFF;
          cursor: pointer;
          display: inline-block;
          font-family: nunito,roboto,proxima-nova,"proxima nova",sans-serif;
          font-size: 16px;
          font-weight: 800;
          line-height: 16px;
          min-height: 40px;
          outline: 1px;
          padding: 12px 14px;
          text-align: center;
          text-rendering: geometricprecision;
          text-transform: none;
          user-select: none;
          -webkit-user-select: none;
          touch-action: manipulation;
          vertical-align: middle;
          margin: 10px;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        a:hover,
        a:active {
          background-color: initial;
          background-position: 0 0;
          color: #f2f2f2;
        }


      </style>
    </head>
    <body>

      <!DOCTYPE html>
      <html>
      <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
      body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        height:1650px;
      }

      .topnav {
        overflow: hidden;
        background-color: #333;
      }

      .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
      }

      .topnav a.active {
        background-color: #800000;
        color: white;
      }

      .topnav .icon {
        display: none;
      }

      @media screen and (max-width: 600px) {
        .topnav a:not(:first-child) {display: none;}
        .topnav a.icon {
          float: right;
          display: block;
        }
      }

      @media screen and (max-width: 600px) {
        .topnav.responsive {position: relative;}
        .topnav.responsive .icon {
          position: absolute;
          right: 0;
          top: 0;
        }
        .topnav.responsive a {
          float: none;
          display: block;
          text-align: left;
        }
      }
      </style>
      </head>
  <body>

    <div class="topnav" id="myTopnav">
      <a href="index.php">Home</a>
      <a href="biology.php">Biology</a>
      <a href="chemistry.php">Chemestry</a>
      <a href="geometry.php">Geometry</a>
      <a href="algebra1.php">Algebra 1</a>
      <a href="algebra2.php">Algebra 2</a>
      <a href="calculus.php">Calculus</a>
      <a href="english.php">English</a>
      <a href="computerscience.php">Computer Science</a>
      <a href="history.php">History</a>
        <a href="settings.php" class="active">Settings</a>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>

  <!-- here is the space to put the content -->
    <h1>WORK IN PROGRESS NEW SETTINGS</h1>
    <?php

    // Function to check if the user has already inputted data for today
    function hasUserInputtedToday() {
        $date = date("Y-m-d");
        if (isset($_SESSION['last_input_date']) && $_SESSION['last_input_date'] == $date) {
            return true;
        } else {
            return false;
        }
    }

    // Function to save user input to a text file named "suggestions.txt"
    function saveInputToFile($input) {
        $file = fopen("suggestions.txt", "a");
        fwrite($file, "$input\n");
        fclose($file);
    }

    // Check if the user has already inputted data for today
    if (hasUserInputtedToday()) {
        echo "<div style='font-family: Arial; background-color: #f2f2f2; padding: 20px; border-radius: 5px;'>";
        echo "You have already submitted a request for today.";
        echo "</div>";
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_input"])) {
            $userInput = $_POST["user_input"];
            saveInputToFile($userInput);
            $_SESSION['last_input_date'] = date("Y-m-d");
            echo "<div style='font-family: Arial; background-color: #f2f2f2; padding: 20px; border-radius: 5px;'>";
            echo "Request successfully submitted.";
            echo "</div>";
        } else {
            ?>
            <div style='font-family: Arial; background-color: #f2f2f2; padding: 20px; border-radius: 5px;'>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="user_input" style="font-weight: bold;">Enter your game suggestion for today(OPTIONAL):</label><br>
                    <textarea id="user_input" name="user_input" style="width: 300px; height: 100px; margin-bottom: 10px;"></textarea><br>
                    <input type="submit" value="Submit" style="padding: 5px 10px; background-color: #FF4742; color: white; border: none; border-radius: 3px; cursor: pointer;">
                </form>
            </div>
            <?php
        }
    }
    ?>



  <script>
  function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
  }
  </script>

  </body>
  </html>


  <!-- Add a logout link that points to the logout.php file -->
  <a href="logout.php">Logout</a>
</body>
</html>
