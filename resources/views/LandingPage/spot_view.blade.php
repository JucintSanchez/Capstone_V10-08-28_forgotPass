<?php
use App\Models\tourist_spot;
$spots = tourist_spot::orderBy('tourist_spot_ID', 'desc')->paginate(5); // Adjust the number per page as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tourist Spots</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container1 {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .card-header img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .card-content {
            padding: 15px;
        }
        .post-content p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
            text-align: left;
        }
        .post-images {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 10px;
            justify-content: center; /* Center align images */
        }
        .post-images img {
            width: 100%; /* Ensures images fill their containers */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }
        .post-images img:hover {
            transform: scale(1.05);
        }
        .maximize-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            color: #333;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            display: none;
            z-index: 1;
        }
        .maximized {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .maximized img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 8px;
            cursor: pointer;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            z-index: 10000;
        }
        .profile_pic {
            margin-top: 8px;
            margin-left: 8px;
        }
        .card {
            margin-top: 20px;
        }
        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: flex-end; /* Align pagination to the right */
            margin-top: 20px; /* Add margin top */
            padding-left: 0;
            list-style: none;
            border-radius: .25rem;
        }
        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            background-color: #fff;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        .page-link:not(.previous):not(.next) {
            border-right: none; /* Remove border for numbered buttons */
            border-top: none;
            border-bottom: none;
            color: green;
        }
        .page-link.previous, .page-link.next {
            border: 1px solid #dee2e6; /* Add border to previous and next buttons */
            color: green;
        }
        .page-link.previous {
            border-top-left-radius: .25rem; /* Add border-radius to the top-left corner */
            border-bottom-left-radius: .25rem; /* Add border-radius to the bottom-left corner */
        }
        .page-link:hover {
            color: #0056b3;
            text-decoration: none;
            background-color: #e9ecef;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #28a745; /* Green color */
        }
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
        }
        .page-item:first-child .page-link {
            border-top-left-radius: .25rem;
            border-bottom-left-radius: .25rem;
        }
        .page-item:last-child .page-link {
            border-top-right-radius: .25rem;
            border-bottom-right-radius: .25rem;
        }
    </style>
</head>
<body>
<div id="spotPost">
    <div class="container1" id="spots-container">
        @foreach($spots as $spot)
            <div class="card">
                <div class="card-header">
                    <img class="profile_pic" src="./assets/img/ryan.jpg" alt="Profile Picture"><span class="profile_pic">Admin</span>
                    {{ $spot->title }}
                </div>
                <div class="card-content">
                    <div class="post-content">
                        <p>{{ $spot->desc }}</p>
                    </div>
                    <div class="post-images">
                        @foreach(json_decode($spot->images, true) as $image)
                            <div class="image-container">
                                <img src="{{ asset('storage/' . $image) }}" alt="Image">
                                <button class="maximize-button">View</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                @if ($spots->onFirstPage())
                    <li class="page-item disabled">
                        <a class="page-link previous" href="#" tabindex="-1">Previous</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link previous" href="{{ $spots->previousPageUrl() }}">Previous</a>
                    </li>
                @endif

                @foreach ($spots->getUrlRange(1, $spots->lastPage()) as $page => $url)
                    @if ($page == $spots->currentPage())
                        <li class="page-item active">
                            <span class="page-link" style = "background-color: green;
    border-color: green;">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($spots->hasMorePages())
                    <li class="page-item">
                        <a class="page-link next" href="{{ $spots->nextPageUrl() }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link next" href="#">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
<div class="maximized" style="display: none;">
    <span class="close-button">&times;</span>
    <img id="maximized-image" src="" alt="Maximized Image">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function attachImageEventListeners() {
        const images = document.querySelectorAll('.post-images img');
        const maximizeButtons = document.querySelectorAll('.maximize-button');
        const maximizedView = document.querySelector('.maximized');
        const maximizedImage = document.getElementById('maximized-image');
        const closeButton = document.querySelector('.close-button');
        let activeImage = null;

        images.forEach((image) => {
            image.removeEventListener('click', handleImageClick);
            image.addEventListener('click', handleImageClick);
        });

        closeButton.removeEventListener('click', handleCloseButtonClick);
        closeButton.addEventListener('click', handleCloseButtonClick);

        maximizeButtons.forEach(button => {
            button.removeEventListener('click', handleMaximizeButtonClick);
            button.addEventListener('click', handleMaximizeButtonClick);
        });

        function handleImageClick(event) {
            const image = event.currentTarget;
            maximizedView.style.display = 'flex';
            maximizedImage.src = image.src;
            document.body.style.overflow = 'hidden';
            activeImage = image;
        }

        function handleCloseButtonClick() {
            maximizedView.style.display = 'none';
            document.body.style.overflow = '';
            activeImage = null;
        }

        function handleMaximizeButtonClick(event) {
            event.stopPropagation();
            const container = event.currentTarget.parentElement;
            const image = container.querySelector('img');
            maximizedView.style.display = 'flex';
            maximizedImage.src = image.src;
            document.body.style.overflow = 'hidden';
            activeImage = image;
        }

        maximizedView.addEventListener('click', function(event) {
            if (event.target === maximizedView && activeImage) {
                maximizedView.style.display = 'none';
                document.body.style.overflow = '';
                activeImage = null;
            }
        });

        document.addEventListener('keyup', function(event) {
            if (event.key === 'Escape' && activeImage) {
                maximizedView.style.display = 'none';
                document.body.style.overflow = '';
                activeImage = null;
            }
        });
    }

    function loadPage(url) {
        $.ajax({
            url: url,
            type: 'get',
            beforeSend: function() {
                $('#spots-container').fadeOut(300, function() {
                    $(this).html('Loading...').fadeIn(300);
                });
            }
        }).done(function(data) {
            $('#spots-container').fadeOut(300, function() {
                $(this).html($(data).find('#spots-container').html()).fadeIn(300);
                attachImageEventListeners();
                window.history.pushState(null, null, url);
            });
        }).fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
    }

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        loadPage(url);
    });

    document.addEventListener('DOMContentLoaded', function() {
        attachImageEventListeners();
    });

    window.attachImageEventListeners = attachImageEventListeners;
</script>
</body>
</html>