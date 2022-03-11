<?php

//Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["id"])){
    header("location: index.php?action=welcome");
    exit;
}
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim(md5($_POST["password"]));
    }

    // Validate credentials
     if(empty($email_err) && empty($password_err)){
         // Prepare a select statement
         $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' limit 1";

         $result = $conn->query($sql);

         if ($result->num_rows > 0) {

           $record = $result->fetch_assoc();
           $type= $record['type'];
           $id = $record['id_user'];

                // Store data in session variables

                $_SESSION["id"] = $record['id_user'];
                $_SESSION["type"] = $record['type'];

                // Redirect user to welcome page
            if($type == 1){
                header("location: index.php?action=welcome");
              }else{
                header("location: index.php?action=user");
              }

            } else{
                // Display a generic error message
                $login_err = "Invalid email or password.";
            }
        }

}
?>



    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
