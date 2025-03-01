<div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" wire:click="closeModal" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Client:</strong> {{ $selectedOrder->client->fio }}</p>
                <p><strong>Date:</strong> {{ $selectedOrder->date }}</p>
                <p><strong>Status:</strong> {{ $selectedOrder->status }}</p>
                <p><strong>Total:</strong> {{ number_format($selectedOrder->total, 2) }} so'm</p>
                <h6>Products:</h6>
                <ul>
                    @foreach ($selectedOrder->order_items as $item)
                        <li>{{ $item->product->name }} - {{ $item->count }} pcs</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
