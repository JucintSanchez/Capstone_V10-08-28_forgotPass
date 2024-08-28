<?php
    $user = Auth::guard('guide')->user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Guide Ratings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
            font-size: 14px; /* Reduced base font size */
        }
        .rating-section {
            margin-bottom: 40px;
        }
        .rating-section h2 {
            margin-bottom: 10px;
            font-size: 18px; /* Reduced heading size */
        }
        .guide-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .guide-card {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 10px;
            margin: 10px;
        }
        .guide-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .guide-card .info {
            text-align: center;
        }
        .guide-card .info h3 {
            margin: 0;
            font-size: 16px; /* Reduced guide name size */
        }
        .guide-card .info .rating {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .guide-card .info .rating .stars {
            font-size: 16px; /* Reduced star size */
            color: gold;
        }
        .guide-card .info .rating span {
            margin-left: 5px;
            font-size: 14px; /* Reduced rating size */
            color: #666;
        }
        .comment-section {
            margin-top: 20px;
        }
        .comment-section h4 {
            margin-bottom: 10px;
            font-size: 14px; /* Reduced comment heading size */
            font-weight: bold;
            color: #333;
        }
        .comment-form textarea {
            width: 100%;
            padding: 8px; /* Reduced padding */
            border: 1px solid #ddd;
            border-radius: 20px;
            resize: vertical;
            min-height: 40px; /* Reduced min-height */
            font-size: 12px; /* Reduced textarea font size */
        }
        .comment-form input[type="submit"] {
            margin-top: 8px; /* Reduced margin */
            padding: 8px 16px; /* Reduced padding */
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px; /* Reduced button font size */
        }
        .comment-list {
            list-style: none;
            padding: 0;
        }
        .comment-list li {
            border-bottom: 1px solid #ddd;
            padding: 8px 0; /* Reduced padding */
            display: flex;
            flex-direction: column;
            gap: 8px; /* Reduced gap */
        }
        .comment-list .comment {
            display: flex;
            flex-direction: column;
            gap: 8px; /* Reduced gap */
        }
        .comment-list .comment .comment-content {
            flex: 1;
        }
        .comment-list .comment .comment-content p {
            margin: 4px 0; /* Reduced margin */
            font-size: 12px; /* Reduced comment font size */
        }
        .comment-list .comment .comment-content .comment-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px; /* Reduced font size */
            color: #888;
        }
        .comment-list .comment .comment-content .reply-section {
            display: none; /* Initially hide the reply section */
            margin-top: 10px;
            padding-left: 20px;
            border-left: 2px solid #ddd;
        }
        .reply-form {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        .reply-form textarea {
            margin-bottom: 10px;
            border-radius: 20px;
            font-size: 12px; /* Reduced textarea font size */
        }
        .reply-form input[type="submit"] {
            align-self: flex-start;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px; /* Reduced button font size */
        }
        .show-replies {
            cursor: pointer;
            color: #007bff;
            font-size: 12px; /* Reduced font size */
        }
    </style>
</head>
<body>

    <div class="rating-section">
        <h2>Tour Guides</h2>
        <div id="guideContainer" class="guide-container">
            <!-- Guide cards will be injected here -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const guideContainer = document.getElementById('guideContainer');

            // Username of the currently logged-in user
            const currentUsername = 'LoggedInUser'; // Replace with dynamic username if available

            const guides = [
                { id: 1, name: 'John Doe', picture: 'https://via.placeholder.com/300', rating: 4.5, comments: [] },
                { id: 2, name: 'Jane Smith', picture: 'https://via.placeholder.com/300', rating: 3.8, comments: [
                    { id: 1, name: 'Alice Johnson', text: 'Great tour!', date: '2024-08-01', replies: [] }
                ] },
                { id: 3, name: 'Alice Johnson', picture: 'https://via.placeholder.com/300', rating: 4.2, comments: [] }
            ];

            function renderGuideCards() {
                guideContainer.innerHTML = '';
                guides.forEach(guide => {
                    const guideCard = document.createElement('div');
                    guideCard.classList.add('guide-card');
                    guideCard.innerHTML = `
                        <img src="${guide.picture}" alt="${guide.name}">
                        <div class="info">
                            <h3>${guide.name}</h3>
                            <div class="rating">
                                <div class="stars">${'★'.repeat(Math.round(guide.rating))}${'☆'.repeat(5 - Math.round(guide.rating))}</div>
                                <span>${guide.rating.toFixed(1)}</span>
                            </div>
                        </div>
                        <div class="comment-section">
                            <h4>Comments</h4>
                            ${guide.comments.length > 0 ? `
                                <ul class="comment-list">
                                    ${guide.comments.map(comment => `
                                        <li data-comment-id="${comment.id}">
                                            <div class="comment">
                                                <div class="comment-content">
                                                    <p><strong>${comment.name}:</strong> ${comment.text}</p>
                                                    <div class="comment-info">
                                                        <small>${comment.date}</small>
                                                        <a href="#" class="show-replies">Show Replies (${comment.replies.length})</a>
                                                    </div>
                                                    <div class="reply-section">
                                                        ${comment.replies.map(reply => `
                                                            <div class="comment">
                                                                <div class="comment-content">
                                                                    <p><strong>${reply.name}:</strong> ${reply.text}</p>
                                                                    <div class="comment-info">
                                                                        <small>${reply.date}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `).join('')}
                                                        <form class="reply-form">
                                                            <textarea placeholder="Reply here..." required></textarea>
                                                            <input type="submit" value="Reply">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    `).join('')}
                                </ul>
                            ` : ''}
                            <form class="comment-form" style="${guide.comments.length > 0 ? 'display: none;' : ''}">
                                <textarea placeholder="Add your comment here..." required></textarea>
                                <input type="submit" value="Post Comment">
                            </form>
                        </div>
                    `;
                    guideContainer.appendChild(guideCard);

                    guideCard.querySelector('.comment-form').addEventListener('submit', function (e) {
                        e.preventDefault();

                        const textarea = this.querySelector('textarea');
                        const newComment = textarea.value;
                        if (newComment.trim()) {
                            const commentItem = document.createElement('li');
                            commentItem.innerHTML = `
                                <div class="comment">
                                    <div class="comment-content">
                                        <p><strong>${currentUsername}:</strong> ${newComment}</p>
                                        <div class="comment-info">
                                            <small>${new Date().toISOString().split('T')[0]}</small>
                                            <a href="#" class="show-replies">Show Replies (0)</a>
                                        </div>
                                        <div class="reply-section">
                                            <form class="reply-form">
                                                <textarea placeholder="Reply here..." required></textarea>
                                                <input type="submit" value="Reply">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            `;
                            this.previousElementSibling.appendChild(commentItem);

                            guide.comments.push({
                                id: guide.comments.length + 1, // Ensure unique ID for each comment
                                name: currentUsername,
                                text: newComment,
                                date: new Date().toISOString().split('T')[0],
                                replies: []
                            });

                            textarea.value = '';
                            if (this.style.display === 'none') {
                                this.style.display = '';
                            }
                            this.previousElementSibling.querySelector('.show-replies').innerText = `Show Replies (0)`;
                        }
                    });

                    guideCard.querySelectorAll('.reply-form').forEach((form) => {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();

                            const textarea = this.querySelector('textarea');
                            const replyText = textarea.value;
                            if (replyText.trim()) {
                                const replyItem = document.createElement('div');
                                replyItem.classList.add('comment');
                                replyItem.innerHTML = `
                                    <div class="comment-content">
                                        <p><strong>${currentUsername}:</strong> ${replyText}</p>
                                        <div class="comment-info">
                                            <small>${new Date().toISOString().split('T')[0]}</small>
                                        </div>
                                    </div>
                                `;
                                this.previousElementSibling.appendChild(replyItem);

                                const commentId = this.closest('li').getAttribute('data-comment-id');
                                const comment = guide.comments.find(c => c.id == commentId);
                                comment.replies.push({
                                    name: currentUsername,
                                    text: replyText,
                                    date: new Date().toISOString().split('T')[0]
                                });

                                textarea.value = '';
                            }
                        });
                    });

                    guideCard.querySelectorAll('.show-replies').forEach((link, index) => {
                        link.addEventListener('click', function (e) {
                            e.preventDefault();
                            const replySection = this.closest('li').querySelector('.reply-section');
                            if (replySection.style.display === 'none' || !replySection.style.display) {
                                replySection.style.display = 'block';
                                this.innerText = `Hide Replies (${guide.comments[index].replies.length})`;
                            } else {
                                replySection.style.display = 'none';
                                this.innerText = `Show Replies (${guide.comments[index].replies.length})`;
                            }
                        });
                    });
                });
            }

            renderGuideCards();
        });
    </script>

</body>
</html>
