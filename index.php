<?php
include('./db/db.php');
include('./header.php');
?>

<?php
$user_id = $_SESSION['user_id'];
$isBlock = mysqli_query($con, "select block from users where user_id = '$user_id'");
$isBlock = mysqli_fetch_array($isBlock);
if ($isBlock['block'] == 1) {
    header('Location:logout.php');
    die();
}

if (isset($_POST['submit'])) {
    $post = $_POST['post'];
    $image_name = $_FILES['img']['name'];
    $image_temporary_location = $_FILES['img']['tmp_name'];
    move_uploaded_file($image_temporary_location, "./assets/img/$image_name");
    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($con, "insert into posts value('', '$post', '$image_name', 0, $user_id);");
    $msg = "Thanks We will Review You Post";
}

if ($_SESSION['user_id'] == '' && $_SESSION['email'] == '') {
    header('Location:login.php');
    die();
}
?>
<div class="container-fluid post">
    <div class="side1">
        <div class="profile-view">
            <div class="cover-profile">

            </div>
            <div class="profile-img"></div>
            <div class="profile-info">
                <?php
                $user_name_for_profile = mysqli_query($con, "SELECT name FROM users WHERE user_id = '$user_id'");
                $user_name_for_profile = mysqli_fetch_array($user_name_for_profile)['name'];
                ?>
                <h4><?php echo $user_name_for_profile ?></h4>
            </div>
        </div>
    </div>
    <div class="side-2">
        <div class="">
            <div class="post-text">
                <h4>Write a Post</h4>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <textarea placeholder="Write a Post" name="post" class="form-control"></textarea>
                <label for="">Upload an image</label>
                <input type="file" name="img" id="" class="form-control">
                <input type="submit" value="Post" name="submit" class="btn btn-primary">
            </form>
            <?php
            if (isset($msg)) { ?>
                <div class="msg-alert">
                    <p><?php echo $msg ?></p>
                </div>
            <?php  }
            ?>
        </div>


        <div class="">
            <div class="post-text">
                <h4>News Feed</h4>
            </div>
            <?php
            $email = $_SESSION['email'];
            $data = mysqli_query($con, "SELECT * FROM posts WHERE published = 1 order by post_id DESC");
            for ($i = 0; $i < mysqli_num_rows($data); $i++) {
                $rows = mysqli_fetch_array($data);
                $user_name = mysqli_query($con, "SELECT name FROM users WHERE user_id = '$rows[user_id]'");
                $user_name = mysqli_fetch_array($user_name);
            ?>

                <div class="post-div">
                    <div class="post-img-sec">
                        <div></div>
                        <p class="post-name"><span><?php echo $user_name['name'] ?></span></p>
                    </div>

                    <p><?php echo $rows[1]; ?></p>
                    <img src="./assets/img/<?php echo $rows[2]; ?>">
                    <div class="comments">
                        <?php
                        $post_id = $rows['post_id'];
                        $comments = mysqli_query($con, "select * from comments where post_id = '$post_id'");
                        for ($j = 0; $j < mysqli_num_rows($comments); $j++) {
                            $comments_data = mysqli_fetch_array($comments); ?>
                            <div id="comment-body-<?php echo $rows['post_id'] ?>">
                                <?php
                                $get_user_name = mysqli_query($con, "select name from users where user_id = '$comments_data[user_id]'");
                                $get_user_name = mysqli_fetch_array($get_user_name)['name'];
                                ?>
                                <div class="user-comment">
                                    <div class="comment-user-image">
                                        <div></div>
                                        <h4><?php echo $get_user_name ?></h4>
                                    </div>

                                    <p><?php echo $comments_data['comment_text'] ?></p>
                                </div>

                            </div>
                        <?php }
                        ?>
                        <div class="comment_form">
                            <form onsubmit="handleCommentsData(event, <?php echo $rows['post_id'] ?>, <?php echo $user_id ?>)">
                                <textarea name="" id="comment-text-<?php echo $rows['post_id'] ?>" cols="30" rows="10" class="" placeholder="Comment Here"></textarea><br>
                                <button type="submit" class="btn btn-primary">Comment</button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="side-3">
        <?php
        $all_users = mysqli_query($con, "select * from users");
        for ($i = 0; $i < mysqli_num_rows($all_users); $i++) {
            $users = mysqli_fetch_array($all_users); ?>
            <div class="user-box">
                <div class="user-img"></div>
                <p><?php echo $users['name'] ?></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis aliquam, perferendis</p>
            </div>
        <?php }
        ?>
    </div>
</div>

<script>
    function handleCommentsData(e, post_id, user_id) {
        e.preventDefault();
        let comment_text = document.getElementById(`comment-text-${post_id}`).value;
        let commentBody = document.getElementById(`comment-body-${post_id}`);
        const post_data = {
            post_id: post_id,
            comment: comment_text,
            user_id: user_id
        }
        var xhr = new XMLHttpRequest();

        let urlEncodedData = "";
        urlEncodedDataPairs = [];
        name;

        for (name in post_data) {
            urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(post_data[name]));
        }

        urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');

        xhr.open('POST', 'ajax.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = () => {
            data = xhr.responseText;
            console.log(data);
            location.reload();
        }
        xhr.send(urlEncodedData);
    }
</script>

<?php include('./footer.php') ?>