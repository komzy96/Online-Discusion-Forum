<?php
//signin.php
include 'connect.php';
include 'header.php';
 

 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    // echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
    echo '<script>';
    echo 'swal("You are already signed in");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';

    echo '</script>';


}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="post" action="" class=""><div class="container-contact100">
        <div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>

        <div class="wrap-contact100">
            <form class="contact100-form validate-form">
                <span class="contact100-form-title">
                    <center>sign in</center>
                </span>

                <div class="wrap-input100 validate-input" data-validate="Please enter your username">
                    <input class="input100" type="text" name="user_name" id="inputEmail3" placeholder="username" class="form-control">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Please enter your password">
                    <input class="input100" type="password" name="user_pass" class="form-control" id="inputPassword3" placeholder="password">
                    <span class="focus-input100"></span>
                </div>
        
    <div class="container-contact100-form-btn">
                    <button type="submit" class="contact100-form-btn" data-toggle="modal" data-target="#exampleModalCenter">
                        Login
                    </button>
                </div>
  </div>
</form>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
         
        if(!isset($_POST['user_name']))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            // echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<script>';
                    echo 'swal("Uh-oh.. a couple of fields are not filled in correctly..");';

                    echo 'setTimeout(function(){
                        window.location = "signin.php";
                    },3000);';

                    echo '</script>';


            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sql = "SELECT 
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";
                         
            $result = mysqli_query($connection, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                // echo 'Something went wrong while signing in. Please try again later.';

                echo '<script>';
                    echo 'swal("Something went wrong while signing in.", "Please try again.");';

                    echo 'setTimeout(function(){
                        window.location = "signin.php";
                    },3000);';

                    echo '</script>';


                echo mysqli_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysqli_num_rows($result) == 0)
                {
                    // echo 'You have supplied a wrong user/password combination. Please try again.';
                    echo '<script>';
                    echo 'swal("You have supplied a wrong user/password combination.", "Please try again.");';

                    echo 'setTimeout(function(){
                        window.location = "signin.php";
                    },3000);';

                    echo '</script>';

                    echo '<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <h5 class="modal-title" id="exampleModalCenterTitle">You have supplied a wrong user/password combination.</h5>
                        </div>
                        <div class="modal-footer">
                          <a href="signin.php"><button type="button" class="btn btn-primary">Please try again</button></a>
                        </div>
                      </div>
                    </div>
                  </div>';

                }
                else
                {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;
                     
                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }
                     
                    // echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
                    echo '<script>';
                    echo 'swal("Welcome, ' . $_SESSION['user_name'] . '", "Proceed to home page!");';
                    echo 'setTimeout(function(){
                        window.location = "index.php";
                    },4000);';

                    echo '</script>';

                   
                }
            }
        }
    }
}


include 'footer.php';
?>