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

if (isset($_GET['action']) && $_GET['action'] == 'publish') {
    $current_post_id = $_GET['post_id'];
    mysqli_query($con, "update posts set published=1 where post_id='$current_post_id'");
}
if (isset($_GET['action']) && $_GET['action'] == 'draft') {
    $current_post_id = $_GET['post_id'];
    mysqli_query($con, "update posts set published=0 where post_id='$current_post_id'");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $current_post_id = $_GET['post_id'];
    mysqli_query($con, "delete from posts where post_id='$current_post_id'");
}

?>

<div class="container">
    <div class="col-md-12">
        <div class="tabs">

            <input type="radio" id="tab1" name="tab-control" checked>
            <input type="radio" id="tab2" name="tab-control">
            <input type="radio" id="tab3" name="tab-control">
            <input type="radio" id="tab4" name="tab-control">
            <ul>
                <li title="Features"><label for="tab1" role="button"><br><span>All Posts</span></label></li>
                <li title="Delivery Contents"><label for="tab2" role="button"><br><span>Published Posts</span></label></li>
                <li title="Shipping"><label for="tab3" role="button"><br><span>Draft Posts</span></label></li>
            </ul>

            <div class="slider">
                <div class="indicator"></div>
            </div>
            <div class="content">
                <section>
                    <table class="table">
                        <tr>
                            <td>Id</td>
                            <td>Post</td>
                            <td>Post Owner</td>
                            <td>Post Status</td>
                            <td>Actions</td>
                        </tr>

                        <?php
                        $email = $_SESSION['email'];
                        $data = mysqli_query($con, "SELECT * FROM posts");
                        if (mysqli_num_rows($data) == 0) {
                            $msg = "Now Posts";
                            echo "<tr>";
                            echo "<td>";
                            echo $msg;
                            echo "</td>";
                            echo "</tr>";
                        }
                        for ($i = 0; $i < mysqli_num_rows($data); $i++) {
                            $rows = mysqli_fetch_array($data); ?>
                            <tr>
                                <td><?php echo $rows[1]; ?></td>
                                <td><img src="./assets/img/<?php echo $rows[2]; ?>" width="100px" height="100px"></td>
                                <td><?php
                                    $user_id = $rows['user_id'];
                                    $user_name = mysqli_query($con, "select name from users where user_id = '$user_id'");
                                    $user_name = mysqli_fetch_array($user_name);
                                    echo $user_name['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['published'] == 0) {
                                        echo "Draft";
                                    } else {
                                        echo "Published";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['published'] == 0) { ?>
                                        <a href="?post_id=<?php echo $rows['post_id']; ?>&action=publish">Publish Post</a><br>
                                    <?php  } else { ?>
                                        <a href="?post_id=<?php echo $rows['post_id']; ?>&action=draft">Draft Post</a><br>
                                    <?php }
                                    ?>

                                    <a href="?post_id=<?php echo $rows['post_id']; ?>&action=delete">Delete Post</a><br>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </table>
                </section>
                <section>
                    <table class="table">
                        <tr>
                            <td>Id</td>
                            <td>Post</td>
                            <td>Post Owner</td>
                            <td>Post Status</td>
                            <td>Actions</td>
                        </tr>

                        <?php
                        $email = $_SESSION['email'];
                        $data = mysqli_query($con, "SELECT * FROM posts where published = 1");
                        if (mysqli_num_rows($data) == 0) {
                            $msg = "Now Published Posts";
                            echo "<tr>";
                            echo "<td>";
                            echo $msg;
                            echo "</td>";
                            echo "</tr>";
                        }
                        for ($i = 0; $i < mysqli_num_rows($data); $i++) {
                            $rows = mysqli_fetch_array($data); ?>
                            <tr>
                                <td><?php echo $rows[1]; ?></td>
                                <td><img src="./assets/img/<?php echo $rows[2]; ?>" width="100px" height="100px"></td>
                                <td><?php
                                    $user_id = $rows['user_id'];
                                    $user_name = mysqli_query($con, "select name from users where user_id = '$user_id'");
                                    $user_name = mysqli_fetch_array($user_name);
                                    echo $user_name['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['published'] == 0) {
                                        echo "Draft";
                                    } else {
                                        echo "Published";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['published'] == 0) { ?>
                                        <a href="?post_id=<?php echo $rows['post_id']; ?>&action=publish">Publish Post</a><br>
                                    <?php  } else { ?>
                                        <a href="?post_id=<?php echo $rows['post_id']; ?>&action=draft">Draft Post</a><br>
                                    <?php }
                                    ?>

                                    <a href="?post_id=<?php echo $rows['post_id']; ?>&action=delete">Delete Post</a><br>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </table>
                </section>
                <section>
                    <table class="table">
                        <tr>
                            <td>Id</td>
                            <td>Post</td>
                            <td>Post Owner</td>
                            <td>Post Status</td>
                            <td>Actions</td>
                        </tr>

                        <?php
                        $email = $_SESSION['email'];
                        $data = mysqli_query($con, "SELECT * FROM posts where published = 0");
                        if (mysqli_num_rows($data) == 0) {
                            $msg = "Now Dafted Posts";
                            echo "<tr>";
                            echo "<td>";
                            echo $msg;
                            echo "</td>";
                            echo "</tr>";
                        } ?>

                        <?php
                        for ($i = 0; $i < mysqli_num_rows($data); $i++) {
                            $rows = mysqli_fetch_array($data); ?>
                            <tr>
                                <td><?php echo $rows[1]; ?></td>
                                <td><img src="./assets/img/<?php echo $rows[2]; ?>" width="100px" height="100px"></td>
                                <td><?php
                                    $user_id = $rows['user_id'];
                                    $user_name = mysqli_query($con, "select name from users where user_id = '$user_id'");
                                    $user_name = mysqli_fetch_array($user_name);
                                    echo $user_name['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['published'] == 0) {
                                        echo "Draft";
                                    } else {
                                        echo "Published";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['published'] == 0) { ?>
                                        <a href="?post_id=<?php echo $rows['post_id']; ?>&action=publish">Publish Post</a><br>
                                    <?php  } else { ?>
                                        <a href="?post_id=<?php echo $rows['post_id']; ?>&action=draft">Draft Post</a><br>
                                    <?php }
                                    ?>

                                    <a href="?post_id=<?php echo $rows['post_id']; ?>&action=delete">Delete Post</a><br>
                                </td>
                            </tr>

                        <?php
                        }

                        ?>
                    </table>
                </section>
            </div>
        </div>

    </div>
</div>
<button id="send-btn">send</button>
<script>
    var btn = document.getElementById('send-btn');
    btn.addEventListener('click', () => {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'ajax.php?data=true', true);
        xhr.onload = () => {
            console.log(xhr.responseText);
        }
        xhr.send();
    })
</script>
<?php include('./footer.php'); ?>