<?php
include('./header.php');
include('./db/db.php');

if (isset($_SESSION['email']) && isset($_SESSION['user_id'])) {
    header('Location:index.php');
    die();
}


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($name == '') {
        $msg['name'] = "Name field should not be Empty";
    }
    if ($email == '') {
        $msg['email'] = "Email field should not be Empty";
    }
    if ($password == '') {
        $msg['password'] = "Password field should not be Empty";
    }
    if ($confirm_password == '') {
        $msg['confirm_password'] = "Confirm Passord field should not be Empty";
    }
    if ($gender == '') {
        $msg['gender'] = "Gender field should not be Empty";
    }

    if ($password !== $confirm_password) {
        $msg['match'] = 'Password do not match';
    }
    if (!isset($msg)) {
        mysqli_query($con, "insert into users value('', '$name', '$email', '$password', '$gender', 2,  0)");
        header('Location:login.php');
        die();
    }
}



?>





<div class="container login">
    <div class="col-md-12">
        <h1>Sign up</h1>
        <p>Create Your Account Now</p>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" id="" placeholder="Enter Your email">
                <small><?php echo isset($msg['name']) ? $msg['name'] : '' ?></small>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" id="" placeholder="Enter Your email">
                <small><?php echo isset($msg['email']) ? $msg['email'] : '' ?></small>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" id="" class="form-control">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <small><?php echo isset($msg['gender']) ? $msg['gender'] : '' ?></small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" id="" placeholder="Enter Your Password">
                <small><?php echo isset($msg['password']) ? $msg['name'] : '' ?></small>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" id="" placeholder="Re-Enter Your Password">
                <small><?php echo isset($msg['confirm_password']) ? $msg['confirm_password'] : '' ?></small>
                <small><?php echo isset($msg['match']) ? $msg['match'] : '' ?></small>
            </div>
            <input type="submit" value="Sign Up" name="submit" class="btn btn-primary">
        </form>
    </div>
</div>

<?php include('./footer.php'); ?>