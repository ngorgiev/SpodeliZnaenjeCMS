<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approved</th>
            <th>Unapproved</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']) ;
            $select_posts = mysqli_query($connection,$query); 

            while($row = mysqli_fetch_assoc($select_posts))
            {
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id']; 
                $comment_author = $row['comment_author']; 
                $comment_content = $row['comment_content']; 
                $comment_email = $row['comment_email']; 
                $comment_status = $row['comment_status']; 
                $comment_date = $row['comment_date']; 

                echo "<tr>";
                echo "<td>{$comment_id}</td>";
                echo "<td>{$comment_author}</td>";
                echo "<td>{$comment_content}</td>";

                echo "<td>{$comment_email}</td>";
                echo "<td>{$comment_status}</td>";

                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";

                $select_post_id_query = mysqli_query($connection, $query);

                $num_rows = mysqli_num_rows($select_post_id_query);
                if($num_rows > 0)
                {
                    while($row = mysqli_fetch_assoc($select_post_id_query))
                    {
                        $post_id = $row['post_id']; 
                        $post_title = $row['post_title'];
                        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                    }  
                }
                else
                {
                    echo "<td>Related Post Removed</td>";
                }
                
                echo "<td>{$comment_date}</td>";

                echo "<td><a href='comments.php?aprove=$comment_id'>Approve</a></td>";
                echo "<td><a href='comments.php?unaprove=$comment_id'>Unapprove</a></td>";
                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?')\" href='comments.php?delete=$comment_id'>Delete</a></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<?php
    if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'admin')
            {
                if(isset($_GET['aprove']))
                {
                    $get_comment_id = mysqli_real_escape_string($connection,$_GET['aprove']);
                    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $get_comment_id";

                    $aprove_comment_query = mysqli_query($connection, $query);

                    header("Location: comments.php");
                }

                if(isset($_GET['unaprove']))
                {
                    $get_comment_id = mysqli_real_escape_string($connection,$_GET['unaprove']);
                    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $get_comment_id";

                    $unaprove_comment_query = mysqli_query($connection, $query);
                    header("Location: comments.php");
                }

                if(isset($_GET['delete']))
                {
                    $get_comment_id = mysqli_real_escape_string($connection,$_GET['delete']);
                    $query = "DELETE FROM comments WHERE comment_id = {$get_comment_id}";
                    
                    $delete_query = mysqli_query($connection, $query);
                    
                    header("Location: comments.php");
                }
            }
        }
?>