<?php
include('./header.php');
include('./db/db.php');


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $data = mysqli_query($con, "select user_id, role_id from users where email = '$email' and password = '$password' and block = 0");
    $user_data = mysqli_fetch_array($data);
    print_r($user_data);
    $user_id = $user_data['user_id'];
    $role_id = $user_data['role_id'];

    $row_count = mysqli_num_rows($data);


    if ($row_count > 0) {
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role_id'] = $role_id;
        $_SESSION['authenticated'] = true;
        header('Location:index.php');
        die();
    } else {
        $msg = "User not Found";
    }
}
if (isset($_SESSION['email']) && isset($_SESSION['user_id'])) {
    header('Location:index.php');
    die();
}
?>





<div class="container login">
    <div class="col-md-12">
        <?php
        if (isset($msg)) { ?>
            <div class="msg-danger-alert">
                <span><?php echo $msg ?></span>
            </div>
        <?php  }
        ?>

        <h1>Sign in</h1>
        <p>Sign into your Account</p>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" id="" placeholder="Enter Your email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" id="" placeholder="Enter Your Password">
            </div>
            <input type="submit" value="Login" name="submit" class="btn btn-primary">
        </form>
    </div>
</div>

<?php include('./footer.php') ?>