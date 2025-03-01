@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Create Client</h3>
            <a href="{{ route('clients.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="fio" class="form-label">Client Full Name</label>
                    <input type="text" class="form-control @error('fio') is-invalid @enderror" name="fio"
                        id="fio" value="{{ old('fio') }}">
                    @error('fio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Client Phone Number</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        id="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Client Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                        id="address" value="{{ old('address') }}" readonly>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Client</button>
            </form>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <!-- Nominatim (Osm geokoding) -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var defaultLocation = [41.3111, 69.2406]; // Tashkent koordinatalari
            var map = L.map('map').setView(defaultLocation, 12);

            // OpenStreetMap qatlamini qo'shish
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker(defaultLocation, {
                draggable: true
            }).addTo(map);

            function updateAddress(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById('address').value = data.display_name;
                        } else {
                            document.getElementById('address').value = "Address not found";
                        }
                    })
                    .catch(() => {
                        document.getElementById('address').value = "Error fetching address";
                    });
            }

            marker.on('dragend', function(event) {
                var position = marker.getLatLng();
                updateAddress(position.lat, position.lng);
            });

            map.on('click', function(event) {
                var latlng = event.latlng;
                marker.setLatLng(latlng);
                updateAddress(latlng.lat, latlng.lng);
            });
        });
    </script>
@endsection
