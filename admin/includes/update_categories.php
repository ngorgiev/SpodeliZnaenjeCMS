<form action="" method="post">
    <div class="form-group">
        <label for="cat-title"> Edit Category</label>
        
        <?php
            if(isset($_SESSION['user_role']))
            {
                if($_SESSION['user_role'] == 'admin')
                {
                    if(isset($_GET['edit']))
                    {
                        $cat_id = $_GET['edit'];
                        $query = "SELECT * FROM categories WHERE cat_id= $cat_id ";
                        $select_categories_to_edit = mysqli_query($connection,$query); 

                        while($row = mysqli_fetch_assoc($select_categories_to_edit))
                        {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            ?>

                            <input value="<?php if(isset($cat_title)){echo $cat_title; } ?>" type="text" class="form-control" name="cat_title">

                        <?php 
                        }
                    }
                }
            } 
            ?>

            <?php 
                if(isset($_SESSION['user_role']))
                {
                    if($_SESSION['user_role'] == 'admin')
                    {
                        if(isset($_POST['update_category']))
                        {
                            $get_cat_title_to_edit = $_POST['cat_title'];
                            $query = "UPDATE categories SET cat_title = '{$get_cat_title_to_edit}' WHERE cat_id = {$cat_id} ";
                            $update_query = mysqli_query($connection,$query);

                            if(!$update_query)
                            {
                                die("QUERY FAILED" . mysqli_error($connection));
                            }
                        }
                    }
                }
            ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">   
    </div>  
</form>