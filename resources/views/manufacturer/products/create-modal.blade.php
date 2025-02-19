<div class="modal show d-block" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Product</h5>
                <button type="button" class="btn-close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-2" placeholder="Product Name" wire:model="name" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <input type="number" class="form-control mb-2" placeholder="Price" wire:model="price" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <input type="file" class="form-control mb-2" wire:model="image" required>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <h6>Materials</h6>
                @foreach ($materials as $index => $material)
                    <div class="d-flex gap-2 mb-2">
                        <select class="form-control" wire:model="materials.{{ $index }}.material_id" required>
                            <option value="">Select Material</option>
                            @foreach ($materialsList as $mat)
                                <option value="{{ $mat->id }}">{{ $mat->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" class="form-control" placeholder="Value"
                            wire:model="materials.{{ $index }}.value" required>
                        <button class="btn btn-danger" wire:click="removeMaterial({{ $index }})">×</button>
                    </div>
                @endforeach
                <button class="btn btn-secondary btn-sm" wire:click="addMaterial">+ Add Material</button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="closeModal">Close</button>
                <button class="btn btn-primary" wire:click="saveProduct">Save</button>
            </div>
        </div>
    </div>
</div>
