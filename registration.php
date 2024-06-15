
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Instagram</title>
</head>

<body style="background-color: #fafafa; height: 100vh; margin: 0px;">
    <div class="container" style="display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: center;
            align-items: center;">
        <div class="left" style="

            height: 700px;
            width: 430px;
            background-image: url(https://static.cdninstagram.com/images/instagram/xig/homepage/phones/home-phones.png?__makehaste_cache_breaker=HOgRclNOosk);
            background-repeat: no-repeat;">
            <img src="img/phone.png" alt="" style="position: relative; top: 28px; left: 155px;">
        </div>
        <div class="right">
            <form action="register.php" method="POST">
            <div style="display: flex;
                flex-direction: column;
                flex-wrap: nowrap;
                align-content: center;
                justify-content: center;
                align-items: stretch;
                width: 300px;
                background-color: white;
                border: 1px solid rgb(219, 219, 219);
                padding: 40px;
                margin: 20px;">
                <img src="img/ig-logo.png" alt="" style="padding: 0px 70px 30px 70px;">
                
                <input type="text" placeholder="Username" style="font-size: 12px"  id="username" name="username" required>
                <input type="text" placeholder="Name" style="font-size: 12px"  id="name" name="name" required>
                <input type="text" placeholder="Bio" style="font-size: 12px"  id="bio" name="bio" required>
                <input type="password" placeholder="Password" style="font-size: 12px" id="password" name="password" required>
                <input type="file" placeholder="Profile" style="font-size: 12px" id="profile" name="profile" required>
                <button type="submit" name="register">Register</button>
            </form>
                <div style="display: flex;
                    margin-top: 30px;
                    flex-direction: row;
                    align-items: center;">

                    <div style="background-color: rgb(219, 219, 219);
                            height: 1px;
                            width: 140px;">
                    </div>

                    <div style="font-weight: 600;
                    color: gray;
                    padding: 0px 20px 0px 20px;">
                        OR
                    </div>

                    <div style="background-color: rgb(219, 219, 219);
                            height: 1px;
                            width: 140px;
                            ">
                    </div>

                </div>

                <div
                    style="text-align: center; margin-top: 20px; color: rgb(56, 81, 133); font-weight: 600; font-size: 16px;">
                    <span style="
                    background-image: url(https://static.cdninstagram.com/rsrc.php/v3/y5/r/TJztmXpWTmS.png);
                    display: inline-block;
                    font-size: 100%;
                    margin-right: 8px;
                    position: relative;
                    top: 1px;
                    vertical-align: baseline;
                    background-repeat: no-repeat;
                    background-position: -414px -259px;
                    height: 16px;
                    width: 16px;
                    transform: scale(1);"
                    ></span>

                    <span>Log in with facebook</span>
                </div>
            </div>

            <div style="text-align: center;
                        width: 380px;
                        height: 45px;
                        background-color: white;
                        border: 1px solid rgb(219, 219, 219);
                        padding-top: 20px;
                        margin: 20px;
                        ">
                <span style="text-align: center;">
                    Have an account? <a href="login.php" style="color: rgba(0,149,246,1)">Log in</a>
                </span>
            </div>
            <div class="text-app" style="text-align: center; padding-bottom: 30px">Get the app.</div>
            <div class="app" style="text-align: center">
                <img src="img/googleplay.png" alt="" style="width: 150px">
                <img src="img/microsoft.png" alt="" style="width: 125px">
            </div>
        </div>
    </div>

    <footer>
        <div class="links">
        <ul>
            <li>Meta</li>
            <li>About</li>
            <li>Blog</li>
            <li>Jobs</li>
            <li>Help</li>
            <li>API</li>
            <li>Privacy</li>
            <li>Terms</li>
            <li>Locations</li>
            <li>Instagram Lites</li>
            <li>Threads</li>
            <li>Contact Uploading & Non-Users</li>
            <li>Meta Verified</li>
        </ul></div>

        <div class="copyright">
        © 2024 Instagram from Meta
        </div>
    </footer>
</body>

</html>     