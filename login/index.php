<?php
    require "../user.php";
    $error = "";
    if(isset($_POST['email'], $_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = new User(0, $email);
        $islogin = $user->login($password);

        if( $islogin ){
            setcookie('email', $email);
            setcookie('id', $user->ID);
        } else {
            $error = "Invalid Login Credentials";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .login-container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 350px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      transition: 0.3s;
    }

    .form-group input:focus {
      border-color: #667eea;
      box-shadow: 0 0 5px rgba(102,126,234,0.6);
    }

    .login-btn {
      width: 100%;
      padding: 0.9rem;
      border: none;
      background: #667eea;
      color: #fff;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-btn:hover {
      background: #5a67d8;
    }

    .extra-links {
      text-align: center;
      margin-top: 1rem;
    }

    .extra-links a {
      color: #667eea;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="<?= $_SERVER['REQUEST_URI'];?>" method="post">
     <div class="error">
        <?= $error; ?>
     </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="login-btn">Login</button>
      <div class="extra-links">
        <a href="forgot">Forgot Password?</a> | <a href="/signup">Sign Up</a>
      </div>
    </form>
  </div>
</body>
</html>
