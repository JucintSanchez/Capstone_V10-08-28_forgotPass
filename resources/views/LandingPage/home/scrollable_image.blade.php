<?php
use App\Models\tourist_spot;

$spots = tourist_spot::orderBy('tourist_spot_ID', 'desc')->get(); // Adjust the number per page as needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tourist Spots</title>
    <style>
        .slider-container {
            position: relative;
            width: 100%; /* Full width of the parent container */
            max-width: 1200px; /* Maximum width for larger screens */
            margin: auto;
            overflow: hidden;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide-group {
            display: flex;
            flex: 0 0 100%; /* Take full width of container */
        }

        .card {
            width: calc(33.33% - 20px); /* Three cards per slide, with margin */
            height: auto; /* Adjust height to fit content */
            flex: 0 0 auto;
            margin: 10px; /* Adjust space between cards */
            position: relative;
            border: 1px solid #ddd; /* Add a border to the card */
            border-radius: 5px; /* Rounded corners for the card */
            overflow: hidden; /* Ensure content stays within the card */
            background-color: #fff; /* Background color for the card */
        }

        .card img {
            width: 100%;
            height: 150px; /* Fixed height for images */
            object-fit: cover;
            cursor: pointer; /* Add pointer cursor on hover */
        }

        .card-header {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px; /* Space between header and body */
        }

        .card-header img {
            border-radius: 50%;
            width: 30px; /* Smaller circle */
            height: 30px;
            margin-right: 10px;
        }

        .card-body {
            padding: 10px; /* Padding for card body */
            height: auto; /* Adjust height for card body */
            overflow: hidden; /* Hide overflow text */
        }

        .card-title {
            font-size: 1rem; /* Font size for card title */
            margin-bottom: 5px; /* Margin below title */
        }

        .card-description {
            font-size: 0.875rem; /* Font size for card description */
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.5);
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        @media (max-width: 768px) {
            .card {
                width: calc(50% - 20px); /* Two cards per slide on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .card {
                width: calc(100% - 20px); /* One card per slide on very small screens */
            }
        }

        /* Styles for the modal */
        .maximized {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 60px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        .maximized-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .maximized-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {transform: scale(0)}
            to {transform: scale(1)}
        }
    </style>
</head>
<body>
@php
    $allImages = [];
    foreach ($spots as $spot) {
        $images = json_decode($spot->images, true);
        if ($images && count($images) > 0) {
            foreach ($images as $image) {
                $allImages[] = [
                    'image' => $image,
                    'desc' => $spot->desc
                ];
            }
        }
    }
@endphp

<div class="slider-container">
    <div class="slider" id="image-slider">
        <!-- Image slides will be dynamically inserted here -->
    </div>
    <button class="nav-btn prev-btn" onclick="prevSlide()">❮</button>
    <button class="nav-btn next-btn" onclick="nextSlide()">❯</button>
</div>

<!-- The Modal -->
<div class="maximized" onclick="closeModal()">
    <img class="maximized-content" id="maximized-image">
</div>

<script>
    let slideIndex = 0;
    const allImages = @json($allImages);

    function createSlides(images, imagesPerGroup) {
        const imageSlider = document.getElementById('image-slider');
        imageSlider.innerHTML = ''; // Clear existing slides
        const imageChunks = [];

        for (let i = 0; i < images.length; i += imagesPerGroup) {
            imageChunks.push(images.slice(i, i + imagesPerGroup));
        }

        imageChunks.forEach(chunk => {
            const slideGroup = document.createElement('div');
            slideGroup.className = 'slide-group';
            chunk.forEach(imageData => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <div class="card-header">
                        <img class="profile_pic" src="./assets/img/ryan.jpg" alt="Profile Picture">
                        <span>Admin</span>
                    </div>
                    <div class="card-description">
                        <p>${imageData.desc}</p>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('storage/') }}/${imageData.image}" alt="Image" class="post-image">
                    </div>
                `;
                slideGroup.appendChild(card);
            });
            imageSlider.appendChild(slideGroup);
        });

        attachImageEventListeners();
    }

    function showSlide(n) {
        const slider = document.getElementById('image-slider');
        const slideGroups = slider.querySelectorAll('.slide-group');
        if (n >= slideGroups.length) {
            slideIndex = 0;
        } else if (n < 0) {
            slideIndex = slideGroups.length - 1;
        } else {
            slideIndex = n;
        }
        slider.style.transform = `translateX(-${slideIndex * 100}%)`;
    }

    function nextSlide() {
        showSlide(slideIndex + 1);
    }

    function prevSlide() {
        showSlide(slideIndex - 1);
    }

    function updateSlides() {
        const width = window.innerWidth;
        if (width < 480) {
            createSlides(allImages, 1); // One image per group for small screens
        } else if (width < 768) {
            createSlides(allImages, 2); // Two images per group for medium screens
        } else {
            createSlides(allImages, 3); // Three images per group for large screens
        }
        showSlide(slideIndex);
    }

    function attachImageEventListeners() {
        const images = document.querySelectorAll('.post-image');
        const maximizedView = document.querySelector('.maximized');
        const maximizedImage = document.getElementById('maximized-image');
        let activeImage = null;

        images.forEach((image) => {
            image.removeEventListener('click', handleImageClick);
            image.addEventListener('click', handleImageClick);
        });

        function handleImageClick(event) {
            const image = event.currentTarget;
            maximizedView.style.display = 'flex';
            maximizedImage.src = image.src;
            document.body.style.overflow = 'hidden';
            activeImage = image;
        }

        function closeModal() {
            maximizedView.style.display = 'none';
            document.body.style.overflow = '';
            activeImage = null;
        }

        maximizedView.addEventListener('click', function(event) {
            if (event.target === maximizedView && activeImage) {
                closeModal();
            }
        });

        document.addEventListener('keyup', function(event) {
            if (event.key === 'Escape' && activeImage) {
                closeModal();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSlides();
        window.addEventListener('resize', updateSlides); // Update slides on resize
    });
</script>
</body>
</html>
