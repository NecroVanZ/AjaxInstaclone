$(document).ready(function () {
    var modal = $("#myModal");
    var openModalLink = $("#createModalbtn");
    var notifmodal = $("#notifModal");
    var openNotifModaL = $("#notifModalbtn");
    var span = $(".close");
    notifmodal.hide();
    modal.hide();
    // Show modal on link click
    openModalLink.on("click", function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        modal.show();
    });
    openNotifModaL.on("click", function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        notifmodal.show();
    });

    // Close modal on close button click
    span.on("click", function () {
        modal.hide();
        notifmodal.hide();
    });

    // Close modal when clicking outside of it
    $(window).on("click", function (event) {
        if (event.target === modal[0]) {
            modal.hide();
        }
        if (event.target === notifmodal[0]) {
            notifmodal.hide();
        }
    });

    // Handle file upload preview
    var images = [];
    var imageIndex = 0;

    $('#file-upload').on('change', function (e) {
        images = e.target.files;
        previewImage();
    });

    $('#nextButton').on('click', function () {
        imageIndex = (imageIndex + 1) % images.length;
        previewImage();
    });

    function previewImage() {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#display_img').html('<img src="' + e.target.result + '">');
        };
        reader.readAsDataURL(images[imageIndex]);
    }

    // Submit upload form
    $('#upload_form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '../post.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                var result = JSON.parse(data);
                if (result.status === "success") {
                    window.location.href = 'index.php';
                    console.log(result.message);
                } else {
                    console.error("Error:", result.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Initialize the page
    followData();
    loadData();
    loadPost();
    fetchNotifications();
    countNotifications();
});

function loadData() {
    $.ajax({
        url: "../user_followed.php",
    }).done(function (result) {
        console.log(result);

        if (!result || result.error) {
            console.error("Error or no data:", result.error);
            return;
        }

        const template = document.querySelector("#stories-template");
        const parent = document.querySelector("#stories");
        if (!template || !parent) {
            console.error("Required DOM elements not found");
            return;
        }

        // Clear existing stories
        parent.innerHTML = "";

        result.forEach(item => {
            let clone = template.content.cloneNode(true);
            let sourceImage = document.createElement('img');
            sourceImage.src = "../img/" + item.profile;
            sourceImage.alt = item.username;
            sourceImage.style.cssText = "max-width: 70px; height: 70px; border-radius: 50%; object-fit: cover;";

            let avatarContainer = clone.querySelector(".avatar");
            if (avatarContainer) {
                avatarContainer.innerHTML = '';  // Clear any existing content
                avatarContainer.appendChild(sourceImage);  // Add the new circular image
            }

            let usernameElement = clone.querySelector(".username");
            if (usernameElement) {
                usernameElement.textContent = item.username;  // Add username, using textContent for safety
            }


            parent.appendChild(clone);
            // Add the cloned template to the parent container
        });
    }).fail(function (xhr, status, error) {

        console.error("AJAX request failed:", status, error);
    });
}

function followData() {
    $.ajax({
        url: "../user.php",
        type: "GET",
        dataType: "json"
    }).done(function (result) {
        console.log(result);
        const users = document.querySelector(".users");
        users.innerHTML = ""; // Clear previous user data

        if (Array.isArray(result) && result.length) {
            result.forEach(item => {

                let sourceImage = document.createElement('img');
                sourceImage.src = "../img/" + item.profile;
                sourceImage.alt = item.username;
                sourceImage.style.cssText = "max-width: 60px; height: 60px; border-radius: 50%; object-fit: cover;";

                let userContainer = document.createElement('div');
                userContainer.className = 'user-container';
                

                let name = document.createElement('div');
                name.className = 'name';
                name.dataset.userId = item.user_id
                name.addEventListener('click', function() {
                    window.location.href = 'user_profile.php?user_id=' + item.user_id;
                });

                let nameSpan = document.createElement('span');
                nameSpan.className = "username";
                nameSpan.textContent = item.username;


                let nameParagraph = document.createElement('p');
                nameParagraph.className = "subname";
                nameParagraph.textContent = item.name;

                let followBtn = document.createElement('button');

                // Check follow status for each user
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
                        loadData();
                    loadPost();
                    });
                    

                }).fail(function (error) {
                    console.error("Error checking follow status:", error);
                });

                // Append elements to the user container
                name.appendChild(nameSpan);
                name.appendChild(nameParagraph);
                userContainer.appendChild(sourceImage);
                userContainer.appendChild(name);
                userContainer.appendChild(followBtn);

                // Append the user container to the main 'users' container
                users.appendChild(userContainer);
            });
        } else {
            console.error("Received data is not an array or is empty");
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX request failed: " + textStatus + ' : ' + errorThrown);
    });
}

function loadPost() {
    $.ajax({
        url: "../postget1.php",
        type: "GET",
        dataType: "json"
    }).done(function (result) {
        const template = document.querySelector("#posts-template");
        const parent = document.querySelector("#posts-feed");
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
                if (item.likes > 0){
                    likescount.className='posts_likes';
                    likescount.textContent = item.likes + ' likes';
                } else{
                    likescount.className='posts_likes';
                    likescount.textContent ="";
                }
               

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
                                loadPost();
                            } else {
                                alert(response.error);
                            }
                        }).fail(function (error) {
                            console.error("Error updating like status:", error);
                            loadPost();
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
                postDesc.appendChild(likescount);
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
        console.log(response);
        const notificationContainer = document.querySelector('#count_notif');
        notificationContainer.innerHTML = '';

        let notificationElement = document.createElement('p');
        notificationElement.className = "count_notif";
        notificationElement.textContent = response.total_notifications;
        notificationContainer.appendChild(notificationElement);
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

        let totalNotificationElement = document.createElement('p');
        totalNotificationElement.className = "count_notif";
        totalNotificationElement.textContent = response.total_notifications;
        notificationContainer.appendChild(totalNotificationElement);

    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Failed to fetch notifications: " + textStatus + ' : ' + errorThrown);
    });
}
