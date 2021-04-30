<?php
    if($_POST['action'] == 'call_this') {
        function logout() {
            $_SESSION['userType'] = "";
            $userName = "";
            $_SESSION['userName'] = $userName;
        }
    }
?>