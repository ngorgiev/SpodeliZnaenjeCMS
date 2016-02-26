<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>To Admin</th>
            <th>To Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
<tbody>
    <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection,$query); 

        while($row = mysqli_fetch_assoc($select_users))
        {
            $user_id = $row['user_id'];
            $username= $row['username']; 
            $user_password = $row['user_password']; 
            $user_firstname = $row['user_firstname']; 
            $user_lastname = $row['user_lastname']; 
            $user_email = $row['user_email']; 
            $user_image = $row['user_image']; 
            $user_role = $row['user_role']; 

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
           
//            $query = "SELECT * FROM comments";
//            $select_comments = mysqli_query($connection,$query); 
//
//            while($row = mysqli_fetch_assoc($select_comments))
//            {
//                $cat_id = $row['cat_id'];
//                $cat_title = $row['cat_title'];    
//            }
            
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            
//            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
//            
//            $select_post_id_query = mysqli_query($connection, $query);
//            
//            $num_rows = mysqli_num_rows($select_post_id_query);
//            if($num_rows > 0)
//            {
//                while($row = mysqli_fetch_assoc($select_post_id_query))
//                {
//                    $post_id = $row['post_id']; 
//                    $post_title = $row['post_title'];
//                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
//                }  
//            }
//            else
//            {
//                echo "<td>Related Post Removed</td>";
//            }

            echo "<td><a href='users.php?change_to_admin={$user_id}'>As Admin</a></td>";
            echo "<td><a href='users.php?change_to_sub={$user_id}'>As Subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }
    ?>

</tbody>
</table>

<?php
    if(isset($_GET['change_to_admin']))
    {
        $get_user_id = $_GET['change_to_admin'];
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $get_user_id";

        $change_to_admin_query = mysqli_query($connection, $query);

        header("Location: users.php");
    }

    if(isset($_GET['change_to_sub']))
    {
        $get_user_id = $_GET['change_to_sub'];
        $query = "UPDATE users SET user_role = 'subsriber' WHERE user_id = $get_user_id";

        $change_to_sub_query = mysqli_query($connection, $query);

        header("Location: users.php");
    }

    if(isset($_GET['delete']))
    {
        $get_user_id = $_GET['delete'];
        $query = "DELETE FROM users WHERE user_id = {$get_user_id}";
        
        $delete_query = mysqli_query($connection, $query);
        
        header("Location: users.php");
    }
?>