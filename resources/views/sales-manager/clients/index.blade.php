@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Clients List</h3>
            <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm float-right">Create client</a>
        </div>

        <div class="card-body">
            @foreach (['create' => 'primary', 'delete' => 'danger', 'update' => 'info'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full name</th>
                            <th>Phone</th>
                            <th>Balance</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <th>{{ $client->id }}</th>
                                <td>{{ $client->fio }}</td>
                                <td>{{ $client->phone }}</td>
                                <td><span class="badge bg-success">{{ $client->balance }} so'm</span></td>
                                <td>
                                    @if ($client->latitude && $client->longitude)
                                        <a href="https://www.google.com/maps?q={{ $client->latitude }},{{ $client->longitude }}"
                                            target="_blank" class="btn btn-link text-primary" data-bs-toggle="tooltip"
                                            title="{{ $client->address }}">
                                            {{ Str::limit($client->address, 30) }} 📍
                                        </a>
                                    @else
                                        <span data-bs-toggle="tooltip" title="{{ $client->address }}">
                                            {{ Str::limit($client->address, 30) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
