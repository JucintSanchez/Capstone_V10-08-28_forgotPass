<?php
use App\Models\Organization;

$organization = Organization::find(1); // Replace with the actual ID or logic to get the organization
$address = $organization->address;
?>

<style>
    .weather-container {
        background: linear-gradient(to top, green, white);
        color: black;
        font-weight: 600;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    h1, h4 {
        margin: 0;
    }

    h4 {
        margin-top: 10px;
        font-size: 1.2em;
    }

    #weather {
        margin-top: 20px;
    }

    .forecast {
        margin-top: 30px;
    }

    .forecast h2 {
        font-size: 1.4em;
        margin-bottom: 10px;
    }

    .forecast-item {
        display: inline-block;
        margin: 10px;
        text-align: center;
    }

    .forecast-item img {
        width: 50px;
        height: 50px;
    }

    .forecast-item p {
        margin: 5px 0;
    }

    .forecast-item .time, .forecast-item .date {
        font-weight: bold;
        color: #ffd700;
    }

    /* Assistive Touch Button Style */
    .assistive-touch {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 100px;
        height: 100px;
        background-color: rgba(0, 128, 0, 0.8); /* Green color */
        color: white;
        border-radius: 5%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1em;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        cursor: pointer;
        z-index: 1000;
    }

    .assistive-touch:hover {
        background-color: rgba(0, 0, 0, 0.6);
    }

    /* Modal Style */
    .weather-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 80%;
        max-height: 80%;
        overflow-y: auto;
        text-align: center;
        position: relative;
    }

    .modal-content h2 {
        margin-top: 0;
    }

    .modal-content .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5em;
        cursor: pointer;
    }
</style>

<!-- Assistive Touch Button -->
<div class="assistive-touch" id="assistive-touch">
    <div id="current-weather-text">Loading...</div>
</div>

<!-- Modal -->
<div id="weather-modal" class="weather-modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h1>Current Weather</h1>
        <h4><?php echo $address; ?></h4>
        <div id="weather">
            <p>Loading weather data...</p>
        </div>
        <div class="forecast">
            <h2>Hourly Forecast</h2>
            <div id="hourly-forecast"></div>
        </div>
        <div class="forecast">
            <h2>Daily Forecast</h2>
            <div id="daily-forecast"></div>
        </div>
    </div>
</div>

<script>
    const apiKey = 'Z7LpdFgl67MvwnDAl9eV5zcKCkDiJs7X'; // Replace with your AccuWeather API key
    const openCageApiKey = 'f8c6664aa6c942e7b61a629be3c85cbc'; // Replace with your OpenCage API key
    const address = '<?php echo $address; ?>'; // Retrieved from Laravel controller

    document.addEventListener('DOMContentLoaded', () => {
        fetchCoordinates(address);
    });

    function fetchCoordinates(address) {
        const geocodeUrl = `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(address)}&key=${openCageApiKey}`;

        fetch(geocodeUrl)
            .then(response => response.json())
            .then(data => {
                if (data.results.length > 0) {
                    const location = data.results[0].geometry;
                    fetchLocationKey(location.lat, location.lng);
                } else {
                    document.getElementById('weather').innerHTML = '<p>Unable to fetch coordinates.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching coordinates:', error);
                document.getElementById('weather').innerHTML = '<p>Error fetching coordinates.</p>';
            });
    }

    function fetchLocationKey(lat, lng) {
        const locationUrl = `http://dataservice.accuweather.com/locations/v1/cities/geoposition/search?apikey=${apiKey}&q=${lat},${lng}`;

        fetch(locationUrl)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    const locationKey = data.Key;
                    fetchWeather(locationKey);
                    fetchHourlyForecast(locationKey);
                    fetchDailyForecast(locationKey);
                } else {
                    document.getElementById('weather').innerHTML = '<p>Unable to fetch location key.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching location key:', error);
                document.getElementById('weather').innerHTML = '<p>Error fetching location key.</p>';
            });
    }

    function fetchWeather(locationKey) {
        const weatherUrl = `http://dataservice.accuweather.com/currentconditions/v1/${locationKey}?apikey=${apiKey}`;

        fetch(weatherUrl)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const weatherData = data[0];
                    displayWeather(weatherData);
                } else {
                    document.getElementById('weather').innerHTML = '<p>Unable to fetch weather data.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching weather data:', error);
                document.getElementById('weather').innerHTML = '<p>Error fetching weather data.</p>';
            });
    }

    function fetchHourlyForecast(locationKey) {
        const hourlyUrl = `http://dataservice.accuweather.com/forecasts/v1/hourly/12hour/${locationKey}?apikey=${apiKey}`;

        fetch(hourlyUrl)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    displayHourlyForecast(data);
                } else {
                    document.getElementById('hourly-forecast').innerHTML = '<p>Unable to fetch hourly forecast.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching hourly forecast:', error);
                document.getElementById('hourly-forecast').innerHTML = '<p>Error fetching hourly forecast.</p>';
            });
    }

    function fetchDailyForecast(locationKey) {
        const dailyUrl = `http://dataservice.accuweather.com/forecasts/v1/daily/5day/${locationKey}?apikey=${apiKey}`;

        fetch(dailyUrl)
            .then(response => response.json())
            .then(data => {
                if (data && data.DailyForecasts.length > 0) {
                    displayDailyForecast(data.DailyForecasts);
                } else {
                    document.getElementById('daily-forecast').innerHTML = '<p>Unable to fetch daily forecast.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching daily forecast:', error);
                document.getElementById('daily-forecast').innerHTML = '<p>Error fetching daily forecast.</p>';
            });
    }

    function displayWeather(data) {
        const weatherDiv = document.getElementById('weather');
        const currentWeatherText = document.getElementById('current-weather-text');
        weatherDiv.innerHTML = `
            <p style="font-weight: 600;">Temperature: ${data.Temperature.Metric.Value}°${data.Temperature.Metric.Unit}</p>
            <p style="font-weight: 600;">Weather: ${data.WeatherText}</p>
        `;
        currentWeatherText.innerHTML = `
            ${data.Temperature.Metric.Value}°${data.Temperature.Metric.Unit}<br>
            ${data.WeatherText}
        `;
    }

    function displayHourlyForecast(data) {
        const hourlyForecastDiv = document.getElementById('hourly-forecast');
        hourlyForecastDiv.innerHTML = data.map(hour => `
            <div class="forecast-item">
                <p class="time">${new Date(hour.DateTime).getHours()}:00</p>
                <img src="https://developer.accuweather.com/sites/default/files/${hour.WeatherIcon < 10 ? '0' + hour.WeatherIcon : hour.WeatherIcon}-s.png" alt="${hour.IconPhrase}">
                <p>${hour.Temperature.Value}°${hour.Temperature.Unit}</p>
            </div>
        `).join('');
    }

    function displayDailyForecast(data) {
        const dailyForecastDiv = document.getElementById('daily-forecast');
        dailyForecastDiv.innerHTML = data.map(day => `
            <div class="forecast-item">
                <p class="date">${new Date(day.Date).toLocaleDateString()}</p>
                <img src="https://developer.accuweather.com/sites/default/files/${day.Day.Icon < 10 ? '0' + day.Day.Icon : day.Day.Icon}-s.png" alt="${day.Day.IconPhrase}">
                <p>${day.Temperature.Minimum.Value}°${day.Temperature.Minimum.Unit} - ${day.Temperature.Maximum.Value}°${day.Temperature.Maximum.Unit}</p>
            </div>
        `).join('');
    }

    // Assistive Touch Button and Modal
    const assistiveTouch = document.getElementById('assistive-touch');
    const weatherModal = document.getElementById('weather-modal');
    const closeModal = document.getElementById('close-modal');

    assistiveTouch.addEventListener('click', () => {
        weatherModal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
        weatherModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === weatherModal) {
            weatherModal.style.display = 'none';
        }
    });
</script>
