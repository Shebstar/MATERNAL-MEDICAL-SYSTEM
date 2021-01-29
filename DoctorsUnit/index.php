<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Login</title>
  <link rel="stylesheet" href="styles/style.css">
  <meta charset="utf-8">
</head>

<body>
  <div class="flex-container">
    <div class="login">
      <form action="home.php" method="POST">
        <img src="img/logo.png" id="logo" alt="Medical logo" width="300" height="300">
        <h1>Log In</h1>
        <section class="inputs">
          <div class="username">
            <input type="text" name="username" id="username" placeholder="Enter Username" required>
          </div>
          <br>
          <div class="password">
            <input type="password" name="password" id="password" placeholder="Password" required>
          </div>


        </section>
        <button type="submit" name="login">Login</button>
      </form>
    </div>

    <div class="side-image">
    </div>
  </div>

  <script src="scripts/"></script>
</body>

</html>