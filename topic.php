<?php
//topic view
include'connect.php';
include'header.php';

    $sql = "SELECT
            topic_id,
            topic_subject
        FROM
            topics
        WHERE
            topics.topic_id = " . mysqli_real_escape_string($connection, $_GET['id']);

        $result = mysqli_query($connection, $sql);
        
        if(!$result)
        {
           // echo 'The topic could not be displayed, please try again later.';
            echo '<script>';
            echo 'swal("The topic could not be displayed,", "Please try again later.");';
            echo 'setTimeout(function(){
                window.location = "index.php";
            },3000);';

            echo '</script>';
        }
        else{
            if(mysqli_num_rows($result) == 0)
            {
               // echo 'This topic doesn`t exist.';
                echo '<script>';
                echo 'swal("This topic doesn`t exist.");';
                echo 'setTimeout(function(){
                    window.location = "index.php";
                },3000);';
                 echo '</script>';
            }
            else{
                while($row = mysqli_fetch_assoc($result))
                {
                    //display post data
                    echo '<div class="limiter">';
         echo '<div class="container-table100">';
         echo '<div class="wrap-table100">';
         echo '<div class="table">';
                   echo '<div class="row header"><div class="cell" data-title="Full Name">'.$row['topic_subject'].'</div><div class="cell" data-title="Location"></div></div>';
                    //fetch the post from the database
                    $posts_sql = "SELECT
                    posts.post_topic,
                    posts.post_content,
                    posts.post_date,
                    posts.post_by,
                    users.user_id,
                    users.user_name
                FROM
                    posts
                LEFT JOIN
                    users
                ON
                    posts.post_by = users.user_id
                WHERE
                    posts.post_topic = " . mysqli_real_escape_string($connection,$_GET['id']);

                    $posts_result = mysqli_query($connection,$posts_sql);

                    if(!$posts_result)
                    {
                        echo '<tr><td>The post could not be displayed, please try again later.</tr></td></table>';
                        // echo '<script>';
                        // echo 'swal("The post could not be displayed", "Please try again later");';
                        // echo 'setTimeout(function(){
                        //     window.location = "index.php";
                        // },3000);';
                        // echo '</script>';
                    }
                    else{
                        while($posts_row = mysqli_fetch_assoc($posts_result))
                        {
                             echo '<div class="row">';
                             echo '<div class="cell" data-title="Name" >'.$posts_row['user_name'].'<br/>Posted on '
                            . date('d-m-Y H:i', strtotime($posts_row['post_date'])).
                            '</div><div class="cell" data-title="Post">'.htmlentities(stripslashes($posts_row['post_content'])).'</div></div>';
                        }
                    }
                    if(!$_SESSION['signed_in'])
                    {
                        echo '<tr><td colspan="2">You must be <a href="signin.php">signed in</a> to post a reply. You can also <a href="signup.php">sign up</a> 
                        for an account.';
                
                    }
                    else{
                        //show reply box
                        echo '<form method="post" action="reply.php?id='.$row['topic_id'].'">
                        <center>Comment</center>
                        <div class="wrap-input100 validate-input">
                                <textarea name="reply-content" class="input100" placeholder="Post a comment"></textarea>
                                <span class="focus-input100"></span>
                                </div>
                                <div class="container-contact100-form-btn">
                                <button type="submit" class="contact100-form-btn">submit reply</button>
                                </div></form>';
                                
                    }

                    //finish the table
                    echo '</div>';
                }
            }
        }

           



include'footer.php';
?>