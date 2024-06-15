<?php
session_start();
if (!isset($_SESSION['USER'])) {
    // If the USER session variable isn't set, redirect to the login page
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../index.css">
    <title>Instagram</title>
</head>

<body>

    <div class="container">

        <section class="sidebar col-2 side">
            <?php include("../sidebar/sidebar.php") ?>
        </section>

        <section class="main col-6">
            <div class="stories" id="stories">
                <div id="userId" data-user-id="<?php echo htmlspecialchars($_SESSION['USER']['user_id']); ?>"></div>
            </div>

            <template id="stories-template">
                <div class="user-stories">
                    <div class="avatar">

                    </div>
                    <div class="username">

                    </div>
                </div>
            </template>


            <div class="posts-feed" id="posts-feed">
                
            </div>

            <template id="posts-template">
                <div class="posts-container">
                    <div class="post_header">

                    </div>
                    <div class="photo">

                    </div>
                    <div class="post_description">

                    </div>
                </div>
            </template>
        </section>

        <section class="people col-4">
            <div class="up">
                <div class="user">
                    <img src="../img/<?php echo $_SESSION['USER']['profile'] ?>" alt="asdfasdf" style="max-width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                    <div class="name">
                        <span><?php echo $_SESSION['USER']['username'] ?></span>
                        <p class="subname"><?php echo $_SESSION['USER']['name'] ?></p>
                    </div>

                    <div class="logout">
                        <a href="../logout.php">Logout</a>
                    </div>
                </div>

            </div>
            <div class="mid">
                Suggested for you
                <p class="seeall">See All</p>
            </div>
            <div class="follow_people">
                <div class="users">

                </div>

            </div>

            <div class="toastbox" id="toastbox">
                <span>adsfadsfasdfasdfasdfasdfadsfasdfasdfadsfasdfasdf</span>
                <h2>dfgdfgdfgdfgdfg</h2>
            </div>
        </section>

        <?php include("../modal.php"); ?>
        <?php include("notif.php"); ?>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="../js/index.js"></script>
</body>

</html>