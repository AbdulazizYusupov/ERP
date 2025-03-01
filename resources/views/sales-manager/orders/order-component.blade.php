<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Orders List</h3>
        <button wire:click="openModal" class="btn btn-primary btn-sm float-right">Create Order</button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->client->fio }}</td>
                            <td>{{ $order->date }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $order->status == 'Completed' ? 'success' : ($order->status == 'Pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ number_format($order->total, 2) }} so'm</td>
                            <td>
                                <button wire:click="openViewModal({{ $order->id }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button wire:click="openEditModal({{ $order->id }})" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteOrder({{ $order->id }})" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($modalOpen)
        @include('sales-manager.orders.create-modal')
    @endif

    @if ($editModalOpen)
        @include('sales-manager.orders.edit-modal')
    @endif

    @if ($viewModalOpen)
        @include('sales-manager.orders.view-modal')
    @endif
</div>
