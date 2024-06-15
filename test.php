<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
  <link rel="stylesheet" href="style.css">

    <style>
      .follow-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
      }
      .following-button {
        background-color: #ccc;
        color: #333;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
      }
    </style>
  </head>
  <body>


  <div class="photo__icons">
                        <span class="photo__icon">
                            <i class="fa fa-heart-o heart fa-lg"></i>dfsgdsfg
                        </span>
                        <span class="photo__icon">
                            <i class="fa fa-comment-o fa-lg"></i>sdfgdsfg
                        </span>
                    </div>
                </div>
    <button id="follow-button" class="follow-button">Follow</button>

    <script>
      const followButton = document.getElementById("follow-button");
      let isFollowing = false;

      followButton.addEventListener("click", () => {
        isFollowing = !isFollowing;
        followButton.classList.toggle("following-button", isFollowing);
        followButton.classList.toggle("follow-button", !isFollowing);
        followButton.textContent = isFollowing ? "Following" : "Follow";
      });
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
  </body>
</html>