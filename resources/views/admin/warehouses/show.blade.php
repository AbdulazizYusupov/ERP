@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Materials List</h3>
            <a href="{{ route('warehouses.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('update') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity & unit</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sklads as $sklad)
                            <tr>
                                @if ($sklad->type == 2)
                                    <th>{{ $sklad->id }}</th>
                                    <td>{{ $sklad->product->name }}</td>
                                    <td>{{ number_format($sklad->product->price) }} so'm</td>
                                    <td>{{ $sklad->value }} piece</td>
                                    <td>{{ number_format($sklad->product->price * $sklad->value) }} so'm</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#transferModal{{ $sklad->id }}">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        <div class="modal fade" id="transferModal{{ $sklad->id }}" tabindex="-1"
                                            aria-labelledby="transferModalLabel{{ $sklad->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transferModalLabel{{ $sklad->id }}">
                                                            Transfer
                                                            Material</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('warehouses.transfer') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="material_id"
                                                                value="{{ $sklad->material->id }}">
                                                            <input type="hidden" name="real"
                                                                value="{{ $sklad->warehouse_id }}">
                                                            <input type="hidden" name="type" value="2">

                                                            <div class="form-group">
                                                                <label for="warehouse_id">Select Warehouse</label>
                                                                <select name="warehouse_id" id="warehouse_id"
                                                                    class="form-control">
                                                                    <option value="">Choose warehouse</option>
                                                                    @foreach ($warehouses as $warehouse)
                                                                        <option value="{{ $warehouse->id }}">
                                                                            {{ $warehouse->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity">Quantity</label>
                                                                <input type="number" name="quantity" class="form-control"
                                                                    min="1" max="{{ $sklad->value }}" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-success">Transfer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <th>{{ $sklad->material->entry_materials->first()->id }}</th>
                                    <td>{{ $sklad->material->name }}</td>
                                    <td>{{ number_format($sklad->material->entry_materials->first()->price) }} so'm</td>
                                    <td>{{ number_format($sklad->value) }}
                                        {{ $sklad->material->entry_materials->first()->unit }}</td>
                                    <td>{{ number_format($sklad->material->entry_materials->first()->price * $sklad->value) }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#transferModal{{ $sklad->id }}">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        <div class="modal fade" id="transferModal{{ $sklad->id }}" tabindex="-1"
                                            aria-labelledby="transferModalLabel{{ $sklad->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transferModalLabel{{ $sklad->id }}">
                                                            Transfer
                                                            Material</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('warehouses.transfer') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="material_id"
                                                                value="{{ $sklad->material->id }}">
                                                            <input type="hidden" name="real"
                                                                value="{{ $sklad->warehouse_id }}">

                                                            <div class="form-group">
                                                                <label for="warehouse_id">Select Warehouse</label>
                                                                <select name="warehouse_id" id="warehouse_id"
                                                                    class="form-control">
                                                                    <option value="">Choose warehouse</option>
                                                                    @foreach ($warehouses as $warehouse)
                                                                        <option value="{{ $warehouse->id }}">
                                                                            {{ $warehouse->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity">Quantity
                                                                    {{ $sklad->material->entry_materials->first()->unit }}</label>
                                                                <input type="number" name="quantity"
                                                                    class="form-control" min="1"
                                                                    max="{{ $sklad->value }}" required>
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-success">Transfer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
