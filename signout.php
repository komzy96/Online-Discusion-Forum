<?php
//signout.php
include 'connect.php';
include 'header.php';

echo '<center><h2>Sign out</h2></center>';

//check if user is signed in
if($_SESSION['signed_in'] == true)
{
    //unset all variables
    $_SESSION['signed_in'] = NULL;
    $_SESSION['user_name'] = NULL;
    $_SESSION['user_id'] = NULL;

    // echo 'Successfully signed out, thank you for visiting.';

                    echo '<script>';
                    echo 'swal("Successfully signed out", "Thank you for visiting.", "success");';
                    echo 'setTimeout(function(){
                        window.location = "signin.php";
                    },3000);';

                    echo '</script>';

}
else{
    // echo 'You are not currently signed in. Would you like to <a href="signin.php">Sign in</a> ?';

    echo '<script>';
                    echo 'swal("You are not currently signed in.", "Sign in?");';
                    echo 'setTimeout(function(){
                        window.location = "signin.php";
                    },3000);';

                    echo '</script>';
    
}

include 'footer.php';
?>