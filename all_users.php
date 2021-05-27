<?php include('./header.php');
include('./db/db.php');

if ($_SESSION['user_id'] == '' && $_SESSION['email'] == '') {
    header('Location:login.php');
    die();
}
$role_id = $_SESSION['role_id'];
$data = mysqli_query($con, "select role from roles where role_id = '$role_id'");
$role = mysqli_fetch_array($data)['role'];

if ($role !== 'admin') {
    header('Location:permission_error.php');
    die();
}

if (isset($_GET['action']) && $_GET['action'] == 'block') {
    $current_user_id = $_GET['user_id'];
    mysqli_query($con, "update users set block=1 where user_id='$current_user_id'");
}
if (isset($_GET['action']) && $_GET['action'] == 'unblock') {
    $current_user_id = $_GET['user_id'];
    mysqli_query($con, "update users set block=0 where user_id='$current_user_id'");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $current_user_id = $_GET['user_id'];
    $delete_comments = mysqli_query($con, "delete from comments where user_id='$current_user_id'");
    if ($delete_comments == 1) {
        $all_user_post = mysqli_query($con, "select * from posts where user_id = '$current_user_id'");
        for ($i = 0; $i < mysqli_num_rows($all_user_post); $i++) {
            $rows = mysqli_fetch_array($all_user_post);
            mysqli_query($con, "delete from comments where post_id='$rows[post_id]'");
        }

        $delete_posts = mysqli_query($con, "delete from posts where user_id='$current_user_id'");
        if ($delete_posts == 1) {
            mysqli_query($con, "delete from users where user_id='$current_user_id'");
        }
    }
    // 
    // 
}

?>

<div class="container">
    <div class="col-md-12">
        <div class="post-text">
            <h2>All Users</h2>
        </div>
        <table class="table">
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Gender</td>
                <td>Email</td>
                <td>Actions</td>
            </tr>

            <?php
            $email = $_SESSION['email'];
            $data = mysqli_query($con, "SELECT * FROM users");
            for ($i = 0; $i < mysqli_num_rows($data); $i++) {
                $rows = mysqli_fetch_array($data); ?>
                <tr>
                    <td><?php echo $rows['user_id']; ?></td>
                    <td><?php echo $rows['name']; ?></td>
                    <td><?php echo $rows['gender']; ?></td>
                    <td><?php echo $rows['email']; ?></td>
                    <td>
                        <?php
                        if ($rows['block'] == 0) { ?>
                            <a href="?user_id=<?php echo $rows['user_id']; ?>&action=block">Block User</a><br>
                        <?php } else { ?>
                            <a href="?user_id=<?php echo $rows['user_id']; ?>&action=unblock">Unblock User</a><br>
                        <?php }
                        ?>

                        <a href="?user_id=<?php echo $rows['user_id']; ?>&action=delete">Delete User</a><br>
                    </td>
                </tr>

            <?php
            }
            ?>
        </table>
    </div>
</div>

<?php include('./footer.php'); ?>