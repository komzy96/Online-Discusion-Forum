<?php
//session_start();
//create_topic.php
include 'connect.php';
include 'header.php';
 
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    //echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.';
    echo '<script>';
            echo 'swal("Sorry, you have to be signed in to create a topic");';
            echo 'setTimeout(function(){
                window.location = "index.php";
            },3000);';

            echo '</script>';
}
else   
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";
         
        $result = mysqli_query($connection, $sql);
         
        if(!$result)
        {
            //the query failed, uh-oh :-(
            //echo 'Error while selecting from database. Please try again later.';
            echo '<script>';
            echo 'swal("Error while selecting from database.", "Please try again later.");';
            echo 'setTimeout(function(){
                window.location = "create_topic.php";
            },3000);';

            echo '</script>';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                   // echo 'You have not created categories yet.';
                   echo '<script>';
                   echo 'swal("You have not created categories yet.");';
                   echo 'setTimeout(function(){
                       window.location = "index.php";
                   },3000);';
       
                   echo '</script>';
                }
                else
                {
                    //echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                    echo '<script>';
                    echo 'swal("Before you can post a topic, you must wait for an admin to create some categories.");';
                    echo 'setTimeout(function(){
                        window.location = "index.php";
                    },3000);';
        
                    echo '</script>';
                }
            }
            else
            {
         
                echo '<form method="post" action="" class="">
                <div class="container-contact100">
        <div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>

        <div class="wrap-contact100">
            <form class="contact100-form validate-form">
                <span class="contact100-form-title">
                    <center>create a New Topic</center>
                </span>
Topic Subject
  <div class="wrap-input100 validate-input" data-validate="Please select a new category">
            <input class="input100" type="text" name="topic_subject" "exampleFormControlInput1" placeholder="New topic Subject here" class="form-control">
            <span class="focus-input100"></span>
            </div>
                    <div class="wrap-input100">
    <label for="exampleFormControlSelect1">Category</label>'; 
                 
                echo '<select name="topic_cat" class="form-control" id="exampleFormControlSelect1">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                    }
                echo '</select> </div>'; 
                     
                echo 'Message<div class="wrap-input100">
    <textarea name="post_content" class="input100" id="exampleFormControlTextarea1" placeholder="Enter your Message"></textarea>
    <span class="focus-input100"></span>
  </div>
    <div class="container-contact100-form-btn">
      <button type="submit" class="contact100-form-btn">Add Topic</button>
    </div>
  </div>
</form>';
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysqli_query($connection, $query);
         
        if(!$result)
        {
            //Damn! the query failed, quit
           // echo 'An error occured while creating your topic. Please try again later.';
            echo '<script>';
            echo 'swal("An error occured while creating your topic.", "Please try again later.");';
            echo 'setTimeout(function(){
                window.location = "create_topic.php";
            },3000);';

            echo '</script>';
        }
        else
        {
     
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
          $sql = "INSERT INTO 
                        topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
                               NOW(),
                               " . mysql_real_escape_string($_POST['topic_cat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";
                             //$_SESSION['user_id']; 
                      
            $result = mysqli_query($connection, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                //echo 'An error occured while inserting your data. Please try again later.' . mysqli_error($connection);
                echo '<script>';
                echo 'swal("An error occured while inserting your data.", "Please try again later.");';
                echo 'setTimeout(function(){
                    window.location = "create_topic.php";
                },3000);';
    
                echo '</script>' . mysqli_error($connection);

                $sql = "ROLLBACK;";
                $result = mysqli_query($connection, $sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id($connection);
                 
                $sql = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($connection,$_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result = mysqli_query($connection,$sql);
                 
                if(!$result)
                {
                    //something went wrong, display the error
                   // echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
                    echo '<script>';
                    echo 'swal("An error occured while inserting your post.", "Please try again later.");';
                    echo 'setTimeout(function(){
                        window.location = "create_topic.php";
                    },3000);';
        
                    echo '</script>' . mysql_error();

                    $sql = "ROLLBACK;";
                    $result = mysqli_query($connection,$sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($connection,$sql);
                     
                    //after a lot of work, the query succeeded!
                    //echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
                    echo '<script>';
                    echo 'swal("You have successfully created a new topic", "You can view peoples comments", "success");';
                    echo 'setTimeout(function(){
                        window.location = "topic.php?id='. $topicid . '";
                    },3000);';

                    echo '</script>';
                }
            }
        }
    }
}
 
include 'footer.php';
?>