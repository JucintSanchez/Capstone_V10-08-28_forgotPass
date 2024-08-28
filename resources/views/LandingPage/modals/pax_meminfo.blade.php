<?php
    use App\Models\PaxMember;
    $members = PaxMember::all();
?>

<!-- Modal -->
<div class="modal fade" id="hikingRegistrationModal" tabindex="-1" aria-labelledby="hikingRegistrationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hikingRegistrationModalLabel">Pax Members</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="thead-light" style = "background-color: rgba(152, 255, 152, 0.8);">
              <tr>
                <th class="text-center align-middle">Name</th>
                <th class="text-center align-middle">Age</th>
                <th class="text-center align-middle">Gender</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
              <tr class="text-center align-middle">
                <td>{{ $member->member_name }}</td>
                <td>{{ $member->age }}</td>
                <td>{{ $member->gender }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
