<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php

        if (isset($_GET['edit'])) {

            $cat_id = $_GET['edit'];

            $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
            $edit_category = mysqli_query($connection, $query);

            queryTest($edit_category);

            while ($row = mysqli_fetch_assoc($edit_category)) {

                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

        ?>

                <input value="<?php if (isset($cat_title)) {
                                    echo $cat_title;
                                } ?>" class="form-control" type="text" name="cat_title">

        <?php
            }
        }
        ?>

        <?php
        // EDIT CATEGORY

        if (isset($_POST['edit'])) {

            $edit_cat_title = $_POST['cat_title'];

            $query = "UPDATE categories SET cat_title = '{$edit_cat_title}' WHERE cat_id = {$cat_id}";
            $update_category = mysqli_query($connection, $query);
            header("Location: categories.php");

            queryTest($update_category);
        }

        ?>

    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit" value="Update">
    </div>
</form>