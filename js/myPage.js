function editAbout(button) {
    button.style.display = 'none';
    document.getElementById('submitAbout').style.display = 'inline-block';
    document.getElementById('about').removeAttribute('readonly');
}

function likePost(el, postId) {
    let obj = {
        postId: postId,
    };

    // Send the request to the server side code
    sendRequest(obj, '../server/like_post.php', displayAlert);

    el.textContent = el.textContent == 'Like' ? 'Unlike' : 'Like';
}

function archivePost(el, postId) {
    let obj = {
        postId: postId,
    };

    // Send the request to the server side code
    sendRequest(obj, '../server/archive_post.php', displayAlert);

    el.textContent = el.textContent == 'Archive' ? 'Unarchive' : 'Archive';
}

function commentPost(postId) {
    let obj = {
        postId: postId,
    };

    sendRequest(obj, '../server/fetch_comments_post.php', createCommentModal);
}

function createElementFromHTML(htmlString) {
    let div = document.createElement('div');
    div.innerHTML = htmlString.trim();

    return div.firstChild;
}

function displayAlert(res) {
    let existingAlert = document.getElementById('alert');
    if (existingAlert) {
        document.body.removeChild(existingAlert);
    }

    let alert = createElementFromHTML(res);
    document.body.append(alert);
}

function sendRequest(obj, url, cb) {
    $.ajax({
        url: url,
        type: 'POST',
        data: obj,
        success: function (response) {
            console.log(response);
            cb(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            if (xhr.status == 200) {
                alert(ajaxOptions);
            } else {
                alert(xhr.status);
                alert(thrownError);
            }
        },
    });
}

function createCommentModal(serverResponse) {
    let payload = JSON.parse(serverResponse);

    let postInfo = payload.postInfo;
    let comments = payload.comments;
    let photos = payload.photos;

    let commentDivs = '';

    for (let i = 0; i < comments.length; i++) {
        let comment = `
            <div class="modal-comment">
                <span class="delete-post" onclick="deleteComment(this,${comments[i]['id']})">&times;</span>
                <div class="modal-comment-image">
                    <img src="${comments[i]['img_path']}" />
                </div>
                <div class="modal-comment-body">
                    <a href="./user.php?id=${comments[i]['id_user']}">${comments[i]['username']}</a>
                    <p>${comments[i]['comment']}</p>
                </div>
            </div>
        `;

        commentDivs += comment;
    }

    let photosContainer = '<div class="post-photos-container">';

    for (let i = 0; i < photos.length; i++) {
        let photo = `
            <img src="${photos[i]['photo_path']}" onclick="previewPhoto(this)" />
        `;

        photosContainer += photo;
    }

    photosContainer += '</div>';

    let modal = `
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="document.getElementById('modal').remove();">&times;</span>
            <div class="modal-post">
                <div class="modal-post-image">
                    <img src="${postInfo['img_path']}" />
                </div>
                <div class="modal-post-body">
                    <a href="./user.php?id=${postInfo['id_user']}">${postInfo['username']}</a>
                    <p>${postInfo['post']}</p>
                    ${photosContainer}
                    <div class="modal-post-body-footer">
                        <p><span>${postInfo['likes']} Likes</span> . <span>${postInfo['comments']} Comments</span></p>
                    </div>
                </div>
            </div>
            <div class="modal-comments-container">
                ${commentDivs}
            </div>
            <form action="" method="POST" class="modal-add-comment">
                <input type="hidden" name="postId" id="postId" value="${postInfo['id']}"/>
                <textarea name="comment" id="comment" maxlength="400" placeholder="Add a comment" required></textarea>
                <input type="submit" name="submitComment" id="submitComment" value="SUBMIT"/>
            </form>
        </div>
    </div>
    `;

    let modalElement = createElementFromHTML(modal);

    document.body.append(modalElement);
}

function showPhotosPreview(e, input) {
    document.getElementById('photosPreview').textContent =
        input.files.length + ' photos added';
}

function previewPhoto(img) {
    window.open(img.src);
}

function deleteComment(span, commentId) {
    let obj = {
        commentId: commentId,
    };

    $.ajax({
        url: '../server/delete_comment.php',
        type: 'POST',
        data: obj,
        success: function (response) {
            console.log(response);
            let res = JSON.parse(response);
            if (res.allow == 'true') {
                span.parentElement.remove();
            }
            displayAlert(res.alert);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            if (xhr.status == 200) {
                alert(ajaxOptions);
            } else {
                alert(xhr.status);
                alert(thrownError);
            }
        },
    });
}

function deletePost(span, postId) {
    let obj = {
        postId: postId,
    };

    sendRequest(obj, '../server/delete_post.php', displayAlert);

    span.parentElement.remove();
}
