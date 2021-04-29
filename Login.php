<?php
  $userName = (string) $_POST['Username'];
  $userPassword = (string) $_POST['Password'];
  ini_set('display_errors', 1);
?>

      <?php
        if(isset($_POST['loginBut'])) {
          //authUserLogin();
          login($userName, $userPassword);
        }
        /*
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
          $stmt = $db->prepare($query);
          $stmt->bind_param('sssss', $photoName, $photoDate, $photographer, $location, $fileToUpload);
          $stmt->execute();

          if ($numRows == 0) {
              echo  "<p>Username or Password does not exist.</p>";
          } else {
              echo "<p>Successfully logged in.</p>";
          }
          $db->close();     
        }*/
        
        function login($username, $userpassword) {
          // check userName$userName and userPas$userPassword with db
          // if yes, return true
          // else throw exception
          
            // connect to db
            $db = new mysqli('mariadb', 'cs431s23', 'Va7Wobi9', 'cs431s23');
            // Check database connection
            if (mysqli_connect_errno()) {
              echo "<p>Error: Could not connect to database.<br/>
                  Please try again later.</p>";
              exit;
            }

            // check if userName$userName is unique
            $result = $db->query("select * from IMSlogin
                                   where userName='".$username."'
                                   and userPassword = sha1('".$userpassword."')");
            if (!$result) {
               throw new Exception('Could not log you in.');
            }
          
            if ($result->num_rows>0) {
               return true;
            } else {
               throw new Exception('Could not log you in.');
            }
            echo '<p>success</p>';
          }
      ?>