<div>
    <div class="content-wrapper kanban">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>All Produces</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content pb-3">
            <div class="container-fluid h-100">
                <div class="card card-row card-secondary" style="width: 400px">
                    <div class="card-header">
                        <h3 class="card-title">Produces</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($produces as $produce)
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Produce #{{ $produce->id }}</h5>
                                    <div class="card-tools">
                                        <button wire:click="show({{ $produce->id }})" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($allow1 == $produce->id)
                                    <div class="card-body">
                                        <div>
                                            <label>
                                                {{ $produce->machine->name }} - {{ $produce->count }}
                                                {{ $produce->produce->product->name }}
                                            </label>
                                        </div>
                                        <button wire:click="moveToProcessing({{ $produce->id }})"
                                            class="btn btn-primary btn-sm mt-2">
                                            Move to Processing
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card card-row card-primary" style="width: 400px">
                    <div class="card-header">
                        <h3 class="card-title">Processing</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($processes as $process)
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Produce #{{ $process->id }}</h5>
                                    <div class="card-tools">
                                        <button wire:click="ruxsat({{ $process->id }})" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($allow2 == $process->id)
                                    <div class="card-body">
                                        <div>
                                            <label>
                                                {{ $process->machine->name }} - {{ $process->count }}
                                                {{ $process->produce->product->name }}
                                            </label>
                                        </div>
                                        <input type="number" wire:model="defect" placeholder="Defect count"
                                            class="form-control mt-2">
                                        <button wire:click="moveToNextMachine({{ $process->id }})"
                                            class="btn btn-primary btn-sm mt-2">
                                            Move to Next Machine
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card card-row card-success" style="width: 400px">
                    <div class="card-header">
                        <h3 class="card-title">Completed</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($dones as $done)
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Produce #{{ $done->id }}</h5>
                                    <div class="card-tools">
                                        <button wire:click="consent({{ $done->id }})" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($allow3 == $done->id)
                                    <div class="card-body">
                                        <div class="card mb-3 p-3 border shadow-sm">
                                            <h5 class="fw-bold text-primary">{{ $done->machine->name }}</h5>
                                            <p><strong>Produced:</strong> {{ $done->count }}</p>
                                            <p><strong>Defect:</strong> {{ $done->defect }}</p>
                                            <p><strong>Quality:</strong> {{ $done->count - $done->defect }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
