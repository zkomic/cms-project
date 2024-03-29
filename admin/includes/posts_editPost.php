<br>
<small>Edit Post</small>
</h1>

<?php

if (isset($_GET['p_id'])) {

    $p_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = {$p_id}";
$edit_post = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($edit_post)) {

    $post_id = $row['post_id'];
    $post_user_id = $row['post_user_id'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
}

if (isset($_POST['submit'])) {

    $post_user_id = $_POST['post_user_id'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id']; //$_POST['post_category']
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];

    move_uploaded_file($post_image_tmp, "../images/$post_image");

    // fetch image from db so that is not empty after editing
    if (empty($post_image)) {

        $query = "SELECT * FROM posts WHERE post_id = {$p_id} ";
        $fetch_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($fetch_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_user_id = '{$post_user_id}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$p_id} ";

    $update_post = mysqli_query($connection, $query);
    queryTest($update_post);

    echo "
    <div class='alert alert-success'>
        Post updated succesfully!<br>
        Click here for <a href='../post.php?p_id={$p_id}'> edited post </a> or here to <a href='posts.php'> edit other posts.</a>
    </div>";
}

?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" za file upload -->
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>" required>
    </div>


    <div class="form-group">
        <label for="post_category_id">Category Id</label><br>
        <select name="post_category_id" id="post_category_id">

            <?php

            $query = "SELECT * FROM categories";
            $all_categories = mysqli_query($connection, $query);

            queryTest($all_categories);

            while ($row = mysqli_fetch_assoc($all_categories)) {

                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                switch ($post_category_id) {
                    case $cat_id:
                        echo "<option value='$cat_id' selected='selected' >{$cat_title}</option>";
                        break;
                    default:
                        echo "<option value='$cat_id'>{$cat_title}</option>";
                        break;
                }
            }

            ?>

        </select>
    </div>


    <div class="form-group">
        <label for="post_user_id">Author</label><br>
        <select name="post_user_id" id="post_user_id" lass="form-control">

            <?php

            $query = "SELECT * FROM users WHERE user_role = 'admin'";
            $users = mysqli_query($connection, $query);
            queryTest($users);

            while ($row = mysqli_fetch_assoc($users)) {

                $user_id = $row['user_id'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];

                switch ($post_user_id) {
                    case $user_id:
                        echo "<option value='$user_id' selected='selected' >$user_firstname $user_lastname</option>";
                        break;
                    default:
                        echo "<option value='$user_id'>$user_firstname $user_lastname</option>";
                        break;
                }
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Status</label><br>
        <select name="post_status" id="post_status">

            <?php

            if ($post_status == 'draft') {

                echo "<option value='draft' selected='selected'>Draft</option>";
                echo "<option value='published'>Published</option>";
            } else {

                echo "<option value='published' selected='selected'>Published</option>";
                echo "<option value='draft' >Draft</option>";
            }

            ?>

        </select>
    </div>
    <div class="form-group">
        <div class="from-group">
            <label for="post_image">Image</label><br>
            <img width=200 src="../images/<?php echo imagePlaceholder($post_image); ?>" alt=""><br><br>
            <input type="file" name="post_image">
        </div>
        <br>
        <div class="form-group">
            <label for="post_tags">Tags</label>
            <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
        </div>
        <div class="post-group">
            <label for="post_content">Content</label>
            <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10" required><?php echo $post_content; ?></textarea>
        </div>
        <br>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Update Post">
        </div>
</form>