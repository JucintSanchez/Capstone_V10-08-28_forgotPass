<?php
use App\Models\HikingAct;
use App\Models\MountainDetails;
use App\Models\ThingsToBring;
use App\Models\HomeSettings;
use App\Models\TermsCondition;
use App\Models\Rules_Regulation;

$homeSettings = HomeSettings::first();
$thingsToBring = ThingsToBring::where('org_id', $homeSettings->org_id)->get();
$mountain_details = MountainDetails::first();
$terms_condition = TermsCondition::first();
$rules = Rules_Regulation::where('org_id', $homeSettings->org_id)->get();
$acts = HikingAct::all();
?>

<style>
    /* Container Styles */
    .containerrr {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Section Styles */
    #things-to-bring-section,
    #terms-section,
    #rules-section,
    #reminders-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    /* Section Headers */
    #things-to-bring-section h2,
    #terms-section h2,
    #rules-section h2,
    #reminders-section h6 {
        color: #4CAF50; /* Green color for section headers */
        margin-top: 0;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f4f4f4;
        color: #333;
    }

    h1 {
        color: #2c3e50;
        font-family: 'Arial', sans-serif;
    }

    .section {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .section h2 {
        margin-top: 0;
        border-bottom: 2px solid #27ae60;
        padding-bottom: 10px;
        color: #27ae60;
    }

    .section p, .section ul {
        margin: 0;
        line-height: 1.6;
    }

    .section ul {
        padding-left: 20px;
    }

    .section ul li {
        position: relative;
        padding-left: 20px;
    }

    .section ul li::before {
        content: "\f058"; /* Font Awesome check icon */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #27ae60;
    }

    .carousel-inner img {
        width: 100%;
        height: 50vh; /* Set the height to 50% of the viewport height */
        object-fit: cover; /* Ensure images cover the area without distortion */
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .button-container .button {
        flex: 1 1 calc(25% - 10px); /* Adjust size for responsiveness */
        display: flex;
        flex-direction: column; /* Arrange items in a column */
        align-items: center;
        justify-content: center;
        width: 15rem; /* Set width to 15rem */
        height: 10rem; /* Set height to 10rem */
        border: 2px solid #27ae60; /* Green border line */
        color: #27ae60; /* Green text color */
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
        text-decoration: none;
        background-color: transparent; /* No background color */
        padding: 10px;
    }

    .button-container .button i {
        font-size: 3rem; /* Set icon size to 3rem */
        margin-bottom: 8px; /* Space between icon and text */
    }

    .button-container .button:hover {
        background-color: rgba(39, 174, 96, 0.1); /* Light green background on hover */
    }

    .grid-container {
        display: grid;
        grid-template-columns: 1fr 2fr; /* Two columns with the second column twice as wide as the first */
        gap: 20px;
        margin-top: 20px;
    }

    .info-box {
        border: 1px solid #27ae60; /* Green border line */
        padding: 15px;
        border-radius: 5px;
    }

    .info-box h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .info-box p {
        margin: 5px 0;
    }
</style>

<h1>{{ $mountain_details->mountain_name }} Hiking Information</h1>

<div id="imageCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php $isFirst = true; ?>
        @foreach ($acts as $act)
            <?php
            $images = is_string($act->act_picture) ? json_decode($act->act_picture, true) : [];
            if ($images && is_array($images)) {
                $firstImage = asset('storage/' . str_replace('public/', '', $images[0]));
            } else {
                $firstImage = '';
            }
            ?>
            @if ($firstImage)
                <div class="carousel-item {{ $isFirst ? 'active' : '' }}">
                    <img src="{{ $firstImage }}" alt="Image">
                </div>
                <?php $isFirst = false; ?>
            @endif
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="grid-container">
    <div class="info-box">
        <h2>{{ $mountain_details->mountain_name }} Details</h2>
        <p><strong>Name:</strong> {{ $mountain_details->mountain_name }}</p>
        <p><strong>Difficulty:</strong> {{ $mountain_details->difficulty }}</p>
        <p><strong>Elevation:</strong> {{ $mountain_details->elevation }}</p>
        <p><strong>Jump-Off:</strong> {{ $mountain_details->station }}</p>
        <p><strong>Features:</strong> {{ $mountain_details->features }}</p>
    </div>

    <div>
        <div class="section" id="overview">
            <h2>Overview</h2>
            <p>
                {{ $mountain_details->overview }}
            </p>
        </div>

        <div class="button-container">
            <a href="#things-to-bring" class="button">
                <i class="fas fa-person-hiking"></i> Things To Bring
            </a>
            <a href="#terms" class="button">
                <i class="fas fa-file-contract"></i> Terms and Conditions
            </a>
            <a href="#rules" class="button">
                <i class="fas fa-gavel"></i> Rules and Regulation
            </a>
            <a href="#reminders" class="button">
                <i class="fas fa-calendar-day"></i>Reminders
            </a>
        </div>

        <div class="containerrr">
            <div id="things-to-bring-section" style="display: none;">
                <h2>Things to Bring on Your Visit to {{ $mountain_details->mountain_name }}:</h2>
                <ul>
            @foreach ($thingsToBring as $item)
                <li>{{ $item->item_name }}</li>
            @endforeach
        </ul>
            </div>
            <div id="terms-section" style="display: none;">
                <h2>Terms and Conditions for Hikers</h2>
                <h5>{{ $terms_condition->terms_and_condition }}</h5>
                
            </div>
            <div id="rules-section" style="display: none;">
                <h2>Rules & Regulations</h2>
                @foreach ($rules as $rule)
                <li>{{ $rule->rules_n_regulation }}</li>
            @endforeach
            </div>
            <div id="reminders-section" style="display: none;">
                <h6>Reminders & Tips</h6>
                <!-- The rest of your reminders content goes here -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        function hideAllSections() {
            const sections = document.querySelectorAll('#things-to-bring-section, #terms-section, #rules-section, #reminders-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
        }

        // Event listener for things to bring button
        const thingsToBringButton = document.querySelector('a[href="#things-to-bring"]');
        thingsToBringButton.addEventListener('click', (event) => {
            event.preventDefault();
            hideAllSections();
            const thingsToBringSection = document.getElementById('things-to-bring-section');
            thingsToBringSection.style.display = 'block';
        });

        // Event listener for terms button
        const termsButton = document.querySelector('a[href="#terms"]');
        termsButton.addEventListener('click', (event) => {
            event.preventDefault();
            hideAllSections();
            const termsSection = document.getElementById('terms-section');
            termsSection.style.display = 'block';
        });

        // Event listener for rules button
        const rulesButton = document.querySelector('a[href="#rules"]');
        rulesButton.addEventListener('click', (event) => {
            event.preventDefault();
            hideAllSections();
            const rulesSection = document.getElementById('rules-section');
            rulesSection.style.display = 'block';
        });

        // Event listener for reminders button
        const remindersButton = document.querySelector('a[href="#reminders"]');
        remindersButton.addEventListener('click', (event) => {
            event.preventDefault();
            hideAllSections();
            const remindersSection = document.getElementById('reminders-section');
            remindersSection.style.display = 'block';
        });
    });
</script>
