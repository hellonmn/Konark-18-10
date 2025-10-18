<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .calendar-day {
            @apply p-2 text-center rounded-lg cursor-pointer;
        }

        .calendar-day.highlight {
            @apply bg-pink-100;
        }
    </style>


    <div class="w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4 w-full flex flex-col gap-3">
            <div class="flex justify-between p-5 w-full h-full rounded-xl bg-white">
                <div class="flex">
                    <!-- Breadcrumb -->
                    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
                        aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="#"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
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
                                    <span
                                        class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Doctors</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex gap-2">
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 transition-all">
                        <i class="fi fi-br-plus"></i>
                        <span>Add doctor</span>
                    </button>
                    <a href="{{ route('doctors.export') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl">
                        Export to Excel
                    </a>

                </div>
            </div>
            <div class="p-5 bg-white rounded-xl w-full">
                {{-- <div class="flex justify-end w-full mb-5">

                    <form id="search-form" class="w-1/2">
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input style="padding-left: 35px" type="search" id="default-search" data-search
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search Doctors..." required />
                            <button type="submit"
                                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                        </div>
                    </form>

                </div> --}}

                <div class="flex justify-between mb-4">
    <!-- Search Filter -->
    <form id="filter-form" class="w-1/2 flex gap-2" method="GET" action="{{ route('doctors.show') }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Doctors..."
            class="block w-full p-2 text-sm border border-gray-300 rounded-lg">

        <button class="text-white bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
            Search
        </button>

        @if(request('search'))
            <a href="{{ route('doctors.show') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Clear
            </a>
        @endif
    </form>

    <!-- Sorting Options -->
    <form class="flex gap-2">
        <select name="sort" id="sort-select" class="block p-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Sort By</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            <option value="clinic_name_asc" {{ request('sort') == 'clinic_name_asc' ? 'selected' : '' }}>Clinic Name (A-Z)</option>
            <option value="clinic_name_desc" {{ request('sort') == 'clinic_name_desc' ? 'selected' : '' }}>Clinic Name (Z-A)</option>
        </select>

        <button class="text-white bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
            Apply
        </button>
    </form>
</div>


                <div class="grid grid-cols-2 gap-3 w-full">

                    @foreach ($doctors as $doctor)
                        <div
                            class="flex items-center gap-2 min-h-20 p-2 group relative border-2 border-gray-200 hover:shadow-xl hover:bg-pink-100 hover:border-primary shadow-pink-500 rounded-xl transition-all">
                            <div class="flex flex-col gap-1" id="profileParent"
                                data-id="{{ $doctor->id }}">
                                @if ($doctor->profile_picture == null)
                                    <div
                                        class="flex items-center justify-center text-3xl text-gray-400 w-14 h-14 bg-gray-200 rounded-full">
                                        <i class="fi fi-rr-user-md"></i>
                                    </div>
                                @else
                                    <div style="background-image: url(/storage/doctor/profile/{{ $doctor->profile_picture }}); background-size: cover; background-position: center;"
                                        class="flex items-center justify-center text-3xl text-gray-400 w-14 h-14 bg-gray-200 rounded-full">

                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold">{{ $doctor->name }}</span>
                                <div class="flex gap-5">
                                    <div class="flex items-center gap-1">
                                        <i
                                            class="fi fi-sr-marker text-[12px] text-gray-500 group-hover:text-gray-600"></i>
                                        <span
                                            class="text-gray-500 text-sm group-hover:text-gray-600">{{ $doctor->clinic_location }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i
                                            class="fi fi-sr-hospital text-[12px] text-gray-500 group-hover:text-gray-600"></i>
                                        <span
                                            class="text-gray-500 text-sm group-hover:text-gray-600">{{ $doctor->clinic_name }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i
                                            class="fi fi-sr-phone-call text-[12px] text-gray-500 group-hover:text-gray-600"></i>
                                        <span
                                            class="text-gray-500 text-sm group-hover:text-gray-600">{{ $doctor->phone }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden group-hover:flex absolute right-2 transition-all cursor-pointer">
                                <div class="flex gap-2">
                                    <a href="{{ route('doctors.calendar', ['id'=>$doctor->id]) }}"><i data-tooltip-target="tooltip-calendar"
                                        class="fi fi-rr-calendar p-2 rounded-full bg-primary text-white"></i></a>
                                    <button type="button" data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                                        data-id="{{ $doctor->id }}" data-name="{{ $doctor->name }}"
                                        data-clinic-name="{{ $doctor->clinic_name }}" data-phone="{{ $doctor->phone }}"
                                        data-clinic-location="{{ $doctor->clinic_location }}" class="edit-button">
                                        <i data-tooltip-target="tooltip-edit"
                                            class="fi fi-rr-edit p-2 rounded-full bg-green-500 text-white"></i>
                                    </button>

                                    <div id="tooltip-calendar" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Calendar
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <div id="tooltip-edit" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Edit
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button data-modal-target="delete-popup-modal" data-modal-toggle="delete-popup-modal"><i id="delete-button" data-id="{{ $doctor->id }}" data-tooltip-target="tooltip-delete"
                                            class="fi fi-rr-trash p-2 rounded-full bg-red-500 text-white"></i></button>
                                    <div id="tooltip-delete" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Delete
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>





    <!-- Creation modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Create New Doctor
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" action="{{ route('doctors.store') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        @csrf
                        <div class="col-span-2">
                            <div class="flex flex-col items-center justify-center gap-2 w-full">
                                <div id="input-box"
                                    class="flex flex-col items-center justify-center w-20 h-20 border-2 border-gray-300 border-dashed rounded-full cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-full">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                        </div>
                                        <input id="dropzone-file" type="file" class="hidden"
                                            name="profile_picture" accept="image/*" />
                                    </label>
                                </div>
                                <div id="image-box"
                                    class="hidden flex flex-col items-center justify-center w-20 h-20 border-2 border-gray-300 border-dashed rounded-full bg-gray-50 relative">
                                    <img id="image-preview" src="" alt="Profile Picture Preview"
                                        class="rounded-full object-cover w-full h-full">
                                    <button type="button" id="delete-image"
                                        class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                        &times;
                                    </button>
                                </div>
                                <span class="block mb-2 text-sm font-medium text-gray-900">Profile Picture</span>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Doctor
                                Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type doctor name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="phone" class="block text-sm mb-2 font-medium text-gray-900">Doctor
                                Phone</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                    +91
                                </span>
                                <input type="number" id="phone" name="phone"
                                    class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5"
                                    placeholder="7845451545" required="">
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="clinic_name" class="block mb-2 text-sm font-medium text-gray-900">Clinic
                                Name</label>
                            <input type="text" name="clinic_name" id="clinic_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type clinic name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="clinic_location" class="block mb-2 text-sm font-medium text-gray-900">Clinic
                                Location</label>
                            <input type="text" name="clinic_location" id="clinic_location"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type clinic location" required="">
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Create
                    </button>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit modal -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Edit Doctor
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="editForm" class="p-4 md:p-5" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Doctor
                                Name</label>
                            <input type="text" name="name" id="edit_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type service name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="phone" class="block text-sm mb-2 font-medium text-gray-900">Doctor
                                Phone</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                    +91
                                </span>
                                <input type="number" id="edit_phone" name="phone"
                                    class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5"
                                    placeholder="7845451545" required="">
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="edit_clinic_name" class="block mb-2 text-sm font-medium text-gray-900">
                                Clinic Name</label>
                            <input type="text" name="clinic_name" id="edit_clinic_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type service price" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="edit_clinic_location" class="block mb-2 text-sm font-medium text-gray-900">
                                Clinic Location</label>
                            <input type="text" name="clinic_location" id="edit_clinic_location"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type service price" required="">
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Save
                    </button>
                </form>


            </div>
        </div>
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


    <script src="{{ asset('assets/js/doctors/editmodel.js') }}"></script>

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
                    deleteForm.action = `/doctors/${serviceIdToDelete}`;
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
        document.getElementById('dropzone-file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            const imageBox = document.getElementById('image-box');
            const inputBox = document.getElementById('input-box');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    imageBox.classList.remove('hidden');
                    inputBox.classList.add('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                resetImage();
            }
        });

        document.getElementById('delete-image').addEventListener('click', function() {
            resetImage();
        });

        function resetImage() {
            const input = document.getElementById('dropzone-file');
            const preview = document.getElementById('image-preview');
            const imageBox = document.getElementById('image-box');
            const inputBox = document.getElementById('input-box');

            input.value = ""; // Clear the file input value
            preview.src = ""; // Clear the preview image src
            imageBox.classList.add('hidden'); // Hide the image box
            inputBox.classList.remove('hidden'); // Show the input box
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('[data-search]');
            const doctorCards = document.querySelectorAll('.doctor-card');

            searchInput.addEventListener('input', function() {
                const searchQuery = searchInput.value.toLowerCase();

                doctorCards.forEach(function(card) {
                    const doctorName = card.querySelector('.font-bold').textContent.toLowerCase();
                    const clinicName = card.querySelector('.clinic-name').textContent.toLowerCase();
                    const clinicLocation = card.querySelector('.clinic-location').textContent
                        .toLowerCase();

                    if (doctorName.includes(searchQuery) || clinicName.includes(searchQuery) ||
                        clinicLocation.includes(searchQuery)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>



</x-app-layout>
