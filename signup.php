<?php
//signup.php
include 'connect.php';
include 'header.php';
 
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
     echo '<form method="post" action="" class=""><div class="container-contact100">
        <div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>
<div class="wrap-contact100">
            <form class="contact100-form validate-form">
                <span class="contact100-form-title">
                    <center>sign up</center>
                </span>
   <div class="wrap-input100 validate-input" data-validate="Please enter your username">
                    <input class="input100" type="text" name="user_name" id="inputEmail3" placeholder="username" class="form-control">
                    <span class="focus-input100"></span>
                </div>

  <div class="wrap-input100 validate-input" data-validate="Please enter your username">
      <input type="email" name="user_email" class="input100" id="inputEmail3" placeholder="Email">
      <span class="focus-input100"></span>
    </div>
  <div class="wrap-input100 validate-input" data-validate="Please enter your password">
                    <input class="input100" type="password" name="user_pass" class="form-control" id="inputPassword3" placeholder="Enter your password">
                    <span class="focus-input100"></span>
                </div>
  <div class="wrap-input100 validate-input" data-validate="Please enter your password">
      <input type="password" name="user_pass_check" class="input100" id="inputPassword3" placeholder="Confirm Password">
       <span class="focus-input100"></span>
    </div>
  <div class="container-contact100-form-btn">
      <button type="submit" class="contact100-form-btn">Sign Up</button>
    </div>
  </div>
</form>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data 
    */
    $errors = array(); /* declare the array for later use */
     
    if(isset($_POST['user_name']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
     
     
    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
     
    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
       // echo 'Uh-oh.. a couple of fields are not filled in correctly..';
       echo '<script>';
       echo 'swal("Uh-oh.. a couple of fields are not filled in correctly..");';


       echo 'setTimeout(function(){
           window.location = "signup.php";
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
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" . mysqli_real_escape_string($connection, $_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysqli_real_escape_string($connection, $_POST['user_email']) . "',
                        NOW(),
                        0)";
                         
        $result = mysqli_query($connection, $sql);
        if(!$result)
        {
            //something went wrong, display the error
            //echo 'Something went wrong while registering. Please try again later.';
            echo '<script>';
                    echo 'swal("Something went wrong while signing in.", "Please try again.");';

                    echo 'setTimeout(function(){
                        window.location = "signup.php";
                    },3000);';

                    echo '</script>';

            echo mysqli_error($connection); //debugging purposes, uncomment when needed
        }
        else
        {
            //echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
            echo '<script>';
                echo 'swal("Successfully  registered", "You can now sign and start posting!", "success");';

                    echo 'setTimeout(function(){
                        window.location = "index.php";
                    },3000);';

                    echo '</script>';
        }
    }
}
 
include 'footer.php';
?>