<?php
  $userName = (string) $_POST['Username'];
  $userPassword = (string) $_POST['Password'];
  ini_set('display_errors', 1);
?>

<div class="container">
      <?php
        if(isset($_POST['logInBtn'])) {
          authUserLogin();
        }

        function authUserLogin() {
          @$db = new mysqli('mariadb', 'cs431s23', 'Va7Wobi9', 'cs431s23');

          // Check database connection
          if (mysqli_connect_errno()) {
            echo "<p>Error: Could not connect to database.<br/>
                  Please try again later.</p>";
            exit;
          }

          $query = mysqli_query($db, "SELECT * FROM IMSLogin WHERE userName='" . $_POST["Username"] . "' and userPassword = '". $_POST["Password"]."'");
          $numRows = mysqli_num_rows($query);
          /*$stmt = $db->prepare($query);
          $stmt->bind_param('sssss', $photoName, $photoDate, $photographer, $location, $fileToUpload);
          $stmt->execute();*/

          if ($numRows == 0) {
              echo  "<p>Username or Password does not exist.</p>";
          } else {
              echo "<p>Successfully logged in.</p>";
          }
          $db->close();     
        }
      ?>
    </div>