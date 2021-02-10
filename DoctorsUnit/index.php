<?php
include "./config_settings.php";
include "./function.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="author" content="Noel Kapungu">
     <title><?php echo $system_name_short_name; ?></title>

     <link rel="stylesheet" href="css/health.css">

</head>

<body>


     <div class="flex-container">
          <div class="login">
               <form action="login_mod/check_login" method="POST">
                    <img src="images/logo.png" id="logo" alt="Medical logo" width="300" height="300">
                    <h1>Log In</h1>
                    <section class="inputs">
                         <div class="username">
                              <input type="text" name="email" id="email" placeholder="Email or Username" required>
                              <span id="email_err" class="error"></span>
                         </div>
                         <br>
                         <div class="password">
                              <input type="password" name="password" id="password" placeholder="Password" required>
                              <span id="password_err" class="error"></span>
                         </div>

                         <span>
                              <a href="#">Forgot Password?</a>
                         </span>
                    </section>
                    <button type="submit" name="submit">Login</button>
               </form>
          </div>
          <div class="side-image">
          </div>
     </div>
     <script src="js_mode/base64.js"></script>
     <script src="js_mode/common.js"></script>
     <script src="js_mode/_health.js"></script>
</body>

</html>