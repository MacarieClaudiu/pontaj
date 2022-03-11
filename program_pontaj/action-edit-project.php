<?php
$id= $_GET['id'];

$sql= "SELECT * FROM `projects` where id_project = '$id'";

 $result = $conn->query($sql);
 $record = $result->fetch_assoc();

 // Define variables and initialize with empty values
 $project = $record['project_name'];

 $manager = "";
 $user = "";
 $project_err = "";

 // Processing form data when form is submitted

 if($_SERVER["REQUEST_METHOD"] == "POST"){
//validate project name
     if(empty(trim($_POST["project"]))){
         $project_err = "Please enter a project name.";
     }else{
         $project = trim($_POST["project"]);
       }
//validate manager
       $sql= "SELECT * FROM users WHERE type = 1;";
       $result = $conn->query($sql);
       while ($record = $result->fetch_assoc()){
         if($_POST['manager'] AND $record['type']==1){
           $manager = $_POST['manager'];
         }else{
           $manager = "0";
         }
       }



//update project name and manager
     if (empty($project_err)) {
         $sql = "UPDATE `projects`SET project_name = '$project', manager_id = '$manager' WHERE id_project = '$id';";

         if ($conn->query($sql)) {
           header("location: index.php?action=projects");
         } else {
         echo "Not registered" ;
         }

 }

//validate user
         $sql= "SELECT * FROM users WHERE type = 2;";
         $result = $conn->query($sql);

         if($record = $result->fetch_assoc()){
           if(!empty($_POST['user']) AND $record['type']==2){
             $user = $_POST['user'];
           }else {
             $user="";
           }
         }

// select ids from project users where are multiple users at same project
         $sql="SELECT id FROM `project_users` WHERE id_project = '$id';";
         $res = $conn->query($sql);
         if($res->num_rows > 0){
              $rec=$res->fetch_assoc();
              $ids=$rec['id'];
         }

//update user


     if (empty($project_err) AND $user!=="") {

         foreach ($user as $id_user) {
           $sql = "UPDATE `project_users` SET id_user = '$id_user' WHERE id = '$ids';";
           $result = $conn->query($sql);
           $ids++;
         }
         if ($result) {
           header("location: index.php?action=projects");
         } else {
         echo "Not updated" ;
         }

       }

     }

 ?>



     <div class="wrapper">
         <h2>Edit project</h2>
         <p>Please fill this form to create a project.</p>
         <form action="index.php?action=edit-project&id=<?php echo $id;?>" method="post">
             <div class="form-group">
                 <label>Project Name</label>
                 <input type="text" name="project" class="form-control <?php echo (!empty($project_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $project; ?>" >
                 <span class="invalid-feedback"><?php echo $project_err; ?></span>
             </div class="mb-3">
             <div>
                 <label>Manager</label>
                 <select class="form-select" name="manager">
                 <option value = "">Chose one manager</option>
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

     
