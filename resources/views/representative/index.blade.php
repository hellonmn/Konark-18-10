<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-pink-500 to-pink-700 text-white p-6 rounded-lg shadow-lg">
            <h2 class="font-bold text-2xl drop-shadow-md">
                Details for {{ $representative->name }}
            </h2>
            <a href="{{ route('representatives.show') }}" class="bg-white text-pink-600 px-4 py-2 rounded-md hover:bg-pink-100 hover:text-pink-800 flex items-center transition duration-300 shadow-sm">
                <i class="fi fi-sr-arrow-left mr-2"></i> Back to Representatives
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <button onclick="getLocation()" class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
            Punch My Location
        </button>
            

            <!-- Doctors Accordion Section -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden" x-data="{ accordionOpen: true, viewMode: 'cards' }">
                <!-- Accordion Header -->
                <div @click="accordionOpen = !accordionOpen" 
                     class="px-6 py-5 bg-gradient-to-r from-pink-50 to-pink-100 border-b border-pink-200 flex justify-between items-center cursor-pointer hover:bg-pink-100 transition-colors duration-200">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fi fi-sr-stethoscope mr-2 text-pink-600"></i>
                        Linked Doctors <span class="ml-2 bg-pink-200 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $doctor_count }}</span>
                    </h3>
                    <div class="flex items-center space-x-2">
                        <!-- Dropdown Filter Button -->
                        <div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
                            <button @click.stop="open = !open" type="button" class="inline-flex items-center justify-center gap-2 bg-white text-pink-600 border border-pink-300 px-4 py-2 rounded-md hover:bg-pink-50 transition duration-300 shadow-sm">
                                <i class="fi fi-sr-filter"></i> 
                                Filter
                                <i class="fi fi-sr-angle-down text-xs"></i>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-cloak
                                 class="absolute right-0 z-10 mt-2 w-72 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 @click.stop="">
                                <form method="GET" action="{{ route('representatives.details', $representative->id) }}" class="p-4" style="grid-template-columns: repeat(1, minmax(0, 1fr));">
                                    <div class="space-y-4">
                                        <h4 class="text-sm font-medium text-gray-700 border-b border-gray-200 pb-2">Filter by Date Range</h4>
                                        <div>
                                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                                class="mt-1 block w-full rounded-md border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                                class="mt-1 block w-full rounded-md border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm">
                                        </div>
                                        <div class="flex space-x-2 pt-2 border-t border-gray-200">
                                            <button type="submit" class="flex-1 bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700 transition duration-200 shadow-sm text-sm">
                                                Apply Filter
                                            </button>
                                            <a href="{{ route('representatives.details', $representative->id) }}"
                                                class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-200 shadow-sm text-sm text-center">
                                                Clear
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- View Toggle Buttons -->
                        <div class="flex border border-pink-300 rounded-md overflow-hidden shadow-sm" @click.stop>
                            <button @click="viewMode = 'cards'" type="button" class="px-3 py-2 flex items-center justify-center transition-colors" :class="viewMode === 'cards' ? 'bg-pink-600 text-white' : 'bg-white text-pink-600 hover:bg-pink-50'">
                                <i class="fi fi-sr-apps"></i>
                            </button>
                            <button @click="viewMode = 'table'" type="button" class="px-3 py-2 flex items-center justify-center transition-colors" :class="viewMode === 'table' ? 'bg-pink-600 text-white' : 'bg-white text-pink-600 hover:bg-pink-50'">
                                <i class="fi fi-sr-list"></i>
                            </button>
                        </div>
                        <!-- Accordion Toggle -->
                        <button class="bg-white text-pink-600 p-2 rounded-full border border-pink-300 hover:bg-pink-50 transition duration-300 shadow-sm flex items-center justify-center">
                            <i class="fi" :class="accordionOpen ? 'fi-sr-angle-up' : 'fi-sr-angle-down'"></i>
                        </button>
                    </div>
                </div>
                <!-- Active Filters Display -->
                <div x-show="accordionOpen">
                    @if(request('start_date') || request('end_date'))
                        <div class="bg-pink-50 px-6 py-2 border-b border-pink-200">
                            <div class="flex items-center text-sm text-pink-700">
                                <i class="fi fi-sr-filter mr-2"></i>
                                <span>Filtered by date: 
                                    {{ request('start_date') ? request('start_date') : 'Any' }} 
                                    to 
                                    {{ request('end_date') ? request('end_date') : 'Present' }}
                                </span>
                                <a href="{{ route('representatives.details', $representative->id) }}" class="ml-auto text-pink-600 hover:text-pink-800">
                                    <i class="fi fi-sr-cross-circle"></i> Clear filters
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- Content Area -->
                    <div class="p-6" x-show="accordionOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @if ($doctors->isEmpty())
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fi fi-sr-user-md text-2xl text-pink-400"></i>
                                </div>
                                <p class="text-gray-500 text-sm">No doctors linked to this representative.</p>
                                <p class="text-gray-400 text-xs mt-2">Try adjusting your filters or add new doctors</p>
                            </div>
                        @else
                            <!-- Cards View -->
                            <div x-show="viewMode === 'cards'" x-transition>
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach ($doctors as $doctor)
                                        <div class="bg-white border border-pink-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 p-5 hover:bg-pink-50">
                                            <div class="flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-full flex items-center justify-center text-lg font-bold shadow-sm">
                                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-800">{{ $doctor->name }}</h4>
                                                        <p class="text-sm text-gray-500 flex items-center">
                                                            <i class="fi fi-sr-building-hospital mr-1 text-pink-400"></i>
                                                            {{ $doctor->clinic_name ?? 'No clinic specified' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    
                                                </div>
                                            </div>
                                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                                <div class="bg-pink-50 p-3 rounded-lg">
                                                    <p class="flex items-center"><i class="fi fi-sr-envelope mr-2 text-pink-600"></i> {{ $doctor->email ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-pink-50 p-3 rounded-lg">
                                                    <p class="flex items-center"><i class="fi fi-brands-whatsapp mr-2 text-pink-600"></i> {{ $doctor->phone ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-pink-50 p-3 rounded-lg">
                                                    <p class="flex items-center"><i class="fi fi-sr-marker mr-2 text-pink-600"></i> {{ $doctor->clinic_location ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-pink-50 p-3 rounded-lg">
                                                    <p class="flex items-center"><i class="fi fi-sr-comment mr-2 text-pink-600"></i> {{ $doctor->meeting_purpose ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Table View -->
                            <div x-show="viewMode === 'table'" x-transition>
                                <div class="overflow-x-auto rounded-lg border border-pink-200">
                                    <table class="min-w-full divide-y divide-pink-200">
                                        <thead class="bg-pink-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clinic</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-pink-200">
                                            @foreach ($doctors as $doctor)
                                                <tr class="hover:bg-pink-50 transition-colors duration-200">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                                                                {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                                            </div>
                                                            <span class="text-sm font-medium text-gray-900">{{ $doctor->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $doctor->clinic_name ?? 'N/A' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <div class="flex flex-col">
                                                            <span class="flex items-center"><i class="fi fi-sr-envelope mr-1 text-pink-400"></i> {{ $doctor->email ?? 'N/A' }}</span>
                                                            <span class="flex items-center mt-1"><i class="fi fi-brands-whatsapp mr-1 text-pink-400"></i> {{ $doctor->phone ?? 'N/A' }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $doctor->clinic_location ?? 'N/A' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $doctor->meeting_purpose ?? 'N/A' }}</td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Location History Accordion Section -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden" x-data="{ accordionOpen: false }">
                <!-- Accordion Header -->
                <div @click="accordionOpen = !accordionOpen" 
                     class="px-6 py-5 bg-gradient-to-r from-pink-50 to-pink-100 border-b border-pink-200 flex justify-between items-center cursor-pointer hover:bg-pink-100 transition-colors duration-200">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fi fi-sr-map-marker-home mr-2 text-pink-600"></i>
                        Location History
                    </h3>
                    <div class="flex items-center space-x-2">
                        <!-- Map Toggle Button -->
                        <button id="toggle-map-btn" @click.stop type="button" class="bg-white text-pink-600 border border-pink-300 px-4 py-2 rounded-md hover:bg-pink-50 transition duration-300 shadow-sm flex items-center gap-2">
                            <i class="fi fi-sr-map"></i> 
                            <span id="map-button-text">Show Map</span>
                        </button>
                        <!-- Accordion Toggle -->
                        <button class="bg-white text-pink-600 p-2 rounded-full border border-pink-300 hover:bg-pink-50 transition duration-300 shadow-sm flex items-center justify-center">
                            <i class="fi" :class="accordionOpen ? 'fi-sr-angle-up' : 'fi-sr-angle-down'"></i>
                        </button>
                    </div>
                </div>

                <!-- Map Container (Always available) -->
                <div id="map-container" class="p-6 hidden border-b border-pink-200">
                    <div id="location-map" class="h-96 w-full rounded-lg border border-pink-300 shadow-sm"></div>
                </div>

                <!-- Location History Content -->
                <div class="p-6" x-show="accordionOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @if ($locations->isEmpty())
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fi fi-sr-map-marker text-2xl text-pink-400"></i>
                            </div>
                            <p class="text-gray-500 text-sm">No location history available for this representative.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto bg-white rounded-lg border border-pink-200">
                            <table class="min-w-full divide-y divide-pink-200">
                                <thead class="bg-pink-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordinates</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-pink-200">
                                    @foreach ($locations as $location)
                                        <tr class="hover:bg-pink-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $location->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $location->type == 'Check-in' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $location->type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <span class="location-address" data-lat="{{ $location->latitude }}" data-lng="{{ $location->longitude }}">
                                                    Loading...
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ number_format($location->latitude, 7) }}, {{ number_format($location->longitude, 7) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <button class="show-map-btn bg-pink-600 text-white px-3 py-1 rounded-md hover:bg-pink-700 transition duration-200 shadow-sm text-sm" 
                                                        data-lat="{{ $location->latitude }}" 
                                                        data-lng="{{ $location->longitude }}" 
                                                        data-type="{{ $location->type }}" 
                                                        data-date="{{ $location->created_at->format('Y-m-d H:i:s') }}"
                                                        data-address-id="address-{{ $location->id }}">
                                                    <i class="fi fi-sr-map-marker mr-1"></i> Show on Map
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Include Uicons, Leaflet, Alpine.js and doctorform.css -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-brands/css/uicons-brands.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('/assets/css/doctorform.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <!-- Custom CSS for Animations and Pink Theme -->
    <style>
        [x-cloak] { display: none !important; }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .leaflet-popup-content-wrapper {
            background-color: #fce7f3;
            color: #831843;
            border-radius: 8px;
        }
        .leaflet-popup-tip {
            background-color: #fce7f3;
        }
        .text-sm {
            font-size: 0.875rem;
        }
        .text-lg {
            font-size: 1.125rem;
        }
        .hover\:scale-105:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #ec4899;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #db2777;
        }
        @media (max-width: 640px) {
            .sm\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
        .location-address {
            min-width: 200px;
            display: inline-block;
        }
    </style>
    
    <script>
    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            fetch('/api/save-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                })
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! Status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Failed to save location. Please try again.');
            });
        }, function(error) {
            alert('Geolocation error: ' + error.message);
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }
}
</script>

    <!-- Map Initialization and Geocoding Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let map = null;
            const mapContainer = document.getElementById('map-container');
            const locationMap = document.getElementById('location-map');
            const toggleMapBtn = document.getElementById('toggle-map-btn');
            const mapButtonText = document.getElementById('map-button-text');
            const showMapButtons = document.querySelectorAll('.show-map-btn');
            let markers = [];
            let isMapVisible = false;

            // Cache for geocoded addresses
            const addressCache = {};

            // Function to fetch human-readable address
            async function fetchAddress(lat, lng, element, popupId = null) {
                const cacheKey = `${lat},${lng}`;
                if (addressCache[cacheKey]) {
                    updateAddress(element, addressCache[cacheKey], popupId);
                    return;
                }

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&zoom=14`);
                    const data = await response.json();
                    let address = 'Unknown location';
                    if (data && data.display_name) {
                        address = data.display_name;
                    }
                    addressCache[cacheKey] = address;
                    updateAddress(element, address, popupId);
                } catch (error) {
                    console.error('Error fetching address:', error);
                    updateAddress(element, 'Failed to load address', popupId);
                }
            }

            // Function to update address in UI
            function updateAddress(element, address, popupId) {
                if (element) {
                    element.textContent = address;
                }
                if (popupId && document.getElementById(popupId)) {
                    document.getElementById(popupId).textContent = address;
                }
            }

            // Initialize map function
            function initializeMap() {
                map = L.map('location-map').setView([0, 0], 2);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
            }

            // Add all markers function
            function addAllMarkers() {
                markers.forEach(marker => map.removeLayer(marker));
                markers = [];
                const bounds = L.latLngBounds();

                showMapButtons.forEach(button => {
                    const lat = parseFloat(button.dataset.lat);
                    const lng = parseFloat(button.dataset.lng);
                    const type = button.dataset.type;
                    const date = button.dataset.date;
                    const addressId = button.dataset.addressId;

                    const marker = L.marker([lat, lng]).addTo(map);
                    const popupContent = `
                        <b>${type}</b><br>
                        ${date}<br>
                        <span id="${addressId}">Loading address...</span>
                    `;
                    marker.bindPopup(popupContent);
                    markers.push(marker);
                    bounds.extend([lat, lng]);

                    // Fetch address for popup
                    fetchAddress(lat, lng, null, addressId);
                });

                if (markers.length > 0) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }
            }

            // Toggle map visibility
            toggleMapBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                isMapVisible = !isMapVisible;

                if (isMapVisible) {
                    mapContainer.classList.remove('hidden');
                    mapButtonText.textContent = 'Hide Map';
                    if (!map) {
                        initializeMap();
                        addAllMarkers();
                    }
                } else {
                    mapContainer.classList.add('hidden');
                    mapButtonText.textContent = 'Show Map';
                }
            });

            // Show specific location on map
            showMapButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);
                    const type = this.dataset.type;
                    const date = this.dataset.date;
                    const addressId = this.dataset.addressId;

                    mapContainer.classList.remove('hidden');
                    mapButtonText.textContent = 'Hide Map';
                    isMapVisible = true;

                    if (!map) {
                        initializeMap();
                    }

                    map.setView([lat, lng], 15);

                    let existingMarker = markers.find(m => {
                        const latlng = m.getLatLng();
                        return latlng.lat === lat && latlng.lng === lng;
                    });

                    if (existingMarker) {
                        existingMarker.openPopup();
                    } else {
                        const marker = L.marker([lat, lng]).addTo(map);
                        const popupContent = `
                            <b>${type}</b><br>
                            ${date}<br>
                            <span id="${addressId}">Loading address...</span>
                        `;
                        marker.bindPopup(popupContent).openPopup();
                        markers.push(marker);
                        fetchAddress(lat, lng, null, addressId);
                    }

                    mapContainer.scrollIntoView({ behavior: 'smooth' });
                });

                // Fetch address for table on load
                const lat = parseFloat(button.dataset.lat);
                const lng = parseFloat(button.dataset.lng);
                const addressElement = button.closest('tr').querySelector('.location-address');
                if (addressElement) {
                    fetchAddress(lat, lng, addressElement);
                }
            });
        });
    </script>
</x-app-layout>