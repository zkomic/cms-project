<br>
<small>New Post</small>
</h1>

<?php

if (isset($_POST['create_post'])) {

    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_user_id = $_POST['post_user_id'];
    $post_status = $_POST['post_status'];
    //image
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name']; //tmp location

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_tmp, "../images/$post_image"); //moving img from tmp location to ../images

    $query = "INSERT INTO posts(post_category_id, post_title, post_user_id, post_date, post_image, post_content, post_tags, post_status) ";
    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_user_id}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $new_post = mysqli_query($connection, $query);

    queryTest($new_post);

    //last id
    $p_id = mysqli_insert_id($connection);

    echo "
    <div class='alert alert-success'>
        Post created succesfully!<br>
        Click here to <a href='../post.php?p_id={$p_id}'> see post </a> or here to <a href='posts.php'> view all posts.</a>
    </div>";
}

?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" za file upload -->
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" required>
    </div>
    <!-- category dropdown -->
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

                echo "<option value='$cat_id'>{$cat_title}</option>";
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

                echo "<option value='$user_id'>{$user_firstname} {$user_lastname}</option>";
            }

            ?>

        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Status</label><br>
        <select name="post_status" id="post_status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    <div class="from-group">
        <label for="post_image">Image</label>
        <input type="file" name="post_image">
    </div>
    <br>
    <div class="form-group">
        <label for="post_tags">Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="post-group">
        <label for="post_content">Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10" required></textarea>
    </div>
    <br>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>