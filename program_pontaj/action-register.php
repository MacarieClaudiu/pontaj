<?php

// Define variables and initialize with empty values
$lastname = $firstname = $email = $type = $password = "";
$lastname_err = $firstname_err = $email_err = $type_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a lastname.";
    } elseif(!preg_match("/^[a-zA-Z0-9_' ]*$/", trim($_POST["lastname"]))){
        $lastname_err = "Lastname can only contain letters and white space.";
    } else{
        $lastname = trim($_POST["lastname"]);
      }

    // Validate fistname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a firstname.";
    } elseif(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["firstname"]))){
        $firstname_err = "Firstname can only contain letters and white space.";
    } else{
        $firstname = trim($_POST["firstname"]);
      }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format";
    }else{
        $email = trim($_POST["email"]);
      }

    $sql = "SELECT email FROM users WHERE email = '$email' limit 1";

    $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $email_err = 'This email is already taken!';
      }
    // Validate type
    if(empty(trim($_POST["type"]))){
        $type_err = "Please enter the type, admin or user.";
    } elseif(!preg_match("/^[1-2]*$/", trim($_POST["type"]))){
        $type_err = "Only 1 or 2.";
    } else{
        $type = trim($_POST["type"]);
      }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters";
    } elseif(strlen(trim($_POST["password"])) > 15){
        $password_err = "Password must have atmost 15 characters";
    } else{
        $password = md5($_POST["password"]);
    }


    // Check input errors before inserting in database
    if(empty($lastname_err) && empty($firstname_err) && empty($email_err) && empty($email_err) && empty($password_err)){

                // Prepare an insert statement
            $sql = "INSERT INTO users (lastname, firstname, email, type, password) VALUES ('$lastname', '$firstname', '$email', '$type', '$password' )";

                if ($conn->query($sql) === TRUE) {
                  header("location: index.php?action=welcome");
            } else {
              echo "The user is not registered" ;
            }
        }
    }

?>



    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="index.php?action=register" method="post">
            <div class="form-group">
                <label>Lastname</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>" >
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Firstname</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>" >
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" >
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Type(adm-1/user-2)</label>
                <input type="number" name="type" class="form-control <?php echo (!empty($type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $type; ?>">
                <span class="invalid-feedback"><?php echo $type_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
            <p>Go back to: <a href="index.php?action=welcome">Users list</a>.</p>
        </form>
    </div>
