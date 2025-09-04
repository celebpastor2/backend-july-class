<?php 
# $_REQUEST carries all data sent to the server associative array 
# $_POST carries all data posted to server sent via post request
require "../user.php";
$error = [
    'fullname'  => '',
    'email'     => '',
    'password'  => '',
    'confirm'   => ''
];
if(isset($_POST['fullname'], $_POST['email'], $_POST['password'], $_POST['passwordConfirmation'])){
    $fullname = $_POST['fullname'];
    $names      = explode(" ", $fullname);
    $fullcount = count( $names );
    #Phillip Samuel
    if( $fullcount < 2){
        $error['fullname']  = "Please enter both first name and last name";
    } else {
        foreach($names as $name){
            if(strlen($name) < 3){
                $error['fullname']  = "Invalid name Detected";
                break;
            } else if(strstr($name, '/[1-9^]/')){
                $error['fullname'] = "Invalid name Detected";
                break;
            }           
        }

        if( !$error['fullname']){
            $email = $_POST['email'];

            if(!strstr($email, "@")){
                $error['email'] = "Invalid Email";
            } else {
                $pass = $_POST['password'];
                $confirm = $_POST['passwordConfirmation'];

                if( $pass != $confirm ){
                    $error['confirm']   = "Password Does not match";
                }else{

                }
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
  <title>Sign Up Page</title>
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

    .signup-container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 380px;
    }

    .signup-container h2 {
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

    .signup-btn {
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

    .signup-btn:hover {
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
  <div class="signup-container">
    <h2>Create Account</h2>
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
        <div class="error">
            <?= $error['fullname'];?>
        </div>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
         <div class="error">
            <?= $error['email'];?>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>
         <div class="error">
            <?= $error['password'];?>
        </div>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="passwordConfirmation" placeholder="Confirm your password" required>
         <div class="error">
            <?= $error['confirm'];?>
        </div>
      </div>
      <button type="submit" class="signup-btn">Sign Up</button>
      <div class="extra-links">
        <a href="login">Already have an account? Login</a>
      </div>
    </form>
  </div>
</body>
</html>
