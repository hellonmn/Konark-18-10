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
    height: calc(100vh - 120px); /* Adjust height to fit within the viewport */
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
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Doctors</span>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Approved</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                
                <div class="flex items-center justify-between gap-2">
                <!-- Search Filter -->
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
                        <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown" class="flex items-center justify-center text-black bg-gray-100 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"><i class="fi fi-br-menu-burger"></i>
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div id="multi-dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="multiLevelDropdownButton">
                                <li>
                                    <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" data-dropdown-placement="right-start" type="button" class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">Add doctor
                                        <svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                    </button>
                                    <div id="doubleDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton">
                                            <li>
                                                <a data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block px-4 py-2 hover:bg-gray-100">Add manually</a>
                                            </li>
                                            <li>
                                                <a data-modal-target="upload-popup-modal" data-modal-toggle="upload-popup-modal" class="block px-4 py-2 hover:bg-gray-100">Upload CSV</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a href="{{ route('doctors.export') }}" class="block px-4 py-2 hover:bg-gray-100">Export</a>
                                </li>
                            </ul>
                        </div>
    
    
                    </div>
                    
                    <div class="flex gap-2">
                        <button id="filterDropdown" data-dropdown-toggle="filter-dropdown" class="relative flex items-center justify-center text-black bg-gray-100 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            <i class="fi fi-br-filter"></i>
                            @if($isDateFilterActive)
                                <div class="flex items-center justify-center absolute top-0 right-0 bg-red-500 rounded-full w-4 h-4 text-white text-sm" style="text-size:10px">1</div>
                            @endif
                        </button>
                        
                        <!-- Dropdown menu -->
                        <div id="filter-dropdown" class="absolute z-10 p-2 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl border w-96">
                            <!-- Sorting Options -->
                            <form class="mb-4 w-full">
                                <label>Sort by:</label>
                                <div class="flex gap-2 w-full">
                                    <select name="sort" id="sort-select" class="w-full block p-2 border border-gray-300 rounded-lg">
                                        <option value="" disabled selected>Select</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                        <option value="clinic_name_asc" {{ request('sort') == 'clinic_name_asc' ? 'selected' : '' }}>Clinic Name (A-Z)</option>
                                        <option value="clinic_name_desc" {{ request('sort') == 'clinic_name_desc' ? 'selected' : '' }}>Clinic Name (Z-A)</option>
                                    </select>
                            
                                    <button class="text-white bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
                                        Apply
                                    </button>
                                </div>
                                
                            </form>
                            <form class="w-full">
                                <label>Filter by date:</label>
                                <div class="flex items-centre justify-centre w-full">
                                    <ul class="p-2 bg-pink-100 rounded-xl w-full" aria-labelledby="filterDropdown">
                                        <label for="fromDate" class="block text-sm mb-2 font-medium text-gray-900">From Date</label>
                                        <input type="date" id="fromDate" name="fromDate" value="{{$fromDate}}"
                                            class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" required="">
                                    </ul>
                                    <ul class="flex items-center justify-center">
                                        <div class="bg-pink-100 w-5 h-1"></div>
                                    </ul>
                                    <ul class="p-2 bg-pink-100 rounded-xl w-full" aria-labelledby="filterDropdown">
                                        <label for="toDate" class="block text-sm mb-2 font-medium text-gray-900">To Date</label>
                                        <input type="date" id="toDate" name="toDate" value="{{$toDate}}"
                                            class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" required="">
                                    </ul>
                                </div>
                                <button class="w-full mt-2 text-white bg-primary hover:bg-pink-500 focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
                                    Apply
                                </button>
                                @if($isDateFilterActive)
                                    <button href="{{ route('doctors.show') }}" class="w-full mt-2 text-gray-700 bg-gray-100 hover:bg-pink-100 focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
                                        Clear
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Date Filter -->
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="table-container w-full h-full overflow-auto">
                    <div class="table-wrapper w-full">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <!-- Table headers -->
                        <th scope="col" class="px-6 py-3"></th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Phone</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Clinic Name</th>
                        <th scope="col" class="px-6 py-3">Clinic Location</th>
                        <th scope="col" class="px-6 py-3">CBCT Count</th>
                        <th scope="col" class="px-6 py-3">OBC Count</th>
                        <th scope="col" class="px-6 py-3">Inactive Days</th>
                        <th scope="col" class="px-6 py-3">Created At</th>
                    </tr>
                </thead>
                <tbody id="patients-table-body">
                    @foreach ($doctors as $doctor)
                        <tr class="text-nowrap bg-white border-b hover:bg-gray-50">
                            <!-- Table cells -->
                            <td class="text-nowrap flex items-center justify-center gap-1 px-6 py-4">
                                <!-- Action buttons -->
                                <div class="flex h-full gap-1 items-center justify-center">
                                    <a href="{{ route('doctors.edit', ['id' => $doctor->id]) }}" class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 hover:bg-blue-500 text-blue-500 hover:text-white">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>
                                    <a href="{{ route('doctors.calendar', ['id' => $doctor->id]) }}">
                                        <i data-tooltip-target="tooltip-calendar" class="fi fi-rr-chart-histogram p-2 rounded-full bg-blue-100 text-blue-500 hover:bg-blue-500 hover:text-white"></i>
                                    </a>
                                    <button data-modal-target="delete-popup-modal" data-modal-toggle="delete-popup-modal">
                                        <i id="delete-button" data-id="{{ $doctor->id }}" data-tooltip-target="tooltip-delete" class="fi fi-rr-trash p-2 rounded-full bg-red-100 text-red-500 hover:bg-red-500 hover:text-white"></i>
                                    </button>
                                </div>
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $doctor->name }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->phone }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->email }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->clinic_name }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->clinic_location }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->cbctCount }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->opgCount }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->inactiveDays }}</td>
                            <td class="text-nowrap px-6 py-4">{{ $doctor->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                    </div>
                </div>
            </div>
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
                        <!--<div class="col-span-2">-->
                        <!--    <div class="flex flex-col items-center justify-center gap-2 w-full">-->
                        <!--        <div id="input-box"-->
                        <!--            class="flex flex-col items-center justify-center w-20 h-20 border-2 border-gray-300 border-dashed rounded-full cursor-pointer bg-gray-50 hover:bg-gray-100">-->
                        <!--            <label for="dropzone-file"-->
                        <!--                class="flex flex-col items-center justify-center w-full h-full">-->
                        <!--                <div class="flex flex-col items-center justify-center pt-5 pb-6">-->
                        <!--                    <svg class="w-8 h-8 text-gray-500" aria-hidden="true"-->
                        <!--                        xmlns="http://www.w3.org/2000/svg" fill="none"-->
                        <!--                        viewBox="0 0 20 16">-->
                        <!--                        <path stroke="currentColor" stroke-linecap="round"-->
                        <!--                            stroke-linejoin="round" stroke-width="2"-->
                        <!--                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />-->
                        <!--                    </svg>-->
                        <!--                </div>-->
                        <!--                <input id="dropzone-file" type="file" class="hidden"-->
                        <!--                    name="profile_picture" accept="image/*" />-->
                        <!--            </label>-->
                        <!--        </div>-->
                        <!--        <div id="image-box"-->
                        <!--            class="hidden flex flex-col items-center justify-center w-20 h-20 border-2 border-gray-300 border-dashed rounded-full bg-gray-50 relative">-->
                        <!--            <img id="image-preview" src="" alt="Profile Picture Preview"-->
                        <!--                class="rounded-full object-cover w-full h-full">-->
                        <!--            <button type="button" id="delete-image"-->
                        <!--                class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center">-->
                        <!--                &times;-->
                        <!--            </button>-->
                        <!--        </div>-->
                        <!--        <span class="block mb-2 text-sm font-medium text-gray-900">Profile Picture</span>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm mb-2 font-medium text-gray-900">Doctor
                                Name</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                    Dr.
                                </span>
                                <input type="text" id="name" name="name"
                                    class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5"
                                    placeholder="Type doctor name" required="">
                            </div>
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
                            <label for="email" class="block text-sm mb-2 font-medium text-gray-900">Doctor
                                Email</label>
                            <div class="flex">
                                <input type="email" id="email" name="email"
                                    class="rounded-none rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5"
                                    placeholder="drabc@email.com" required="">
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
                <form class="p-4 md:p-5 text-center" action="{{ route('doctors.create.csv') }}" method="POST" enctype="multipart/form-data">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableWrapper = document.querySelector('.table-wrapper');
    const scrollLeftButton = document.getElementById('scroll-left');
    const scrollRightButton = document.getElementById('scroll-right');

    const scrollAmount = 100; // Amount to scroll on each button click

    scrollLeftButton.addEventListener('click', () => {
        tableWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    scrollRightButton.addEventListener('click', () => {
        tableWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
});


</script>

</x-app-layout>
