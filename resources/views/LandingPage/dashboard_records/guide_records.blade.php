<?php
    use App\Models\GuideInfo;
    $guides = GuideInfo::whereIn('status', ['Accepted', 'Rejected'])->get();
?>

<div id="guide_record">
    <table class="table table-responsive table-hover">
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
        const editIcons = document.querySelectorAll('.edit-icon');

        editIcons.forEach(icon => {
            const status = icon.getAttribute('data-guide-status');

            if (status === 'Rejected') {
                icon.style.display = 'none';  // Hide the edit icon
            } else {
                icon.style.display = 'inline-block';  // Show the edit icon
            }
        });
    });
</script>
