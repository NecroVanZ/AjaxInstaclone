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
    <link rel="stylesheet" href="../user_profile.css">
    <title>Instagram</title>
</head>

<body>

    <div class="container">

        <section class="sidebar col-2 side">
            <?php include("../sidebar/sidebar.php") ?>
        </section>

        <section class="user_profile col-6">
            <div class="profile">
                
            </div>
            <div class="user_post" id="user_post">

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

        <?php include("../notif.php"); ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="../js/index.js"></script> -->
    <script src="../js/user_profile.js"></script>
</body>

</html>