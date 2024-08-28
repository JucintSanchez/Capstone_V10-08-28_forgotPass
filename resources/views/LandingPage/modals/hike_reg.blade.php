<?php
use Illuminate\Support\Facades\Auth;
use App\Models\HikingAct; 

$user = Auth::guard('hiker')->user();
$name = $user ? $user->first_name . ' ' . $user->last_name : '';
$email = $user ? $user->email : '';
$age = $user ? $user->age : '';
$cnum = $user ? $user->contact_num : '';
$activities = HikingAct::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>

  <!-- SweetAlert CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css" rel="stylesheet"/>

  <style>
  .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-control {
        border: none;
        border-bottom: 2px solid #ccc;
        border-radius: 0;
        padding-left: 30px;
        box-shadow: none;
    }

    .form-control:focus {
        border-bottom: 2px solid #4fcf26;
        box-shadow: none;
    }

    .form-group i {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
    }
    .form-group p {
        padding-left: 30px; /* Align text with input fields */
        border-bottom: 2px solid #ccc;
        padding-bottom: 5px;
        margin: 0;
    }

    .form-group p:focus {
        border-bottom: 2px solid #4fcf26;
    }
      .hidden {
        display: none;
      }

      /* Hide the default checkbox */
      .btn-check { 
        opacity: 0;
        position: absolute;
      }

      /* Create a custom checkbox */
      .btn-check + label {
        position: relative;
        padding-left: 25px;
        cursor: pointer;
        display: inline-block;
      }

      .btn-check + label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #000;
        background-color: #fff;
        border-radius: 3px;
      }

      /* Style the checkbox when it is checked */
      .btn-check:checked + label::before {
        background-color: #4fcf26;
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #fff;
        text-align: center;
        line-height: 18px;
      }

    .modal-dialog-centered {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100% - 1rem);
    }
    

    .modal-content {
        width: 100%;
        max-width: 600px;
        padding: 20px;
        border-radius: 10px;
        background-color: #fff;
        border: none;
    }

    .modal-header, .modal-body, .modal-footer {
        padding: 15px;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .modal-footer {
        border-top: none;
        display: flex;
        justify-content: space-between;
    }

    .modal-header .btn-close {
        
        font-size: 28px;
    }

    .modal-body .btn {
        width: 48%;
    }

    .modal-body .form-check-label {
        margin-left: 1.5rem;
    }

    .modalll {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4); /* Background overlay */
    display: flex;
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
}

.modalll-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 600px;
    max-height: 80vh; /* Ensure the modal content does not exceed viewport height */
    overflow: hidden; /* Hide overflow to control content scrolling */
    position: relative; /* Position relative for positioning the close button */
}

.modalll-body {
    overflow-y: auto; /* Scrollable content */
    max-height: calc(80vh - 60px); /* Adjust height to ensure the scrollable area fits */
    padding-right: 15px; /* Prevent content from hiding behind scrollbar */
    text-align: justify; /* Justify text */

}

.close {
    color: #aaa;
    float: right;
    font-size: 16px; /* Smaller font size for the close button */
    font-weight: bold;
    width: 25px;
    height: 25px;
    text-align: center;
    line-height: 25px;
    border-radius: 50%;
    background-color: #f1f1f1;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    background-color: #e0e0e0;
}

  </style>
</head>
<body>


  <!-- Modal -->
  <div class="modal fade" id="hike_reg_modal" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Hike Registration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="registrationForm" method="POST" action="{{ route('hikingreg.post') }}">
            @csrf
              <!-- Step 1 -->
            <div id="step1" class="step">
              <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" class="form-control" required value="{{ $name }}" placeholder="Name"/>
              </div>
              <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" class="form-control" required value="{{ $email }}" placeholder="Email"/>
              </div>
              <div class="form-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="age" id="age" name="age" class="form-control" required value="{{ $age }}" placeholder="Age"/>
              </div>
              <div class="form-group">
                <i class="fas fa-phone"></i>
                <input type="contact" id="contact" name="contact" class="form-control" required value="{{ $cnum }}" placeholder="Contact Number"/>
              </div>
              <div class="form-group">
                <i class="fas fa-users"></i>
                <input type="number" id="groupSize" name="groupSize" class="form-control" required placeholder="Group Size"/>
              </div>
              <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
            </div>
            <!-- Step 2 -->
            <div id="step2" class="step hidden">
              <div id="groupInputs"></div>
              <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
              <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
            </div>
            <!-- Step 3 -->
            <div id="step3" class="step hidden">
              <div class="form-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" id="date" name="date" class="form-control" required placeholder="Date"/>
              </div>
              <div class="form-group">
                <i class="fas fa-tasks"></i>
                <select id="activities" name="activities" class="form-control" required>
                  <option value="" disabled selected>Select an activity</option>
                  @foreach($activities as $activity)
                    <option value="{{ $activity->activity_id }}">{{ $activity->act_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group form-check d-flex justify-content-center mb-4">
                <input type="checkbox" class="btn-check" id="btncheck1" name="terms" required autocomplete="off">
                <label class="form-check-label" for="btncheck1">
                    I have read and agree to the <a href="#" id="terms-link">terms and conditions</a>
                </label>
  
                    <!-- Terms and Conditions Modal -->
<div id="terms-modalll" class="modalll" style="display: none;">
    <div class="modalll-content">
        <span class="close" id="close-modalll">&times;</span>
        <h1>Terms and Conditions</h1>
        <div class="modalll-body">
            <h2>1. Introduction</h2>
            <p>Welcome to the Mt. Talamitam hiking experience. By registering for a hiking activity with us, you agree to the following Terms and Conditions. Please read them carefully.</p>
            <h2>2. Registration</h2>
            <p>Eligibility: To register, you must be at least 18 years old or have parental consent if under 18.</p>
            <p>Information Accuracy: You must provide accurate and complete information during the registration process, including personal details and contact information.</p>
            <p>Hiking Details: Ensure that the details regarding the number of participants, type of activity, and any special requests are accurately filled out.</p>
            <h2>3. Payment and Fees</h2>
            <p>Fees: All fees associated with the hiking activity, including environmental fees and any additional costs, will be communicated to you before finalizing your registration.</p>
            <p>Payment: Payment must be made in accordance with the instructions provided during the registration process. Failure to complete payment may result in the cancellation of your registration.</p>
            <h2>4. Health and Safety</h2>
            <p>Personal Health: You must be in good health and physically fit to participate in hiking activities. Consult your physician if you have any medical conditions or concerns.</p>
            <p>Equipment: Ensure you bring all necessary equipment and supplies as listed in the “Things to Bring” section. Failure to bring required items may impact your safety and enjoyment of the activity.</p>
            <p>Emergency Contact: Provide a valid emergency contact number in case of any incidents or emergencies during the hike.</p>
            <h2>5. Conduct and Behavior</h2>
            <p>Respect the Environment: Follow all guidelines for environmental preservation and respect the natural surroundings. Leave no trace and dispose of waste properly.</p>
            <p>Group Conduct: Maintain respectful and courteous behavior towards fellow hikers, tour guides, and staff. Disruptive or unsafe behavior will not be tolerated.</p>
            <h2>6. Cancellation and Rescheduling</h2>
            <p>Hiker Cancellations: You may cancel or reschedule your hiking registration by providing advance notice as specified in our cancellation policy. Please check the policy for any applicable fees or conditions.</p>
            <p>Tour Guide Cancellations: In the event that a tour guide cancels, we will make reasonable efforts to provide an alternative guide or reschedule your hike.</p>
            <h2>7. Liability and Insurance</h2>
            <p>Personal Responsibility: You participate in hiking activities at your own risk. We are not liable for any injuries, accidents, or loss of personal belongings that occur during the activity.</p>
            <p>Insurance: We recommend that you have personal insurance coverage for hiking activities. We are not responsible for providing insurance coverage.</p>
            <h2>8. Modifications and Updates</h2>
            <p>Changes to Terms: We reserve the right to modify these Terms and Conditions at any time. Any changes will be communicated to you through our website or other means.</p>
            <p>Activity Changes: We may modify or cancel activities due to unforeseen circumstances such as weather conditions or safety concerns. You will be notified of any changes as soon as possible.</p>
            <h2>9. Contact Information</h2>
            <p>For any questions or concerns regarding these Terms and Conditions, please contact us at [contact information].</p>
            <h2>10. Acceptance</h2>
            <p>By registering for a hiking activity with us, you acknowledge that you have read, understood, and agreed to these Terms and Conditions.</p>
        </div>
    </div>
</div>
  
                
              </div>
              <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Previous</button>
              <button type="button" class="btn btn-primary" onclick="nextStep(4)">Next</button>
            </div>
            <!-- Step 4 (Summary) -->
            <div id="step4" class="step hidden">
              <h5 class="mb-4">Registration Information</h5>
              
              <div class="form-group">
                <i class="fas fa-user"></i>
                <p id="summaryName" class="form-control"></p>
              </div>
              <div class="form-group">
                <i class="fas fa-envelope"></i>
                <p id="summaryEmail" class="form-control"></p>
              </div>
              <div class="form-group">
                <i class="fas fa-birthday-cake"></i>
                <p id="summaryAge" class="form-control"></p>
              </div>
              <div class="form-group">
                <i class="fas fa-phone"></i>
                <p id="summaryContact" class="form-control"></p>
              </div>
              <div class="form-group">
                <i class="fas fa-users"></i>
                <div id="summaryGroupMembers" class="form-control"></div>
              </div>
              <div class="form-group">
                <i class="fas fa-calendar-alt"></i>
                <p id="summaryDate" class="form-control"></p>
              </div>
              <div class="form-group">
                <i class="fas fa-hiking"></i>
                <p id="summaryActivity" class="form-control"></p>
              </div>
              
              <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Previous</button>
              <button type="submit" class="btn btn-primary">Send</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
  <script>
   document.addEventListener('DOMContentLoaded', () => {
    const termsLink = document.getElementById('terms-link');
    const termsModalll = document.getElementById('terms-modalll');
    const closeModalll = document.getElementById('close-modalll');

    termsLink.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        termsModalll.style.display = 'flex'; // Show the modal
    });

    closeModalll.addEventListener('click', () => {
        termsModalll.style.display = 'none'; // Hide the modal
    });

    window.addEventListener('click', (event) => {
        if (event.target === termsModalll) {
            termsModalll.style.display = 'none'; // Hide the modal if clicked outside
        }
    });
});


    function nextStep(step) {
        if (step === 4) {
            const termsCheckbox = document.getElementById('btncheck1');
            if (!termsCheckbox.checked) {
                Swal.fire({
                    title: 'Info!',
                    text: 'You must agree to the terms and conditions before proceeding.',
                    icon: 'info',
                    timer: 3000, // Auto close after 3 seconds
                    showConfirmButton: false
                });
                return; // Do not proceed to the next step
            }
        }

        if (step === 2) {
            const groupSize = document.getElementById('groupSize').value;
            const groupInputs = document.getElementById('groupInputs');
            groupInputs.innerHTML = ''; // Clear previous inputs if any
            for (let i = 0; i < groupSize; i++) {
                const div = document.createElement('div');
                div.classList.add('form-group');
                div.innerHTML = `
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="groupMembers[${i}][name]" class="form-control" required placeholder="Hiking Member ${i + 1}"/>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="text" name="groupMembers[${i}][age]" class="form-control" required placeholder="Age"/>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-venus-mars"></i>
                        <input type="text" name="groupMembers[${i}][gender]" class="form-control" required placeholder="Gender"/>
                    </div>
                `;
                groupInputs.appendChild(div);
            }
        }

        if (step === 4) {
            // Populate the summary step with input values
            document.getElementById('summaryName').textContent = document.getElementById('name').value;
            document.getElementById('summaryEmail').textContent = document.getElementById('email').value;
            document.getElementById('summaryAge').textContent = document.getElementById('age').value;
            document.getElementById('summaryContact').textContent = document.getElementById('contact').value;
            
            const groupInputs = document.getElementById('groupInputs');
            const summaryGroupMembers = document.getElementById('summaryGroupMembers');
            summaryGroupMembers.innerHTML = '';
            for (let i = 0; i < groupInputs.children.length; i++) {
                const name = groupInputs.querySelector(`input[name="groupMembers[${i}][name]"]`).value;
                const age = groupInputs.querySelector(`input[name="groupMembers[${i}][age]"]`).value;
                const gender = groupInputs.querySelector(`input[name="groupMembers[${i}][gender]"]`).value;
                summaryGroupMembers.innerHTML += `<p><strong>Member ${i + 1}:</strong> ${name}, ${age}, ${gender}</p>`;
            }
            
            document.getElementById('summaryDate').textContent = document.getElementById('date').value;
            const activitySelect = document.getElementById('activities');
            document.getElementById('summaryActivity').textContent = activitySelect.options[activitySelect.selectedIndex].text;
        }

        document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
        document.getElementById('step' + step).classList.remove('hidden');
    }

    function prevStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
        document.getElementById('step' + step).classList.remove('hidden');
    }

    @if(session('success'))
      Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        timer: 3000, // Auto close after 3 seconds
        showConfirmButton: false
      });
    @endif
  </script>
</body>
</html>
