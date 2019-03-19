<?php
//session_start();
//create_cat.php
include 'connect.php';
include 'header.php';
 
if($_SESSION['signed_in'] == false  | $_SESSION['user_level'] != 1)
{
    //the user is not an admin
    //echo 'Sorry you do not have sufficient rights to access this page.';
    echo '<script>';
    echo 'swal("Sorry you do not have sufficient rights to access this page.");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';
    echo '</script>';
}
else
{

    //the user has admin rights
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form method="post" action="" class="">
    <div class="container-contact100">
        <div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>

        <div class="wrap-contact100">
            <form class="contact100-form validate-form">
                <span class="contact100-form-title">
                    <center>create a category</center>
                </span>
                Category name
<div class="wrap-input100 validate-input" data-validate="Please select a new category">
            <input class="input100" type="text" name="cat_name" id="exampleFormControlInput1" placeholder="New category here" class="form-control">
            <span class="focus-input100"></span>
            </div>
 Enter your category Description
  <div class="wrap-input100 validate-input" data-validate = "Please enter your catgory Description">
          <textarea class="input100" name="cat_description" id="exampleFormControlTextarea1" placeholder="Enter Category Description"></textarea>
          <span class="focus-input100"></span>
        </div>
  <div class="container-contact100-form-btn">
                    <button type="submit" class="contact100-form-btn">
                        Add Category
                    </button>
                    </div>
  </div>
</form>';
}
else
{
    //the form has been posted, so save it
    $sql = "INSERT INTO
                     categories(cat_name, cat_description)
       VALUES('" . mysqli_real_escape_string($connection,$_POST['cat_name']) . "',
             '" . mysqli_real_escape_string($connection, $_POST['cat_description']) . "')";
    $result = mysqli_query($connection, $sql);
    if(!$result)
    {
        //something went wrong, display the error
        //echo 'Error' . mysqli_error();
        echo '<script>';
        echo 'swal("Error");';
        echo 'setTimeout(function(){
            window.location = "create_cat.php";
        },3000);';
    
        echo '</script>' . mysqli_error();
    }
    else
    {
        echo 'New category successfully added.';
        echo '<script>';
        echo 'swal("New category successfully added.", "You can add more", "success");';
        echo 'setTimeout(function(){
            window.location = "create_cat.php";
        },3000);';

        echo '</script>';
        }
    }
}

include 'footer.php'
?>