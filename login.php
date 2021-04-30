<?php
  $userName = (string) $_POST['userName'];
  $password = (string) $_POST['password'];
  ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>CPSC 431, Project - IMS</title>
  </head>
  <body>
    <div class="jumbotron text-center" style="padding: 50px; background-color: #778899; color: white;">
      <h1>Inventory Management System</h1>
      <p>Created by Adam Laviguer and Hammad Qureshi</p>
    </div>
    <script>
      $(document).ready(function(){
          $("#exampleModal").modal('show');
      });
    </script>

    <div class="container" style="margin-top: 25px; max-width: 480px;">
      <?php
      
        if(isset($_POST['loginBtn'])) {
          //authUserLogin();
          login($userName, $password);
        }

        function login($userName, $password) {
          // check $userName and $password with db
          // if yes, return true
          // else throw exception
          
          // connect to db
          $db = new mysqli('mariadb', 'cs431s1', 'oong3aiK', 'cs431s1');
          // Check database connection
          if (mysqli_connect_errno()) {
            echo "<p>Error: Could not connect to database.<br/>
                Please try again later.</p>";
            exit;
          }
    
          // check if $userName is unique
          $result = $db->query("SELECT userType FROM IMSusers
                                WHERE userName = '".$userName."' AND password = '".$password."'");

          if (!$result) {
            throw new Exception('Could not log you in.');
          }
          if ($result->num_rows>0) {
            session_start();
            while($row = $result->fetch_assoc()) {
              if ($row['userType'] == "Inventory") {
                header("Location: ./inventory.php");
                $_SESSION['userType'] = 'inventory';
                $_SESSION['userName'] = $userName;
                exit();
              }
              if ($row['userType'] == "Manager") {
                header("Location: ./manager.php");
                $_SESSION['userType'] = 'manager';
                $_SESSION['userName'] = $userName;
                exit();
              }
              if ($row['userType'] == "Procurement") {
                header("Location: ./procurement.php");
                $_SESSION['userType'] = 'procurement';
                $_SESSION['userName'] = $userName;
                exit();
              }
            }
          } 
          else { ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Please try logging in again.
                  </div>
                  <div class="modal-footer">
                    <a href="./index.php" type="button" class="btn btn-primary">Back</a>
                  </div>
                </div>
              </div>
            </div>
      <?php
          }
        }
      ?>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>
