<?php
include('./db/db.php');

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
    mysqli_query($con, "insert into comments value('', '$comment', 5, '$post_id', '$user_id')");

    // $data = mysqli_query($con, "select * from comments where post_id = '$post_id'");
    // echo json_encode(mysqli_fetch_all($data));
}
