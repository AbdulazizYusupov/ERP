@if ($viewModalOpen)
    <div class="modal show d-block" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Produce Details - {{ $viewProduce->product->name }} (ID: {{ $viewProduce->id }})
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Count:</strong> {{ $viewProduce->count }}</p>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Machine</th>
                                <th>User</th>
                                <th>Count</th>
                                <th>Quality</th>
                                <th>Defect</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($viewMachines as $machineProduce)
                                <tr>
                                    <td>{{ $machineProduce->machine->name }}</td>
                                    <td>{{ $machineProduce->user->name }}</td>
                                    <td>{{ $machineProduce->count }}</td>
                                    <td>{{ $machineProduce->quality }}</td>
                                    <td>{{ $machineProduce->defect }}</td>
                                    <td>{{ $machineProduce->created_at->format('d M, Y h:i A') }}</td>
                                    @if ($machineProduce->created_at != $machineProduce->updated_at && $machineProduce->status == 2)
                                        <td>{{ $machineProduce->updated_at->format('d M, Y h:i A') }}</td>
                                    @else
                                        <td>Not end</td>
                                    @endif
                                    <td>
                                        @if ($machineProduce->status == 0)
                                            <span class="badge bg-warning">Send</span>
                                        @elseif($machineProduce->status == 1)
                                            <span class="badge bg-info text-dark">Progress</span>
                                        @elseif($machineProduce->status == 2)
                                            <span class="badge bg-success">Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="closeViewModal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
