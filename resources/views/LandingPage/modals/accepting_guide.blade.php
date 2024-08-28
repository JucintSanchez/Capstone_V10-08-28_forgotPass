@extends('LandingPage.layouts.dashboardlayout')

@section('content')
<!-- Modal for Accepting Guide -->
<div class="modal fade" id="accepting" tabindex="-1" aria-labelledby="acceptingLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Guide Info</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Guide ID:</b> <span id="guideID"></span></p>
        <p><b>Name:</b> <span id="guideName"></span></p>
        <p><b>Address:</b> <span id="guideAddress"></span></p>
        <p><b>Email:</b> <span id="guideEmail"></span></p>
        <p><b>Contact:</b> <span id="guideContact"></span></p>
        <p><b>Proof:</b> <img id="guideProof" style="width: 100px; height: auto; cursor: pointer;" alt="Proof Image"
                               data-bs-toggle="modal" data-bs-target="#imagePreviewModal"></p>
        <p><b>Status:</b> <span id="guideStatus"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="#" type="button" id="accept" class="btn btn-primary">Hire</a>
        <a href="#" type="button" id="reject" class="btn btn-danger">Reject</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

function edit_disable() {
    const editButtons = document.querySelectorAll('.edit-icon');

    editButtons.forEach(button => {
        const status = button.getAttribute('data-guide-status');
        
        if (status === 'Rejected') {
            button.style.display = 'none';  // Hide the edit button
        } else {
            button.style.display = 'inline-block';  // Show the edit button
        }
    });
}


    function openModal(guide) {
        $('#guideID').text(guide.id);
        $('#guideName').text(guide.name);
        $('#guideAddress').text(guide.address);
        $('#guideEmail').text(guide.email);
        $('#guideContact').text(guide.contact);
        $('#guideProof').attr('src', guide.proof);
        $('#guideStatus').text(guide.status);
        $('#accept').data('guide-id', guide.id);

        if (guide.status === 'Accepted') {
            $('#accept').hide();
        } else {
            $('#accept').show();
        }

        $('#accepting').modal('show');
    }

    $(document).ready(function() {
        function bindEditButtons() {
            $('.edit-icon').off('click').on('click', function(event) {
                event.preventDefault();

                var guide = {
                    id: $(this).data('guide-id'),
                    name: $(this).data('guide-first-name') + ' ' + $(this).data('guide-last-name'),
                    address: $(this).data('guide-address'),
                    email: $(this).data('guide-email'),
                    contact: $(this).data('guide-contact'),
                    proof: $(this).data('guide-proof'),
                    status: $(this).data('guide-status')
                };
                openModal(guide);
            });
        }

        $('#accept').on('click', function(e) {
            e.preventDefault();
            
            var guideId = $('#guideID').text();
            console.log('Guide ID on click:', guideId);  // For debugging

            $.ajax({
                url: '{{ route("guide.accept") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    guide_id: guideId
                },
                success: function(response) {
                    // Update the status text in the modal
                    $('#guideStatus').text('Accepted');

                    // Close the modal
                    $('#accepting').modal('hide');

                    swal("Accepted", "Guide Successfully Accepted!", "success").then(function () {
                        // Reload the table content dynamically
                        $('#tbol').load(location.href + " #tbol", function() {
                            bindEditButtons();
                            edit_disable();
                        });
                        $('#guide_record').load(location.href + " #guide_record", function() {
                            bindEditButtons();
                        });
                    });
                },
            });
        });

        $('#reject').on('click', function(e) {
            e.preventDefault();
            
            var guideId = $('#guideID').text();
            console.log('Guide ID on click:', guideId);  // For debugging

            $.ajax({
                url: '{{ route("guide.reject") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    guide_id: guideId
                },
                success: function(response) {
                    // Update the status text in the modal
                    $('#guideStatus').text('Rejected');

                    // Close the modal
                    $('#accepting').modal('hide');

                    swal("Rejected", "Guide has been rejected!", "error").then(function () {
                        // Reload the table content dynamically
                        $('#tbol').load(location.href + " #tbol", function() {
                            bindEditButtons();
                        });
                        $('#guide_record').load(location.href + " #guide_record", function() {
                            bindEditButtons();
                            edit_disable();
                        });
                    });
                },
            });
        });

        // Initial binding of edit buttons
        bindEditButtons();
    });
</script>

@endsection
