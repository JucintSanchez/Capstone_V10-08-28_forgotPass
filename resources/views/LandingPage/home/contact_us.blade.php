<?php
    use App\Models\HomeSettings;
    use App\Models\Organization;

    $homeSettings = HomeSettings::first();
    // Find the corresponding Organization record based on org_id
    $organization = Organization::where('org_id', $homeSettings->org_id)->first();
?>

<style>
        .title {
            color: black;
        }
        .description {
            color: white;
            font-weight: 400;
        }
        .input-group-text {
            background-color: white;
            width: 3rem;
        }
        .form-control {
            color: black;
            font-weight: 400;
        }
        .contact-info {
            margin-top: 2rem;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .contact-item i {
            margin-right: 0.5rem;
        }
        @media (max-width: 767.98px) {
            .contact-info {
                margin-top: 0;
            }
        }
    </style>
    <div class="container">
    <div class="row">
        <!-- Left Column: Contact Form -->
        <div class="col-lg-6 col-md-12 mb-4">
            <h2 class="title">For Any Inquiries</h2>
            <p class="description">You are very important to us.</p>
            <div class="input-group input-lg mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="First Name...">
            </div>
            <div class="input-group input-lg mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="now-ui-icons ui-1_email-85"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="Email...">
            </div>
            <div class="textarea-container mb-3">
                <textarea class="form-control" name="name" rows="4" cols="80" placeholder="Type a message..."></textarea>
            </div>
            <div class="send-button">
                <a href="#pablo" class="btn btn-primary btn-round btn-block btn-lg">Send Message</a>
            </div>
        </div>

        <!-- Right Column: Contact Information -->
        <div class="col-lg-6 col-md-12">
            <h2 class="title" style="color: white;">Contact Us</h2>
            <p class="description">Contact us for questions, technical assistance, or collaboration opportunities via the contact information provided.</p>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="now-ui-icons tech_mobile"></i>
                    <span>{{ $homeSettings->contact_num }}</span>
                </div>
                <div class="contact-item">
                    <i class="now-ui-icons ui-1_email-85"></i>
                    <span>{{ $homeSettings->email }}</span>
                </div>
                <div class="contact-item">
                    <i class="now-ui-icons location_pin"></i>
                    <span>{{ $organization->address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
