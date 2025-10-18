<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<style>

.table-container {
    position: relative;
    width: 100%;
    height: calc(100vh - 125px); /* Adjust height to fit within the viewport */
    overflow: hidden; /* Space for the scroll buttons */
}

.table-wrapper {
    overflow-x: auto;
    overflow-y: auto;
    height: 100%;
    width: 100%;
}

.scroll-btn {
    position: fixed;
    bottom: 10px; /* Distance from the bottom of the screen */
    width: 30px; /* Button width */
    height: 30px; /* Button height */
    background-color: #007bff; /* Button color */
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10;
}

.left-btn {
    left: 10px; /* Distance from the left edge of the screen */
}

.right-btn {
    right: 10px; /* Distance from the right edge of the screen */
}

.scroll-btn:hover {
    background-color: #0056b3; /* Darker color on hover */
}


</style>
    <div class="w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4 w-full flex flex-col gap-3">
            <div class="flex items-center justify-between p-5 w-full h-full rounded-xl bg-white">
                <div class="flex">
                    <!-- Breadcrumb -->
                    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
                        aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="#"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Home
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Patients</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex gap-2 items-center">
                    <div class="flex gap-2 items-center justify-between">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 " aria-hidden="true" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" style="padding-left:35px" id="table-search"
                                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search for items">
                            </div>
                    </div>
                    <div class="flex gap-2">
                        <form id="filterForm" method="GET" action="{{ route('patients.show') }}">
                                <input type="hidden" id="date_filter" name="date_filter">
        
                                <!-- Dropdown button -->
                                <button id="dropdownRadioButton" type="button"
                                    class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2"
                                    onclick="toggleDropdown()">
                                    <svg class="w-3 h-3 text-gray-500  me-3" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                                    </svg>
                                    Filter by Date
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
        
                                <!-- Dropdown menu -->
                                <div id="dropdownRadio"
                                    class="hidden absolute z-10 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow mt-2">
                                    <ul class="p-3 space-y-1 text-sm text-gray-700">
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                                onclick="applyFilter('last_day')">
                                                <input type="radio" name="filter-radio"
                                                    @if ($filter == 'last_day') checked @endif>
                                                <label class="w-full ms-2 text-sm font-medium">Last day</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                                onclick="applyFilter('last_7_days')">
                                                <input type="radio" name="filter-radio"
                                                    @if ($filter == 'last_7_days') checked @endif>
                                                <label class="w-full ms-2 text-sm font-medium">Last 7 days</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                                onclick="applyFilter('last_30_days')">
                                                <input type="radio" name="filter-radio"
                                                    @if ($filter == 'last_30_days') checked @endif>
                                                <label class="w-full ms-2 text-sm font-medium">Last 30 days</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                                onclick="applyFilter('last_month')">
                                                <input type="radio" name="filter-radio"
                                                    @if ($filter == 'last_month') checked @endif>
                                                <label class="w-full ms-2 text-sm font-medium">Last month</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                                onclick="applyFilter('last_year')">
                                                <input type="radio" name="filter-radio"
                                                    @if ($filter == 'last_year') checked @endif>
                                                <label class="w-full ms-2 text-sm font-medium">Last year</label>
                                            </div>
                                        </li>
                                        @if ($filter != null)
                                            <li>
                                                <a href="{{ route('patients.show') }}"
                                                    class="flex items-center p-2 bg-primary rounded-xl cursor-pointer">
                                                    <span class="w-full text-center text-textColor">Clear Filter</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </form>
                        <div class="flex gap-2 h-10">
                                <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown" class="flex items-center justify-center text-black bg-gray-100 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"><i class="fi fi-br-menu-burger"></i>
                                </button>
                                
                                <!-- Dropdown menu -->
                                <div id="multi-dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="multiLevelDropdownButton">
                                        <li>
                                            <a href="{{ route('patients.export') }}" class="block px-4 py-2 hover:bg-gray-100">Export</a>
                                        </li>
                                        <li>
                                            <a data-modal-target="upload-popup-modal" data-modal-toggle="upload-popup-modal" class="block px-4 py-2 hover:bg-gray-100">Upload CSV</a>
                                        </li>
                                    </ul>
                                </div>
            
            
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="table-container w-full h-full overflow-auto">
                    <div class="table-wrapper w-full">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                        <tr>
                            {{-- <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2  ">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th> --}}
                            <th scope="col" class="px-6 py-3">
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Patient name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Phone
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Age
                            </th>
                            <th scope="col" class="px-6 py-3">
                                gender
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Source
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Address
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Appointment Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Appointment Time
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Doctor
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Services
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Coupon
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Discount
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Payment Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Payment Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Payment Method
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Receipt ID
                            </th>
                        </tr>
                    </thead>
                    <tbody id="patients-table-body">
                        @foreach ($patients as $patient)
                            <tr class="text-nowrap bg-white border-b   hover:bg-gray-50 ">
                                {{-- <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2  ">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td> --}}

                                <td class="text-nowrap flex items-center gap-1 px-6 py-4">
                                    <div class="flex h-full gap-1 items-center">
                                        <a href="{{ route('patients.edit', ['id' => $patient->id]) }}"
                                            class="flex justify-center items-center font-medium p-2 hover:bg-blue-500 bg-blue-100 rounded-full text-blue-500 hover:text-white w-8 h-8"><i class="fi fi-rr-edit"></i></a>
                                        <div class="font-medium text-blue-600">
                                            <form action="{{ route('receipt.generate') }}" method="post">
                                                @csrf
                                                <input type="text" hidden name="patient" value="{{ $patient->id }}">
                                                <button class="flex justify-center items-center font-medium p-2 hover:bg-primary rounded-full text-primary bg-plight hover:text-white w-8 h-8"><i class="fi fi-rr-file-invoice-dollar"></i></button>
                                            </form>
                                        </div>
                                        @if ($patient->receipt_id == null)
                                        @else
                                        <a href="/storage/invoice/{{$patient->receipt_id}}.pdf" class="flex justify-center items-center font-medium p-2 hover:bg-yellow-500 bg-yellow-100 text-yellow-500 rounded-full hover:text-white w-8 h-8" download>
                                            <i class="fi fi-rr-download"></i>
                                        </a>
                                        @endif
                                        <button data-modal-target="delete-popup-modal" data-modal-toggle="delete-popup-modal"><i id="delete-button" data-id="{{ $patient->id }}" data-tooltip-target="tooltip-delete"
                                            class="fi fi-rr-trash p-2 rounded-full hover:bg-red-500 bg-red-100 hover:text-white text-red-500"></i></button>
                                    </div>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $patient->name }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->phone }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->email }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->age }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->gender }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->source }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->medical_history }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->appointment_date }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->appointment_time }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    @foreach ($doctors as $doctor)
                                        @if ($doctor->id == $patient->doctor)
                                            <span>{{ $doctor->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($services as $service)
                                            @if (in_array($service->id, json_decode($patient->services, true)))
                                                <span
                                                    class="bg-plight p-1 rounded-xl text-nowrap">{{ $service->name }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->coupon }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->discount }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->amount }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->payment_status }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->payment_date }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->payment_method }}
                                </td>
                                <td class="text-nowrap px-6 py-4">
                                    {{ $patient->receipt_id }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    </div>
                </div>
            </div>

        </div>
        <!--@if ($errors->any())-->
        <!--    <div class="alert alert-danger">-->
        <!--        <ul>-->
        <!--            @foreach ($errors->all() as $error)-->
        <!--                <li>{{ $error }}</li>-->
        <!--            @endforeach-->
        <!--        </ul>-->
        <!--    </div>-->
        <!--@endif-->

    </div>

    <!-- Delete modal -->
    <div id="delete-popup-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="delete-popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete?</h3>
                    <button id="confirmDeleteYes" data-modal-hide="delete-popup-modal" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="delete-popup-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No,
                        cancel</button>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Upload modal -->
    <div id="upload-popup-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="upload-popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <form class="p-4 md:p-5 text-center" action="{{ route('patients.create.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="multiple_files">Upload CSV file</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="file" id="multiple_files" type="file">
                    <x-input-error class="mt-2" :messages="$errors->get('file')" />
                    <div class="flex justify-end w-full mt-2">
                        <button id="confirmDeleteYes" data-modal-hide="delete-popup-modal"
                            class="text-white bg-primary hover:bg-primary focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Create
                        </button>
                        <button data-modal-hide="upload-popup-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No,
                            cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll('#delete-button');

            // Reference to the modal and the confirm button inside the modal
            const deleteModal = document.getElementById('delete-popup-modal');
            const confirmDeleteButton = deleteModal.querySelector('#confirmDeleteYes');
            let serviceIdToDelete = null;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the service ID from the data attribute
                    serviceIdToDelete = this.getAttribute('data-id');

                    // Show the delete confirmation modal
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            confirmDeleteButton.addEventListener('click', function() {
                if (serviceIdToDelete) {
                    // Perform the delete action via a form submission or AJAX
                    const deleteForm = document.createElement('form');
                    deleteForm.method = 'POST';
                    deleteForm.action = `/patients/${serviceIdToDelete}`;
                    deleteForm.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            });


        });
    </script>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdownRadio");
            dropdown.classList.toggle("hidden");
        }

        function applyFilter(filter) {
            document.getElementById('date_filter').value = filter;
            document.getElementById('filterForm').submit();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('table-search');
            const tableBody = document.getElementById('patients-table-body');

            searchInput.addEventListener('input', (event) => {
                const searchTerm = event.target.value.toLowerCase();

                Array.from(tableBody.getElementsByTagName('tr')).forEach(row => {
                    const cells = Array.from(row.getElementsByTagName('td'));
                    const isMatch = cells.some(cell => cell.textContent.toLowerCase().includes(
                        searchTerm));
                    row.style.display = isMatch ? '' : 'none';
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tableContainer = document.querySelector(
                '.relative.overflow-x-auto'); // This is the container for your table

            // Add event listeners for scrolling horizontally when Alt + Shift keys are pressed
            let isAltPressed = false;
            let isShiftPressed = false;

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Shift') {
                    isShiftPressed = true;
                }
                if (event.key === 'Alt') {
                    isAltPressed = true;
                }
            });

            document.addEventListener('keyup', function(event) {
                if (event.key === 'Shift') {
                    isShiftPressed = false;
                }
                if (event.key === 'Alt') {
                    isAltPressed = false;
                }
            });

            tableContainer.addEventListener('wheel', function(event) {
                if (isAltPressed && isShiftPressed) {
                    event.preventDefault();
                    tableContainer.scrollLeft += event.deltaY; // Horizontal scroll
                }
            });
        });
    </script>

</x-app-layout>
