<div class="modal show d-block" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Order</h5>
                <button type="button" class="btn-close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <select class="form-control mb-2" wire:model="client_id" required>
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->fio }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <h6>Products</h6>
                @foreach ($orderItems as $index => $item)
                    @php
                        $stock = isset($item['product_id'])
                            ? \App\Models\WarehouseMaterial::where('product_id', $item['product_id'])->sum('value')
                            : 1;
                    @endphp
                    <div class="d-flex gap-2 mb-2">
                        <select class="form-control" wire:model="orderItems.{{ $index }}.product_id">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Max:
                                    {{ \App\Models\WarehouseMaterial::where('product_id', $product->id)->where('type', 2)->sum('value') }})
                                </option>
                            @endforeach
                        </select>
                        @error("orderItems.$index.product_id")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <input type="number" class="form-control" placeholder="Quantity"
                            wire:model="orderItems.{{ $index }}.quantity" min="1"
                            max="{{ $stock }}" required>
                        @error("orderItems.$index.quantity")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <button class="btn btn-danger" wire:click="removeOrderItem({{ $index }})">×</button>
                    </div>
                @endforeach
                <button class="btn btn-secondary btn-sm" wire:click="addOrderItem">+ Add Item</button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="closeModal">Close</button>
                <button class="btn btn-primary" wire:click="saveOrder">Save</button>
            </div>
        </div>
    </div>
</div>
