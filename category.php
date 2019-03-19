<?php
//category.php
include 'connect.php';
include 'header.php';
//first select the category based on $_GET['cat_id']
//$id = (isset($_POST['id']) ? $_POST['id'] : '');

$sql = "SELECT
            cat_id,
            cat_name
        FROM
            categories
        WHERE
            categories.cat_id = " . mysqli_real_escape_string($connection, $_GET['id']);

$categories_result = mysqli_query($connection,$sql);


$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = " . mysqli_real_escape_string($connection, $_GET['id']);
 
$result = mysqli_query($connection, $sql);
 
if(!$result)
{
   // echo 'The category could not be displayed, please try again later.' . mysqli_error($connection);
    echo '<script>';
    echo 'swal("The category could not be displayed,", "Please try again later.");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';
    echo '</script>' . mysqli_error($connection);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
       // echo 'This category does not exist.';
        echo '<script>';
    echo 'swal("This category does not exist.");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';
    echo '</script>';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            //echo '<h2>Topics in ' . $row['cat_name'] . ' category</h2>';
        }
     
        //do a query for the topics
        $sql = "SELECT  
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . mysqli_real_escape_string($connection, $_GET['id']);
         
        $result = mysqli_query($connection, $sql);
         
        if(!$result)
        {
            //echo 'The topics could not be displayed, please try again later.';
            echo '<script>';
            echo 'swal("The topics could not be displayed.", "Please try again");';
            echo 'setTimeout(function(){
                window.location = "index.php";
            },3000);';
            echo '</script>';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
               // echo 'There are no topics in this category yet.';
                echo '<script>';
                echo 'swal("There are no topics in this category yet.");';
                echo 'setTimeout(function(){
                    window.location = "index.php";
                },3000);';
                echo '</script>';
                
            }
            else
            {
                $categories_row = mysqli_fetch_assoc($categories_result);
                //prepare the table
                echo  '<div class="limiter">';
         echo '<div class="container-table100">';
         echo '<div class="wrap-table100">';
         echo '<div class="table">';
        echo '<div class="row header">';
        echo'<div class="cell">
                            Topic
                            </div>
                            <div class="cell">'.$categories_row['cat_name'].'</div>
                            <div class="cell">
                                Created at
                                </div>
                            </div>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {               
                    echo '<div class="row">';
            echo '<div class = "cell" data-title="topic">';
                            echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                        echo '</div>';
                        echo '<div class = "cell"></div>';
                        echo '<div class = "cell" data-title="created at">';        
                            echo date('d-m-Y', strtotime($row['topic_date']));
                        echo '</div></div>';
                    
                }
            }
        }
    }
}
 
//include 'footer.php';
?>