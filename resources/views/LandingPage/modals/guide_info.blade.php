<!-- Guide Info Modal -->
<div class="modal fade" id="guideInfoModal" tabindex="-1" aria-labelledby="guideInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guideInfoModalLabel">Guide Information</h5>
                <button type="button" class="btn-close" id="closeModalButton" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Guide information will be populated here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalFooterButton">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('closeModalButton').onclick = function() {
        $('#guideInfoModal').modal('hide');
    };

    document.getElementById('closeModalFooterButton').onclick = function() {
        $('#guideInfoModal').modal('hide');
    };
</script>
