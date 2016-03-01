<?php
    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'admin')
        {
            include("delete_modal.php");
            if(isset($_POST['checkBoxArray']))
            {
                foreach ($_POST['checkBoxArray'] as $postValueId) 
                {
                    $postValueId = mysqli_real_escape_string($connection, $postValueId);
                    $bulk_options = $_POST['bulk_options'];

                    switch ($bulk_options) {
                        case 'approved':
                            $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = '{$postValueId}'";
                            $update_to_approved_status = mysqli_query($connection, $query);
                            confirmQuery($update_to_approved_status);
                            break;
                        case 'unapproved':
                            $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = '{$postValueId}'";
                            $update_to_unapproved_status = mysqli_query($connection, $query);
                            confirmQuery($update_to_unapproved_status);
                            break;
                       case 'delete':
                            $query = "DELETE FROM comments WHERE comment_id = '{$postValueId}'";
                            $update_to_delete_status = mysqli_query($connection, $query);
                            confirmQuery($update_to_delete_status);
                            break;
                    }
                }
                header("Location: comments.php");
            }
        }
    }
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
    <div id="bulkOptionContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Option</option>
            <option value="approved">Approve</option>
            <option value="unapproved">Unapprove</option>
            <option value="delete">Delete</option>
        </select>
    </div>

    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply"></input>
    </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
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
                $query = "SELECT * FROM comments";
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
                    ?>

                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>'></td>

                    <?php
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
                    // echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
                    echo "<td><a rel='$comment_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</form>
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

<script> 
    $(document).ready(function()
    {
        $(".delete_link").on('click', function()
        {
            var id = $(this).attr("rel");
            var delete_url = "comments.php?delete=" + id +"";
            
            $(".modal_delete_link").attr("href", delete_url);

            $("#myModal").modal('show');
        });
    });
</script>