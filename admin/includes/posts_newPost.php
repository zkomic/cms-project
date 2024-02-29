<?php

if (isset($_POST['create_post'])) {

    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['post_author'];
    $post_status = $_POST['post_status'];
    //image
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name']; //tmp location

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_tmp, "../images/$post_image"); //moving img from tmp location to ../images

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $new_post = mysqli_query($connection, $query);

    queryTest($new_post);
    header("Location: posts.php");
}

?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" za file upload -->
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
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
        <label for="post_author">Author</label>
        <input type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_status">Status</label>
        <input type="text" class="form-control" name="post_status">
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
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>
    <br>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>