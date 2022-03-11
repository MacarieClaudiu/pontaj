<?php

// Define variables and initialize with empty values
$project = $manager = $user = "";
$project_err = "";

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["project"]))){
        $project_err = "Please enter a project name.";
    }else{
        $project = trim($_POST["project"]);
      }

      $sql= "SELECT * FROM users WHERE type = 1;";
      $result = $conn->query($sql);
      while ($record = $result->fetch_assoc()){
        if($_POST['manager'] AND $record['type']==1){
          $manager = $_POST['manager'];
        }else{
          $manager = "";
        }
      }

    if(empty($project_err) AND $manager == ""){

        $sql = "INSERT INTO `projects` (project_name) VALUES ('$project');";

        if ($conn->query($sql)) {
          header("location: index.php?action=projects");
        } else {
        echo "Not registered" ;
        }

}


    if (empty($project_err) AND $manager!=="") {
        $sql = "INSERT INTO `projects` (project_name, manager_id) VALUES ('$project','$manager');";

        if ($conn->query($sql)) {
          header("location: index.php?action=projects");
        } else {
        echo "Not registered" ;
        }

}


        $sql= "SELECT * FROM users WHERE type = 2;";
        $result = $conn->query($sql);

        if($record = $result->fetch_assoc()){
          if(!empty($_POST['user']) AND $record['type']==2){
            $user = $_POST['user'];
          }else {
            $user="";
          }
        }


        $sql= "SELECT * FROM projects WHERE project_name = '$project' ;";
        $result = $conn->query($sql);
        $record = $result->fetch_assoc();
        $id_project = $record['id_project'];


    if (empty($project_err) AND $user!=="") {

        foreach ($user as $id_user) {
          $sql = "INSERT INTO `project_users` (id_project, id_user) VALUES ('$id_project','$id_user');";
          $result = $conn->query($sql);
        }
        if ($result) {
          header("location: index.php?action=projects");
        } else {
        echo "Not registered" ;
        }

      }

    }

?>



    <div class="wrapper">
        <h2>Add project</h2>
        <p>Please fill this form to create a project.</p>
        <form action="index.php?action=add-project" method="post">
            <div class="form-group">
                <label>Project Name</label>
                <input type="text" name="project" class="form-control <?php echo (!empty($project_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $project; ?>" >
                <span class="invalid-feedback"><?php echo $project_err; ?></span>
            </div class="mb-3">
            <div>
                <label>Manager</label>
                <select class="form-select" name="manager">
                <option value ="">Chose one manager</option>
            <?php

                  $sql= "SELECT * FROM users WHERE type = 1;";
                  $result = $conn->query($sql);
                  while ($record = $result->fetch_assoc()) {?>

                  <option value="<?php echo $record['id_user'];?>"><?php echo $record['lastname'].' '.$record['firstname']; ?></option>
              <?php
             }
               ?>

                </select>
            </div>
            <label>Users</label><br>
            <div class="dropdown">
              <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Choose users
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

              <?php

                  $sql= "SELECT * FROM users WHERE type = 2;";
                  $result = $conn->query($sql);
                  while ($record = $result->fetch_assoc()) {?>

                    <li>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="user"  name="user[]" value="<?php echo $record['id_user'] ?>">
                        <label class="form-check-label" for="user"> <?php echo $record['lastname'].' '.$record['firstname']; ?></label>
                      </div>
                    </li>

              <?php
                   }
               ?>
             </ul>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
            <p>Go back to: <a href="index.php?action=projects">Projects list</a>.</p>
        </form>
    </div>
