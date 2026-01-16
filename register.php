<?php
// PROCESS REGISTER FORM
$errors = [];
$successMessage = "";

if (isset($_POST["submitButton"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Password hash
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // VALIDATION
    if (empty($username) OR empty($email) OR empty($password) OR empty($confirmPassword)) {
        $errors[] = "All fields are required!";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid!";
    }
    if (strlen($username) < 16) {
        $errors[] = "Username TOO LONG! Needs to be under 16 characters!";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters!";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match!";
    }

    // DATABASE CHECK
    require_once("database.php");

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errors[] = "Email already exists!";
    }
    mysqli_stmt_close($stmt);

    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errors[] = "Username already exists!";
    }
    
    mysqli_stmt_close($stmt);

    // IF NO ERRORS → INSERT
    if (count($errors) === 0) {
        $sql = "INSERT INTO users (username, email, `password`, `role`) VALUES (?, ?, ?, 'user')"; 
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
            mysqli_stmt_execute($stmt);
            $successMessage = "You are registered successfully!";
        } else {
            $errors[] = "Something went wrong!";
        }
    }
}

/*
// damit sowas nicht passiert: (mit mysqli_stmt arbeiten) 

INSERT INTO users (username, email, password)
VALUES ('test', 'x', 'x'); DELETE FROM users; --', 'mail@test.de', '1234');

weil der user bei username das eingegeben hat:  'test', 'x', 'x'); DELETE FROM users; --
*/

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Forum</title>
    <link rel="stylesheet" href="style_register.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div id="mainOne">
      <canvas id="canvas1"></canvas>
      <header style="padding-bottom: 50px">
        <div class="hname">
          <h1><span style="color: #9c8809;">CCookie </span>Clicker</h1>
        </div>
        <div class="hicon"><div class="hpicture"></div></div>
      </header>

      <div class="Register_container">
        <div class="RegisterHolder">
          <div>
            <h1 style="margin: 5px">Registration</h1>
          </div>

          <!-- SHOW ERRORS -->
          <?php if (!empty($errors)): ?>
              <div class="error-box">
                  <?php foreach ($errors as $error): ?>
                      <div class="alert alert-danger" role="alert">
                          <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                      </div>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>

          <!-- SUCCESS -->
          <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?>
            </div>
          <?php endif; ?>

          <form action="register.php" method="post">
            <div class="form-holder">
              <input type="text" class="input_input" name="username" placeholder="Enter Username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
            </div>
            <div class="form-holder">
              <input type="email" class="input_input" name="email" placeholder="Enter E-Mail" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
            </div>
            <div class="form-holder">
              <input type="password" class="input_input" name="password" placeholder="Enter Password" required />
            </div>
            <div class="form-holder">
              <input type="password" class="input_input" name="confirm_password" placeholder="Confirm Password" required />
            </div>
            <div style="margin-bottom: 35px" class="form-holder">
              <input type="submit" class="input_input_button" name="submitButton" value="Sign up" />
            </div>
            <a class="form-holder_2" style="display: flex; align-items: end; justify-content:center" href="index.php"><span>Already have an account?</span></a></form>
        </div>
      </div>
    </div>

    <footer>
      <div class="fname">
        <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
      </div>
      <div id="creators">Made by: Aleksandar Tesinic & Paul Heigl</div>
      <div class="ficon"><div class="fpicture"></div></div>

      <a href="impressum.html" style="color:white">IMPRESSUM</a>

    </footer>

    <script src="cookiesFallingBackground.js"></script> 
  </body>

          <!--htmlspecialchars nutzen, damit z.B. keine Variablen geändert werden können per link (mit javascript): -->
          <!--https://ccclicker.at/register.php?username="><script>alert("You got hacked")</script>    FAKE LINKS KÖNNEN GENTUZT WERDEN--> 
</html>


