<?php

if(!isset($_SESSION['id'])){
     header("Location: index.php?action=login");
}
if($_SESSION['type'] == 2){
  header("Location: index.php?action=user");
}

$id= $_SESSION['id'];

$sql= "SELECT * FROM `users` WHERE id_user= '$id';";

   $result = $conn->query($sql);
   $record = $result->fetch_assoc();

   // Define variables and initialize with empty values
   $day = $user = $project = $hour = "";
   $day_err = $user_err = $project_err = $hour_err = "";

   // Processing form data when form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){

       // Validate day
       if(empty(trim($_POST["day"]))){
           $day_err = "Please enter day.";
       } else{
           $day = trim($_POST["day"]);
         }

       // Validate user
       if(empty(trim($_POST["user"]))){
           $user_err = "Please enter a user.";
       }else{
           $user = trim($_POST["user"]);
         }

       // Validate project
       if(empty(trim($_POST["project"]))){
           $project_err = "Please enter a project.";
       }else{
           $project = trim($_POST["project"]);
         }

       // Validate type
       if(empty(trim($_POST["hour"]))){
           $hour_err = "Please enter hour.";
       }else{
           $hour = trim($_POST["hour"]);
         }


       // Check input errors before inserting in database
       if(empty($day_err) && empty($user_err) && empty($project_err) && empty($hour_err)){

                   // Prepare an insert statement
               $sql = "INSERT INTO `hours` (id_project, id_user, hours, days) VALUES ('$project', '$user', '$hour', '$day');";

                   if ($conn->query($sql) === TRUE) {
                     header("location: index.php?action=hours");
               } else {
                 echo "Hours not registered" ;
               }
          }
       }

?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link" href="index.php?action=welcome">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="index.php?action=projects">Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php?action=hours">Hours</a>
            </li>

          </ul>
        </div>
        <div id ="logout" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle"  href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $record['firstname']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="index.php?action=logout">Log out</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Add hours
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add hours</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="index.php?action=hours" method="POST">
          <div class="modal-body">
                  <label for="day">Select day</label>
                  <input type="date" class="form-control" id="day" name="day">
                  <span class="invalid-feedback"><?php echo $day_err; ?></span>

                  <label>User</label>
                  <select class="form-select" id="modalUser" name="user" onchange="FetchUser()" required>
                  <option value ="">Chose user</option>
              <?php

                    $sql= "SELECT project_users.id_project, project_users.id_user, users.lastname, users.firstname
                    FROM project_users
                    JOIN users
                    ON
                    project_users.id_user=users.id_user ORDER BY id_user;";
                    $result = $conn->query($sql);
                    $array[]=[];
                    while ($record = $result->fetch_assoc()) {
                      $idU = $record['id_user'];
                      $array[$idU]= $record;
                      ?>

                    <option value="<?php echo $record['id_user']; ?>">
                      <?php echo $array[$idU]['lastname'].' '.$array[$idU]['firstname']; ?>
                    </option>
                <?php
               }
                 ?>

                  </select>
                  <span class="invalid-feedback"><?php echo $user_err; ?></span>
                  <label>Projects</label>
                  <select class="form-select" name="project">
                  <option value ="">Chose project</option>

                      <option value="" id="x">
                        <?php echo $array[$idU]['id_project']; ?>
                      </option>

                  </select>
                  <span class="invalid-feedback"><?php echo $project_err; ?></span>
                  <label for="hours">Hours</label>
                  <input type="number" class="form-select" id="hours" name="hour" step=",1">
                  <span class="invalid-feedback"><?php echo $hour_err; ?></span>

          </div>
          <div class="modal-footer">
            <p id="p">asdad</p>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Save">
          </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table table-success table-striped">
      <thead>
        <tr>
          <th scope="col">Project</th>
          <th scope="col">Monday</th>
          <th scope="col">Tuesday</th>
          <th scope="col">Wednesday</th>
          <th scope="col">Friday</th>
          <th scope="col">Thursday</th>
          <th scope="col">Saturday</th>
          <th scope="col">Sunday</th>
        </tr>
      </thead>

      <tbody>

      </tbody>

      </table>
