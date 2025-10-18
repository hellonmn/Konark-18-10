<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full">
        @if(session('success'))
        <div class="absolute right-5 bottom-5 z-20">
            <div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-xl " role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

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
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Patients</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex">
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                        <i class="fi fi-br-plus"></i>
                        <span>Add patient</span>
                    </button>
                </div>
            </div>
            <div class="p-5 bg-white rounded-xl w-full">

                <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                    <form id="filterForm" method="GET" action="{{ route('patients.show') }}">
                        <input type="hidden" id="date_filter" name="date_filter">

                        <!-- Dropdown button -->
                        <button id="dropdownRadioButton" type="button"
                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5"
                            onclick="toggleDropdown()">
                            <svg class="w-3 h-3 text-gray-500  me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                            </svg>
                            Filter by Date
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownRadio" class="hidden absolute z-10 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow mt-2">
                            <ul class="p-3 space-y-1 text-sm text-gray-700">
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                        onclick="applyFilter('last_day')">
                                        <input type="radio" name="filter-radio" @if($filter == 'last_day') checked @endif>
                                        <label class="w-full ms-2 text-sm font-medium">Last day</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                        onclick="applyFilter('last_7_days')">
                                        <input type="radio" name="filter-radio" @if($filter == 'last_7_days') checked @endif>
                                        <label class="w-full ms-2 text-sm font-medium">Last 7 days</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                        onclick="applyFilter('last_30_days')">
                                        <input type="radio" name="filter-radio" @if($filter == 'last_30_days') checked @endif>
                                        <label class="w-full ms-2 text-sm font-medium">Last 30 days</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                        onclick="applyFilter('last_month')">
                                        <input type="radio" name="filter-radio" @if($filter == 'last_month') checked @endif>
                                        <label class="w-full ms-2 text-sm font-medium">Last month</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                                        onclick="applyFilter('last_year')">
                                        <input type="radio" name="filter-radio" @if($filter == 'last_year') checked @endif>
                                        <label class="w-full ms-2 text-sm font-medium">Last year</label>
                                    </div>
                                </li>
                                @if ($filter != null)
                                    <li>
                                        <a href="{{ route('patients.show') }}" class="flex items-center p-2 bg-primary rounded-xl cursor-pointer">
                                            <span class="w-full text-center text-textColor">Clear Filter</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </form>


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
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                                    Medical History
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr class="bg-white border-b   hover:bg-gray-50 ">
                                    {{-- <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2  ">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td> --}}

                                    <td class="px-6 py-4">
                                        <a href="{{ route('patients.edit', ['id'=>$patient->id]) }}" class="font-medium text-blue-600  hover:underline">Edit</a>
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{$patient->name}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$patient->phone}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->email}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->age}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->gender}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->source}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->medical_history}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->appointment_date}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->appointment_time}}
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach ($doctors as $doctor)
                                                @if($doctor->id == $patient->doctor) <span>{{$doctor->name}}</span> @endif
                                            @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($services as $service)
                                                @if(in_array($service->id, json_decode($patient->services, true))) <span class="bg-plight p-1 rounded-xl text-nowrap">{{$service->name}}</span> @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->coupon}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->discount}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$patient->amount}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownRadio");
        dropdown.classList.toggle("hidden");
    }

    function applyFilter(filter) {
        document.getElementById('date_filter').value = filter;
        document.getElementById('filterForm').submit();
    }
</script>
</x-app-layout>
