<div class="modal show d-block" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Product Materials</h5>
                <button type="button" class="btn-close" wire:click="closeViewModal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($viewMaterials as $material)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $material['name'] }}</span>
                            <span>{{ $material['value'] }} {{ $material['unit'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="closeViewModal">Close</button>
            </div>
        </div>
    </div>
</div>
