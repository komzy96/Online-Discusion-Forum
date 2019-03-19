
<?php
//create_cat.php
include 'connect.php';
include 'header.php';


$sql = "SELECT 
            categories.cat_id,
            categories.cat_name,
            categories.cat_description,
            COUNT(topics.topic_id) AS topics
        FROM
            categories
        LEFT JOIN 
            topics
        ON 
            topics.topic_id = categories.cat_id

        GROUP BY
            categories.cat_name,
            categories.cat_description,
            categories.cat_id";

$result = mysqli_query($connection, $sql);

if(!$result)
{
    //echo 'The categories could not be displayed, please try again later.';
    echo '<script>';
    echo 'swal("The categories could not be displayed,", "Please try again later.");';
    echo 'setTimeout(function(){
        window.location = "index.php";
    },3000);';

    echo '</script>';
}
else{
    if(mysqli_num_rows($result) == 0)
    {
       echo 'No categories defined yet';
        
    }
    else
    {
        //prepare the table
         echo '<div class="limiter">';
         echo '<div class="container-table100">';
         echo '<div class="wrap-table100">';
         echo '<div class="table">';
        echo '<div class="row header">';
        echo'<div class="cell">
                                Categories
                            </div>
                            <div class="cell">
                                Last Topics
                                </div>
                            </div>';



        while($row = mysqli_fetch_assoc($result))
        {
            echo '<div class="row">';
            echo '<div class = "cell" data-title="Category">';
            echo '<h2><a href="category.php?id='.$row['cat_id'].'">'.
            $row['cat_name'].'</a></h2>'.$row['cat_description'];
            echo '</div>';
            

            //fetch last topic for each cat
            $topicsql = "SELECT 
                            topic_id,
                            topic_subject,
                            topic_date,
                            topic_cat
                        FROM
                            topics
                        WHERE
                            topic_cat = " .$row['cat_id']."
                        ORDER BY
                             topic_date
                        DESC LIMIT 1";
            $topicresult = mysqli_query($connection, $topicsql);
                if(!$topicresult)
                {
                    echo '<center>Last topic could not be displayed.</center>';
                   
                }
                else{
                    if(mysqli_num_rows($topicresult) == 0)
                    {
                        echo '<center>No topics yet</center>';
                        
                    }
                    else
                    {
                        while($topicrow = mysqli_fetch_assoc($topicresult))
                        echo '<div class="cell" data-title="Last Topic"> <a href = "topic.php?id='.$topicrow['topic_id'].'">'.$topicrow['topic_subject'].'</a> at '. date('d-m-Y',
                        strtotime($topicrow['topic_date'])).'</div>';
                    }
                }
            echo '</div>';
            

                        
                        
        }
    }
}


?>