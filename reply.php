<?php
//create_cat.php
include 'connect.php';
include 'header.php';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    //echo 'This file cannot be called directly.';
    echo '<script>';
    echo 'swal("This file cannot be called directly.");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';
    echo '</script>';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        //echo 'You must be signed in to post a reply.';
        echo '<script>';
    echo 'swal("You must be signed in to post a reply.");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';
    echo '</script>';
    }
    else
    {
        //a real user posted a real reply
        $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by) 
                VALUES ('" . $_POST['reply-content'] . "',
                        NOW(),
                        " . mysql_real_escape_string($_GET['id']) . ",
                        " . $_SESSION['user_id'] . ")";
                         
        $result = mysqli_query($connection,$sql);
                         
        if(!$result)
        {
           // echo 'Your reply has not been saved, please try again later.';
            echo '<script>';
            echo 'swal("Your reply has not been saved.", "Please try again later");';
            echo 'setTimeout(function(){
                window.location = "index.php";
            },3000);';
        
            echo '</script>';
            
        }
        else
        {
            //echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
            echo '<script>';
            echo 'swal("Your reply has been saved", "Check out the topic.", "success");';
            echo 'setTimeout(function(){
                window.location = "topic.php?id=' . htmlentities($_GET['id']) . '";
            },3000);';

            echo '</script>';
        }
    }
}
 
include 'footer.php';
?>