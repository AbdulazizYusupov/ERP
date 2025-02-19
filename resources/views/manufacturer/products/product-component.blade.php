<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Products List</h3>
        <button wire:click="openModal" class="btn btn-primary btn-sm float-right">Create Product</button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="100">
                                @else
                                    <span>Image Not Found</span>
                                @endif
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <button wire:click="viewProduct({{ $product->id }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button wire:click="openEditModal({{ $product->id }})" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteProduct({{ $product->id }})" class="btn btn-danger btn-sm">
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
        @include('manufacturer.products.create-modal')
    @endif

    @if ($editModalOpen)
        @include('manufacturer.products.edit-modal')
    @endif

    @if ($viewModalOpen)
        @include('manufacturer.products.view-modal')
    @endif
</div>
