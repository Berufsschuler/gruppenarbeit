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
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters!";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match!";
    }

    // DATABASE CHECK
    require_once("database.php");
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already exists!";
    }

    // IF NO ERRORS → INSERT
    if (count($errors) === 0) {
        $sql = "INSERT INTO users (username, email, `password`) VALUES (?, ?, ?)";
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
            <div class="cpicture"></div>
            <h1 style="margin: 5px">Registration</h1>
            <div class="cpicture"></div>
          </div>

          <!-- SHOW ERRORS -->
          <?php if (!empty($errors)): ?>
              <div class="error-box">
                  <?php foreach ($errors as $error): ?>
                      <div class="alert alert-danger" role="alert">
                          <?php echo $error; ?>
                      </div>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>

          <!-- SUCCESS -->
          <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
          <?php endif; ?>

          <form action="register.php" method="post">
            <div class="form-holder">
              <input type="text" class="input_input" name="username" placeholder="Enter Username" required />
            </div>
            <div class="form-holder">
              <input type="email" class="input_input" name="email" placeholder="Enter E-Mail" required />
            </div>
            <div class="form-holder">
              <input type="password" class="input_input" name="password" placeholder="Enter Password" required />
            </div>
            <div class="form-holder">
              <input type="password" class="input_input" name="confirm_password" placeholder="Confirm Password" required />
            </div>
            <div class="form-holder">
              <input type="submit" class="input_input_button" name="submitButton" value="Sign up" /><br><br>
            </div>
            <a style="display: flex; align-items: end; justify-content:center" href="index.php"><span>Already have an account? &nbsp&nbspLog&nbsp&nbspin&nbsp&nbsp</span><svg style="transform: translateY(2px)" xmlns="http://www.w3.org/2000/svg" width="32" height="24" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M20 11q-.425 0-.712-.288T19 10t.288-.712T20 9t.713.288T21 10t-.288.713T20 11m-1-3V3h2v5zM9 12q-1.65 0-2.825-1.175T5 8t1.175-2.825T9 4t2.825 1.175T13 8t-1.175 2.825T9 12m-8 8v-2.8q0-.85.438-1.562T2.6 14.55q1.55-.775 3.15-1.162T9 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T17 17.2V20z"/></svg></a>          </form>
        </div>
      </div>
    </div>

    <footer>
      <div class="fname">
        <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
      </div>
      <div id="creators">Made by: Aleksandar Tesinic & Paul Heigl</div>
      <div class="ficon"><div class="fpicture"></div></div>
    </footer>

    <script src="cookiesFallingBackground.js"></script>
  </body>
</html>
