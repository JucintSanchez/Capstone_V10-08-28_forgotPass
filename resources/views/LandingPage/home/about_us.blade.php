<style>
    .image-container {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin-left: 5rem;
    }

    .image-container-large {
        height: 250px; /* Adjusted height */
        width: 350px; /* Adjusted width */
    }

    .image-container-small {
        height: 150px; /* Adjusted height */
        width: 150px; /* Adjusted width */
        margin-top: -100px; /* Adjusted margin */
        margin-left: 200px; /* Adjusted margin */
        z-index: 1;
        position: absolute;
        border-radius: 15px;
    }

    .content-center {
        text-align: justify;
    }

    .icon-container {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .icon-container i {
        font-size: 1.5rem; /* Adjusted icon size */
        margin-right: 10px;
        color: green;
    }

    h5 {
        color: black;
        font-size: 24px; /* Adjusted font size */
        font-weight: bolder;
    }

    p {
        color: gray;
        font-size: 14px; /* Adjusted font size */
    }

    .learn-more {
        margin-top: 20px;
    }

    .title {
        color: #618264; /* Green color */
        font-size: 40px; /* Adjusted font size */
        text-align: center;
        margin-bottom: 2rem;
    }

    .notes-container {
        position: absolute;
        top: 10px; /* Adjust as needed */
        left: -10px; /* Adjust as needed */
        background: green; /* Semi-transparent background */
        color: white;
        padding: 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        margin-left: 5rem;
    }

    .arrow-icon {
        margin-left: 10px;
        font-size: 18px; /* Adjusted icon size */
    }

    .letsee-container {
        background: rgba(0, 128, 0, 0.5); /* Transparent green */
        color: white;
        padding: 20px;
        border-radius: 10px;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        margin-left: 200px;
        margin-right: auto;
        transform: translateY(-50%);
        text-align: center;
        width: 80%; /* Adjust width as needed */
        z-index: 2; /* Ensure it's above other elements */
    }

    .circle {
        width: 40px; /* Adjusted size */
        height: 40px; /* Adjusted size */
        background-color: black;
        border-radius: 50%;
        position: absolute;
        top: -20px; /* Half of the circle's height to center it */
        left: 50%;
        transform: translateX(-50%);
    }

    h2 {
        margin-top: 30px; /* Adjust to provide space between the circle and the title */
        font-size: 20px; /* Adjusted font size */
    }

    p {
        margin-top: 10px;
        font-size: 14px; /* Adjusted font size */
    }

    .row {
        display: flex;
        justify-content: center; /* Center columns horizontally */
        align-items: center; /* Center columns vertically */
    }
</style>

<?php
    use App\Models\HomeSettings;

    $homeSettings = HomeSettings::first();
?>

<div class="container mt-5">
    <div class="row">
        <!-- First Column -->
        <div class="col-md-6">
            <h2 class="title">About Us</h2>
            <div class="row">
                <p style="text-align:justify; color: black; font-weight: 600;">
                    {{ $homeSettings->about_us }}
                </p>
            </div>
        </div>
    </div>
</div>
