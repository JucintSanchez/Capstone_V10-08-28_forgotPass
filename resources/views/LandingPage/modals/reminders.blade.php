<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
  <!-- SweetAlert CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css" rel="stylesheet"/>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    .modal-dialog-scrollable {
        max-height: 80vh;
    }
    .modal-lg {
        max-width: 90%; /* Use a higher percentage for more responsive design */
    }
    .list-group-item {
        border: none;
        background-color: #f9f9f9;
        margin-bottom: 5px;
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 14px;
        display: flex;
        align-items: center;
        word-wrap: break-word;
    }
    .list-group-item strong {
        color: green;
    }
    .modal-body h6 {
        text-align: center;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .modal-body h6::after {
        content: "";
        display: block;
        width: 50px;
        margin: 10px auto;
        border-bottom: 2px solid green;
    }
    .list-group-item i {
        margin-right: 10px;
        color: green;
    }
    .modal-header {
        background-color: green;
        color: #fff;
    }
    .btn-close {
        background: transparent;
        border: 1px solid #fff;
        border-radius: 50%;
        padding: 5px;
        color: #fff;
    }
    .btn-close:hover {
        background-color: #fff;
        color: green;
    }
    .modal-footer {
        border-top: 1px solid green;
    }
    .modal-footer .btn-secondary {
        background-color: green;
        border-color: green;
    }
    .modal-footer .btn-secondary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
  </style>
</head>
<body>
<!-- resources/views/modals/reminders.blade.php -->
  <div class="modal fade" id="remindersModal" tabindex="-1" aria-labelledby="remindersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="remindersModalLabel">Mt. Talamitam Rules & Regulations and Reminders & Tips</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Rules & Regulations</h6>
          <ul class="list-group">
            <li class="list-group-item"><i class="fas fa-clipboard-check"></i>1. Registration at the Barangay Hall is required. Fees are to be transacted at the same organization.</li>
            <li class="list-group-item"><i class="fas fa-hiking"></i>2. Stick to the trail. Do not enter grass fields or trample on wild flowers.</li>
            <li class="list-group-item"><i class="fas fa-leaf"></i>3. Don't pick any of the plants. It’s also prohibited to catch insects or animals.</li>
            <li class="list-group-item"><i class="fas fa-trash-alt"></i>4. Take home all of your waste products including left-over food.</li>
            <li class="list-group-item"><i class="fas fa-wine-bottle"></i>5. Consumption of alcoholic beverages is not permitted.</li>
            <li class="list-group-item"><i class="fas fa-smoking-ban"></i>6. Smoking is not allowed.</li>
            <li class="list-group-item"><i class="fas fa-fire"></i>7. Cooking along the trail and on the summit is prohibited.</li>
            <li class="list-group-item"><i class="fas fa-campground"></i>8. Pitch your tent in the designated area only (i.e. base camp and jump off area only).</li>
            <li class="list-group-item"><i class="fas fa-fire-extinguisher"></i>9. It is strongly prohibited to build fires in the mountains. Do not use dried leaves/tree branches for building a fire. Use butane gas for the purpose. Always double check that butane gas stoves are fully extinguished after each use.</li>
            <li class="list-group-item"><i class="fas fa-users"></i>10. Submit a climber list of climbers/participants with complete address and contact numbers. Log in the registration logbook on your arrival at the barangay/destination.</li>
          </ul>
          <h6>Reminders & Tips</h6>
          <ul class="list-group">
            <li class="list-group-item"><i class="fas fa-shoe-prints"></i><strong>Beginner-Friendly:</strong> The hike takes about 5 hours (3 up, 2 down).</li>
            <li class="list-group-item"><i class="fas fa-route"></i><strong>Trail Length:</strong> 7.5 km. Start at Barangay Kayrilaw.</li>
            <li class="list-group-item"><i class="fas fa-user-friends"></i><strong>Hiker Limit:</strong> Only 100 hikers per day.</li>
            <li class="list-group-item"><i class="fas fa-user-shield"></i><strong>Guide Required:</strong> No guide, no hike. Fee: ₱30 for each hiker.</li>
            <li class="list-group-item"><i class="fas fa-tint"></i><strong>Water:</strong> Bring at least 2 liters. Only one water source available.</li>
            <li class="list-group-item"><i class="fas fa-sun"></i><strong>Start Early:</strong> Best to start by 5 am to avoid heat and catch the sunrise.</li>
            <li class="list-group-item"><i class="fas fa-recycle"></i><strong>Leave No Trace:</strong> Always dispose of trash properly.</li>
            <li class="list-group-item"><i class="fas fa-hands-helping"></i><strong>Respect:</strong> Respect the place and locals. We're only visitors.</li>
            <li class="list-group-item"><i class="fas fa-tshirt"></i><strong>Clothing:</strong> Wear long sleeves, bring sunblock, and use arm sleeves.</li>
            <li class="list-group-item"><i class="fas fa-cloud-sun-rain"></i><strong>Check Weather:</strong> Ensure good weather for views and safer trails.</li>
            <li class="list-group-item"><i class="fas fa-trash-alt"></i><strong>Campers:</strong> Bring garbage bags. No blood leeches, signal mostly present.</li>
            <li class="list-group-item"><i class="fas fa-hamburger"></i><strong>Food & Drink:</strong> Vendors at the summit (not always present).</li>
            <li class="list-group-item"><i class="fas fa-store"></i><strong>Amenities:</strong> Parking, stores, and restrooms available at jump-off.</li>
            <li class="list-group-item"><i class="fas fa-star"></i><strong>Overnight:</strong> Camp at the base of the summit for stunning night skies.</li>
            <li class="list-group-item"><i class="fas fa-car"></i><strong>Accessibility:</strong> Accessible for both public and private vehicles.</li>
            <li class="list-group-item"><i class="fas fa-exclamation-triangle"></i><strong>Be Mindful:</strong> Watch for snakes. Follow the same trail back.</li>
            <li class="list-group-item"><i class="fas fa-mountain"></i><strong>Trilogy Hike:</strong> Experienced hikers can include Mt. Apayang & Mt. Lantik.</li>
            <li class="list-group-item"><i class="fas fa-calendar-alt"></i><strong>Best Months:</strong> January to April for optimal conditions.</li>
            <li class="list-group-item"><i class="fas fa-suitcase"></i><strong>Packaged Tour:</strong> Includes transport, fees, and guide. Excludes meals.</li>
            <li class="list-group-item"><i class="fas fa-map-marker-alt"></i><strong>Side Trips:</strong> Visit Tagaytay or other Batangas spots after the hike.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
</body>
</html>
