@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Machines List</h3>
            <a href="{{ route('machines.create') }}" class="btn btn-primary btn-sm float-right">Create machine</a>
        </div>

        <div class="card-body">
            @if (session('create'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('create') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('delete') }}
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
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machines as $machine)
                            <tr>
                                <th>{{ $machine->id }}</th>
                                <td>{{ $machine->name }}</td>
                                <td>
                                    <form action="{{ route('machines.status', $machine->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($machine->status == 1)
                                            <input type="hidden" name="id" value="{{ $machine->id }}">
                                            <input type="hidden" name="active" value="0">
                                            <button class="badge bg-success">Active</button>
                                        @else
                                            <input type="hidden" name="id" value="{{ $machine->id }}">
                                            <input type="hidden" name="active" value="1">
                                            <button class="badge bg-danger">Inactive</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('machines.edit', $machine->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('machines.destroy', $machine->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
