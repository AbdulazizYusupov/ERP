<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Produces List</h3>
        <button wire:click="openModal" class="btn btn-primary btn-sm float-right">Create Produce</button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Count</th>
                        <th>Quality</th>
                        <th>Defect</th>
                        <th>Given time</th>
                        <th>End time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produces as $produce)
                        <tr>
                            <td>{{ $produce->id }}</td>
                            <td>{{ $produce->product->name }}</td>
                            <td>{{ $produce->count }}</td>
                            <td>{{ $produce->quality }}</td>
                            <td>{{ $produce->defect }}</td>
                            <td>{{ $produce->created_at->format('d M, Y h:i A') }}</td>
                            @if ($produce->created_at != $produce->updated_at && $produce->status == 2)
                                <td>{{ $produce->updated_at->format('d M, Y h:i A') }}</td>
                            @else
                                <td>Not end</td>
                            @endif
                            <td>
                                @if ($produce->status == 0)
                                    <span class="badge bg-warning">Send</span>
                                @elseif($produce->status == 1)
                                    <span class="badge bg-info text-dark">Progress</span>
                                @elseif($produce->status == 2)
                                    <span class="badge bg-success">Done</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="viewProduct({{ $produce->id }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($isOpen)
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Produce</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <select class="form-control mb-2" wire:model="product_id">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <input type="number" class="form-control mb-2" placeholder="Count" wire:model="count"
                            max="{{ $maxCount }}" min="1">
                        @error('count')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <h6>Machines & Users</h6>
                        @foreach ($machines as $index => $machineData)
                            <div class="d-flex gap-2 mb-2">
                                <select class="form-control" wire:model="machines.{{ $index }}.machine_id">
                                    <option value="">Select Machine</option>
                                    @foreach ($allMachines as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                                    @endforeach
                                </select>
                                @error("machines.$index.machine_id")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <select class="form-control" wire:model="machines.{{ $index }}.user_id">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error("machines.$index.user_id")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <button class="btn btn-danger"
                                    wire:click="removeMachine({{ $index }})">×</button>
                            </div>
                        @endforeach
                        <button class="btn btn-secondary btn-sm" wire:click="addMachine">+ Add Machine</button>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="closeModal">Close</button>
                        <button class="btn btn-primary" wire:click="store">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($viewModalOpen)
        @include('manufacturer.produces.view')
    @endif
</div>
