<?php
    use App\Models\GuideInfo;
    $guides = GuideInfo::where('status', 'Pending')->get();
?>

<div id="tbol">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center align-middle">ID</th>
                <th class="text-center align-middle">Last Name</th>
                <th class="text-center align-middle">First Name</th>
                <th class="text-center align-middle">Address</th>
                <th class="text-center align-middle">Email</th>
                <th class="text-center align-middle">Contact</th>
                <th class="text-center align-middle">Proof</th>
                <th class="text-center align-middle">Status</th>
                <th class="text-center align-middle">Username</th>
                <th class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guides as $guide_info)
            <tr>
                <td class="text-center align-middle">{{ $guide_info->guide_id }}</td>
                <td class="text-center align-middle">{{ $guide_info->last_name }}</td>
                <td class="text-center align-middle">{{ $guide_info->first_name }}</td>
                <td class="text-center align-middle">{{ $guide_info->address }}</td>
                <td class="text-center align-middle">{{ $guide_info->email }}</td>
                <td class="text-center align-middle">{{ $guide_info->contact_num }}</td>
                <td class="text-center align-middle"><img src="{{ asset('storage/' . $guide_info->proof) }}" alt="Proof Image" style="width: 100px; height: auto;"></td>
                <td class="text-center align-middle">{{ $guide_info->status }}</td>
                <td class="text-center align-middle">{{ $guide_info->username }}</td>
                <td class="text-center align-middle">
                    <a href="#" class="edit-icon" 
                        data-guide-id="{{ $guide_info->guide_id }}"
                        data-guide-last-name="{{ $guide_info->last_name }}"
                        data-guide-first-name="{{ $guide_info->first_name }}"
                        data-guide-address="{{ $guide_info->address }}"
                        data-guide-email="{{ $guide_info->email }}"
                        data-guide-contact="{{ $guide_info->contact_num }}"
                        data-guide-proof="{{ asset('storage/' . $guide_info->proof) }}"
                        data-guide-status="{{ $guide_info->status }}"
                        data-guide-username="{{ $guide_info->username }}">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('accepting');
    const imagePreviewModalElement = document.getElementById('imagePreviewModal');
    const imagePreview = document.getElementById('imagePreview');
    const editButtons = document.querySelectorAll('.edit-icon');
    const proofImages = document.querySelectorAll('#guideProof');

    // Utility function to remove all backdrops
    function removeAllBackdrops() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
    }

    // Show main modal with guide details
    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Capture the data attributes from the clicked button
            const guideId = this.getAttribute('data-guide-id');
            const lastName = this.getAttribute('data-guide-last-name');
            const firstName = this.getAttribute('data-guide-first-name');
            const address = this.getAttribute('data-guide-address');
            const email = this.getAttribute('data-guide-email');
            const contact = this.getAttribute('data-guide-contact');
            const proof = this.getAttribute('data-guide-proof');
            const status = this.getAttribute('data-guide-status');

            // Update the modal's content with the captured data
            modalElement.querySelector('#guideID').textContent = guideId;
            modalElement.querySelector('#guideName').textContent = `${firstName} ${lastName}`;
            modalElement.querySelector('#guideAddress').textContent = address;
            modalElement.querySelector('#guideEmail').textContent = email;
            modalElement.querySelector('#guideContact').textContent = contact;
            modalElement.querySelector('#guideProof').setAttribute('src', proof);
            modalElement.querySelector('#guideStatus').textContent = status;

            const modal = new bootstrap.Modal(modalElement, {
                backdrop: false
            });
            modal.show();

            // Listen for when the modal is hidden, and remove backdrops
            modalElement.addEventListener('hidden.bs.modal', removeAllBackdrops, { once: true });
        });
    });

    // Trigger image preview modal when proof image is clicked
    proofImages.forEach(proofImage => {
        proofImage.addEventListener('click', function() {
            const proofSrc = this.getAttribute('src');
            imagePreview.setAttribute('src', proofSrc);
            const imagePreviewModal = new bootstrap.Modal(imagePreviewModalElement, {
                backdrop: false
            });
            imagePreviewModal.show();

            // Listen for when the image preview modal is hidden, and remove backdrops
            imagePreviewModalElement.addEventListener('hidden.bs.modal', function() {
                removeAllBackdrops();
                const acceptingModal = bootstrap.Modal.getInstance(modalElement);
                if (acceptingModal) {
                    acceptingModal.show();
                }
            }, { once: true });
        });
    });

    // Ensure backdrops are removed when any modal is closed
    const allModals = document.querySelectorAll('.modal');
    allModals.forEach(modal => {
        modal.addEventListener('hidden.bs.modal', removeAllBackdrops, { once: true });
    });
});
</script>
