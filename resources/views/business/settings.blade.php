<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Business
                                        Settings</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex">
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                        <i class="fi fi-br-plus"></i>
                        <span>Add doctor</span>
                    </button>
                </div>
            </div>
            <div class="p-5 bg-white rounded-xl w-full">


                <div class="container mx-auto">
                    <div class="flex border-b border-gray-200">
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="general">General</button>
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="colors">Colors</button>
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="form-settings">Form Settings</button>
                    </div>

                    <div class="tab-content mt-6" id="general">
                        <form class="max-w-sm" action="{{ route('business.settings.general.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="business_name" class="block text-sm font-medium text-gray-700">Business
                                    Name</label>
                                <input type="text" name="business_name" id="business_name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter business name" value="{{ $settings->business_name }}" required />
                            </div>
                            <div class="mb-4">
                                <input type="text" hidden id="isNullLogo" name="isNullLogo"
                                    value="@if ($settings->logo == null) yes @else no @endif">
                                <label for="logo" class="block text-sm font-medium text-gray-700">Upload
                                    @if ($settings->logo == null)
                                    @else
                                        New
                                    @endif Logo
                                </label>
                                <input type="file" name="logo" id="logo" accept="image/*"
                                    class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:ring-primary focus:border-primary" />
                                <div id="logo-preview" class="mt-2">
                                    @if ($settings->logo == null)
                                    @else
                                        <label for="logo" class="block text-sm font-medium text-gray-700">Uploaded
                                            Logo</label>
                                        <img src="/storage/business/general/logo/{{ $settings->logo }}"
                                            alt="Thumbnail Preview" class="max-w-full max-h-64 rounded-lg" />
                                    @endif
                                </div>
                                <button type="button" id="remove-logo"
                                    class="mt-2 text-sm text-red-500 @if ($settings->logo == null) hidden @endif">Remove
                                    Logo</button>
                            </div>
                            <div class="mb-4 w-full flex justify-end">
                                <button
                                    class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content mt-6 hidden" id="colors">
                        <form class="max-w-sm ">
                            <div class="mb-4">
                                <label for="primary_color" class="block text-sm font-medium text-gray-700">Primary
                                    Business Color</label>
                                <input type="color" value="#ff0000" name="primary_color" id="primary_color"
                                    class="mt-1 block w-full h-9 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required />
                            </div>
                            <div class="mb-4">
                                <label for="primary_light_color" class="block text-sm font-medium text-gray-700">Primary
                                    Light Business Color</label>
                                <input type="color" value="#ffd000" name="primary_light_color"
                                    id="primary_light_color"
                                    class="mt-1 block w-full h-9 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required />
                            </div>
                            <div class="mb-4">
                                <label for="secondary_color" class="block text-sm font-medium text-gray-700">Secondary
                                    Business Color</label>
                                <input type="color" value="#16df6d" name="secondary_color" id="secondary_color"
                                    class="mt-1 block w-full h-9 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required />
                            </div>
                            <div class="mb-4 w-full flex justify-end">
                                <button
                                    class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content mt-6 hidden" id="form-settings">
                        <form class="max-w-sm">
                            <div class="mb-4">
                                <label for="form_title" class="block text-sm font-medium text-gray-700">Form
                                    Title</label>
                                <input type="text" name="form_title" id="form_title"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter form title" required />
                            </div>
                            <div class="mb-4">
                                <label for="form_thumbnail" class="block text-sm font-medium text-gray-700">Upload
                                    Form Thumbnail</label>
                                <input type="file" name="form_thumbnail" id="form_thumbnail" accept="image/*"
                                    class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                <div id="thumbnail-preview" class="mt-2"></div>
                                <button type="button" id="remove-thumbnail"
                                    class="mt-2 text-sm text-red-500 hidden">Remove Thumbnail</button>
                            </div>
                            <div class="mb-4 w-full flex justify-end">
                                <button
                                    class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Logo Preview and Remove Functionality
            const logoInput = document.getElementById('logo');
            const isNullLogo = document.getElementById('isNullLogo');
            const logoPreview = document.getElementById('logo-preview');
            const removeLogoButton = document.getElementById('remove-logo');

            logoInput.addEventListener('change', function() {
                if (logoInput.files && logoInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.innerHTML =
                            `<img src="${e.target.result}" alt="Logo Preview" class="max-w-full max-h-64 rounded-lg" />`;
                        isNullLogo.value = 'no';
                        removeLogoButton.classList.remove('hidden');
                    };
                    reader.readAsDataURL(logoInput.files[0]);
                }
            });

            removeLogoButton.addEventListener('click', function() {
                logoInput.value = '';
                isNullLogo.value = 'yes';
                logoPreview.innerHTML = '';
                removeLogoButton.classList.add('hidden');
            });

            // Thumbnail Preview and Remove Functionality
            const thumbnailInput = document.getElementById('form_thumbnail');
            const thumbnailPreview = document.getElementById('thumbnail-preview');
            const removeThumbnailButton = document.getElementById('remove-thumbnail');

            thumbnailInput.addEventListener('change', function() {
                if (thumbnailInput.files && thumbnailInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnailPreview.innerHTML =
                            `<img src="${e.target.result}" alt="Thumbnail Preview" class="max-w-full max-h-64 rounded-lg" />`;
                        removeThumbnailButton.classList.remove('hidden');
                    };
                    reader.readAsDataURL(thumbnailInput.files[0]);
                }
            });

            removeThumbnailButton.addEventListener('click', function() {
                thumbnailInput.value = '';
                thumbnailPreview.innerHTML = '';
                removeThumbnailButton.classList.add('hidden');
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.getAttribute('data-tab');

                    tabButtons.forEach(btn => btn.classList.remove('text-primary', 'border-b-2',
                        'border-primary'));
                    tabContents.forEach(content => content.classList.add('hidden'));

                    button.classList.add('text-primary', 'border-b-2', 'border-primary');
                    document.getElementById(targetTab).classList.remove('hidden');
                });
            });

            // Activate the first tab by default
            tabButtons[0].click();
        });
    </script>
</x-app-layout>
