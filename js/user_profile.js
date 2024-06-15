$(document).ready(function() {
    user_post();
    fetchNotifications();
    countNotifications();
});

// Function to get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Get the user_id from URL
var userId = getUrlParameter('user_id');
console.log(userId);

function user_post() {
    $.ajax({
        url: "../get_user.php",
        type: "POST",
        dataType: "json",
        data: { user_id: userId }
    }).done(function (result) {
        console.log(result);

        if (Array.isArray(result) && result.length > 0) {
            result.forEach(item => {


                //USER DETAILS CONTAINER

                const profile = document.querySelector(".profile");
                profile.innerHTML = ""; // Clear previous user data

                let sourceImage = document.createElement('img');
                sourceImage.src = "../img/" + item.profile;
                sourceImage.alt = item.username;
                sourceImage.style.cssText = "max-width: 160px; height: 160px; border-radius: 50%; object-fit: cover;";


                let userProfile = document.createElement('div');
                userProfile.className = 'user_profile';

                let userDetails = document.createElement('div');
                userDetails.className = 'user_details';

                let userFollow = document.createElement('div');
                userDetails.className = 'user_follow';

                let nameSpan = document.createElement('span');
                nameSpan.className = "username";
                nameSpan.textContent = item.username;

                let followBtn = document.createElement('button');

                $.ajax({
                    url: "../check_follows1.php",
                    method: "POST",
                    data: { userId: item.user_id },
                    dataType: "json"
                }).done(function (isFollowing) {
                    if (isFollowing) {
                        followBtn.className = "following-button";
                        followBtn.textContent = "Following";
                    } else {
                        followBtn.className = "follow-button";
                        followBtn.textContent = "Follow";
                    }

                    // Handle follow/unfollow click for each button
                    followBtn.addEventListener("click", function () {
                        let isFollowing = followBtn.classList.contains("following-button");
                        let url = isFollowing ? "../unfollow.php" : "../follow.php";

                        $.ajax({
                            url: url,
                            method: "POST",
                            data: { userId: item.user_id },
                            dataType: "json"
                        }).done(function (response) {
                            if (response.success) {
                                if (isFollowing) {
                                    followBtn.className = "follow-button";
                                    followBtn.textContent = "Follow";
                                } else {
                                    followBtn.className = "following-button";
                                    followBtn.textContent = "Following";
                                }
                            } else {
                                alert(response.error); // Show error message if any
                            }
                        }).fail(function (error) {
                            console.error("Error updating follow status:", error);
                        });
                    });

                }).fail(function (error) {
                    console.error("Error checking follow status:", error);
                });
                
                
                let userFollowers = document.createElement('div');
                userFollowers.className = 'user_followers';

                let followers = document.createElement('span');
                followers.className = "followers";
                followers.textContent = item.follower_count + ' followers';

                let following = document.createElement('span');
                following.className = "followers";
                following.textContent = item.following_count + ' followings';

                let userBio = document.createElement('div');
                userBio.className = 'user_bio';

                let bio = document.createElement('span');
                bio.className = "bio";
                bio.textContent = item.bio;

                let userName = document.createElement('div');
                userName.className = 'user_name';

                let name = document.createElement('span');
                name.className = "name";
                name.textContent = item.name;


                userProfile.appendChild(sourceImage);

                userFollow.appendChild(nameSpan);
                userFollow.appendChild(followBtn); // Append followBtn here
                userFollowers.appendChild(followers);
                userFollowers.appendChild(following);
                userBio.appendChild(bio);
                userName.appendChild(name);

                
                userDetails.appendChild(userFollow);
                userDetails.appendChild(userFollowers);
                userDetails.appendChild(userBio);
                userDetails.appendChild(userName);

                profile.appendChild(userProfile);
                profile.appendChild(userDetails);


                // USER POSTS CONTAINER

                $.ajax({
                    url: "../postget.php",
                    type: "POST",
                    data: { user_id: userId },
                    dataType: "json"
                }).done(function (result) {
                    const template = document.querySelector("#posts-template");
                    const parent = document.querySelector("#user_post");
                    parent.innerHTML = "";
            
                    if (Array.isArray(result) && result.length) {
                        result.forEach(item => {
                            let clone = template.content.cloneNode(true);
                            let postHeader = clone.querySelector(".post_header");
                            let postPhoto = clone.querySelector(".photo");
                            let postDesc = clone.querySelector(".post_description");
            
                            let sourceImage = document.createElement('img');
                            sourceImage.src = "../img/" + item.profile;
                            sourceImage.alt = item.username;
                            sourceImage.style.cssText = "max-width: 30px; height: 30px; border-radius: 50%; object-fit: cover;";
            
                            let nameSpan = document.createElement('span');
                            nameSpan.className = "username";
                            nameSpan.textContent = item.username;
            
                            
            
                            let imagesContainer = document.createElement('div');
                            imagesContainer.className = 'images-container';
                            
                           
                            
            
                            if (Array.isArray(item.images) && item.images.length > 0) {
                                let images = item.images;
                                let imageIndex = 0;
                            
                                // Function to display the current image
                                function displayImage(index) {
                                    imagesContainer.innerHTML = ''; // Clear previous image
                                    let postImage = document.createElement('img');
                                    postImage.src = "../img/" + images[index];
                                    postImage.style.cssText = "max-width: 100%; height: auto;";
                                    imagesContainer.appendChild(postImage);
                                }
                            
                                // Initial display of the first image
                                displayImage(imageIndex);
                            
                                // Add event listener for the "Next" button
                                if (images.length > 1) {
                                    let nextButton = document.createElement('button');
                                    nextButton.textContent = 'Next';
                                    nextButton.addEventListener('click', function () {
                                        // Increment the image index
                                        imageIndex = (imageIndex + 1) % images.length;
                                        // Display the next image
                                        displayImage(imageIndex);
                                        imagesContainer.appendChild(nextButton);
                                    });imagesContainer.appendChild(nextButton);
                                    
                                }
                            } else {
                                // Handle case where item.images is undefined or empty
                                console.error('item.images is undefined or empty');
                            }
            
                            let heartIconSpan = document.createElement('span');
                            heartIconSpan.className = 'photo__icon';
                            let heartIcon = document.createElement('i');
                            let likescount = document.createElement('p');
            
                            // Set up initial state of heart icon
                            $.ajax({
                                url: "../check_likes.php",
                                method: "POST",
                                data: { postId: item.post_id },
                                dataType: "json"
                            }).done(function (result) {
                                if (result) {
                                    heartIcon.className = 'fa fa-heart heart-red fa-lg';
                                    heartIcon.id = 'heart-red';
                                } else {
                                    heartIcon.className = 'fa fa-heart-o heart fa-lg';
                                    heartIcon.id = 'heart';
                                }
            
                                // Handle follow/unfollow click
                                heartIcon.addEventListener("click", function () {
                                    let isLike = heartIcon.classList.contains("heart-red");
                                    let url = isLike ? "../unlike.php" : "../like.php";
            
                                    $.ajax({
                                        url: url,
                                        method: "POST",
                                        data: { postId: item.post_id },
                                        dataType: "json"
                                    }).done(function (response) {
                                        if (response.success) {
                                            if (isLike) {
                                                heartIcon.className = 'fa fa-heart-o heart fa-lg';
                                                heartIcon.id = 'heart';
                                            } else {
                                                heartIcon.className = 'fa fa-heart heart-red fa-lg';
                                                heartIcon.id = 'heart-red';
                                            }
                                        } else {
                                            alert(response.error);
                                        }
                                    }).fail(function (error) {
                                        console.error("Error updating like status:", error);
                                    });
                                });
                            }).fail(function (error) {
                                console.error("Error checking like status:", error);
                            });
            
                            heartIconSpan.appendChild(heartIcon);
            
                            let commentIconSpan = document.createElement('span');
                            commentIconSpan.className = 'photo__icon';
                            let commentIcon = document.createElement('i');
                            commentIcon.className = 'fa fa-comment-o fa-lg';
                            commentIconSpan.appendChild(commentIcon);
            
                            let caption = document.createElement('div');
                            caption.className = 'captionportion';
            
                            let usernameSpan = document.createElement('span');
                            usernameSpan.className = 'username';
                            usernameSpan.style.fontWeight = 'bold';
                            usernameSpan.textContent = item.username;
            
                            let captionSpan = document.createElement('span');
                            captionSpan.className = 'caption';
                            captionSpan.textContent = " " + item.caption;
            
                            caption.appendChild(usernameSpan);
                            caption.appendChild(captionSpan);
            
                            // Create elements for the comments
                            let commentSection = document.createElement('div');
                            commentSection.className = 'comment';
                            let postId = item.post_id;
                            $.ajax({
                                url: "../postcomment.php",
                                method: "POST",
                                data: { postId: postId },
                                dataType: "json"
                            }).done(function (response) {
                                if (Array.isArray(response) && response.length) {
                                    response.forEach(comment => {
                                        let commentDiv = document.createElement('div');
                                        commentDiv.className = 'comment-item';
                                        let commentuser = document.createElement('span');
                                        commentuser.className = 'username';
                                        let comments = document.createElement('span');
                                        comments.className = 'comments';
            
                                        commentuser.style.fontWeight = 'bold';
                                        commentuser.textContent = comment.username;
                                        comments.textContent = " " + comment.comment;
                                        commentDiv.appendChild(commentuser);
                                        commentDiv.appendChild(comments);
                                        commentSection.appendChild(commentDiv);
                                    });
                                }
                            }).fail(function (error) {
                                console.error("Error loading comments:", error);
                            });
            
                            let commentbox = document.createElement('div');
                            commentbox.className = "commentportion";
                            let commenttype = document.createElement('input');
                            commenttype.className = 'commenttype';
                            commenttype.type = 'text';
                            commenttype.placeholder = 'Add Comment';
                            let commentbtn = document.createElement('i');
                            commentbtn.className = "fa fa-paper-plane-o";
                            commentbox.appendChild(commenttype);
                            commentbox.appendChild(commentbtn);
            
                            
                            postHeader.appendChild(sourceImage);
                            postHeader.appendChild(nameSpan);
                           
                            postPhoto.appendChild(imagesContainer);
                            postDesc.appendChild(heartIconSpan);
                            postDesc.appendChild(commentIconSpan);
                            postDesc.appendChild(caption);
                            postDesc.appendChild(commentSection);
                            postDesc.appendChild(commentbox);
                            parent.appendChild(clone);
                        
                            commentbtn.addEventListener("click", function () {
                                let comment1 = commenttype.value;
                                $.ajax({
                                    url: "../sendcomment.php",
                                    method: "POST",
                                    data: { comment: comment1, postId: postId },
                                    dataType: "json"
                                }).done(function (response) {
                                    console.log('Comment submitted successfully:', response);
                                    commenttype.value = '';
                                    window.location.reload();
                                }).fail(function (jqXHR, textStatus, errorThrown) {
                                    console.error('Error submitting comment:', textStatus, errorThrown);
                                });;
                            })
                        });
                    } else {
                        console.error("Received data is not an array or is empty");
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX request failed: " + textStatus + ' : ' + errorThrown);
                });



            });
        } else {
            console.error("Received data is not an array or is empty");
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX request failed: " + textStatus + ' : ' + errorThrown);
    });
}


function fetchNotifications() {
    $.ajax({
        url: '../get_notifications.php',
        type: 'GET',
        dataType: 'json'
    }).done(function(notifications) {
        const notificationContainer = document.querySelector('.notification');
        notificationContainer.innerHTML = ''; // Clear previous notifications

        notifications.forEach(notification => {
            let message = '';

            switch (notification.type) {
                case 'like':
                    message = `${notification.username} likes your photo`;
                    break;
                case 'follow':
                    message = `${notification.username} followed you`;
                    break;
                case 'comment':
                    message = `${notification.username} commented on your photo`;
                    break;
            }

            let notificationElement = document.createElement('p');
            notificationElement.textContent = message;
            notificationContainer.appendChild(notificationElement);
        });
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Failed to fetch notifications: " + textStatus + ' : ' + errorThrown);
    });
}

function countNotifications() {
    $.ajax({
        url: '../count_notifications.php',
        type: 'GET',
        dataType: 'json'
    }).done(function(response) {
        const notificationContainer = document.querySelector('#notifModalbtn');
        notificationContainer.innerHTML = ''; // Clear previous content

        let notificationElement = document.createElement('p');
        notificationElement.textContent = response.total_notifications;
        notificationContainer.appendChild(notificationElement);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Failed to fetch notifications: " + textStatus + ' : ' + errorThrown);
    });
}

$(document).ready(function() {
    countNotifications();
});
