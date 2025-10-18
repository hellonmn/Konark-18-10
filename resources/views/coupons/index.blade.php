<x-app-layout>

    <style>
        /* Toggle Switch */
        #toggle-switch:checked~.dot {
            transform: translateX(1.5rem);
        }

        #toggle-switch:checked~.block {
            background-color: #241bd0;
        }
    </style>
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
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600  ">
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
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Coupons</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex">
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-lg hover:shadow-gray-400 transition-all">
                        <i class="fi fi-br-plus"></i>
                        <span>Add coupon</span>
                    </button>
                </div>
            </div>
            <div class="p-5 bg-white rounded-xl w-full">
                <div class="grid grid-cols-3 gap-3 w-full">
                    @foreach ($coupons as $coupon)
                        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                            <h5 class="mb-4 text-xl font-medium text-gray-500">{{ $coupon->name }}</h5>
                            <div class="flex items-baseline text-gray-900">
                                <span
                                    class="flex items-center gap-1 text-lg font-extrabold tracking-tight bg-plight py-2 px-4 rounded-xl text-gray-700">
                                    <i class="fi fi-rr-ticket text-primary"></i>
                                    <span>
                                        {{ $coupon->code }}
                                    </span>
                                </span>
                            </div>
                            <ul role="list" class="space-y-5 my-7">
                                <li class="flex items-center">
                                    <svg class="flex-shrink-0 w-4 h-4 text-primary " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                    @if ($coupon->percentage == null)
                                        <span
                                            class="text-base font-normal leading-tight text-gray-500  ms-3"><strong>Discount:</strong>
                                            Flat {{ $coupon->amount }} Off</span>
                                    @else
                                        <span
                                            class="text-base font-normal leading-tight text-gray-500  ms-3"><strong>Discount:</strong>
                                            {{ $coupon->percentage }}% Off</span>
                                    @endif
                                </li>
                                <li class="flex items-center">
                                    <svg class="flex-shrink-0 w-4 h-4 text-primary " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                    <span class="text-base font-normal leading-tight text-gray-500  ms-3"><strong>Expiry
                                            Date:</strong> {{ $coupon->expiry }}</span>
                                </li>
                                @if ($coupon->minimum == null)
                                @else
                                    <li class="flex items-center">
                                        <svg class="flex-shrink-0 w-4 h-4 text-primary " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                        </svg>
                                        <span class="text-base font-normal leading-tight text-gray-500  ms-3"><strong>Minimum
                                                Eligibility Amount:</strong> {{ $coupon->minimum }}</span>
                                    </li>
                                @endif
                                @if ($coupon->maximum == null)
                                @else
                                    <li class="flex items-center">
                                        <svg class="flex-shrink-0 w-4 h-4 text-primary " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                        </svg>
                                        <span class="text-base font-normal leading-tight text-gray-500  ms-3"><strong>Maximum
                                                Discount:</strong> {{ $coupon->maximum }}</span>
                                    </li>
                                @endif

                            </ul>
                            <div class="flex gap-2">
                                <a href="{{ route('coupons.edit', ['id' => $coupon->id]) }}"
                                    class="text-center text-gray-500 hover:text-white bg-plight hover:bg-primary font-medium rounded-lg text-sm px-5 py-2.5 w-full">
                                    Edit
                                </a>
                                <a href="javascript:void(0);"
                                    class="delete-btn text-center text-gray-500 hover:text-white bg-red-100 hover:bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 w-full"
                                    data-coupon-id="{{ $coupon->id }}">
                                    Delete
                                </a>
                            </div>

                            <!-- Delete Form -->
                            <form id="deleteForm" action="{{ route('coupons.destroy') }}" method="post">
                                @csrf
                                <input type="hidden" name="coupon_id" id="deleteCouponId">
                            </form>

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
                        Create New Coupon
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
                <form class="p-4 md:p-5" action="{{ route('coupons.store') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        @csrf
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Coupon
                                Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type coupon name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="code" class="block mb-2 text-sm font-medium text-gray-900">Coupon
                                Code</label>
                            <input type="text" name="code" id="code"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type coupon code" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="clinic_location" class="block mb-2 text-sm font-medium text-gray-900">Expiry
                                Date</label>
                            <input type="date" name="expiry" id="expiry"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Select expiry date" required>
                        </div>

                        <div class="col-span-2">
                            <div class="mb-4">
                                <label for="toggle-switch" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="toggle-switch" name="discount_type"
                                            class="sr-only">
                                        <input type="text" id="is_fix" name="is_fix" class="hidden">
                                        <div class="block bg-gray-200 w-14 h-8 rounded-full"></div>
                                        <div
                                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                        </div>
                                    </div>
                                    <span class="ml-3 text-gray-900 font-medium">Toggle Discount Type</span>
                                </label>
                            </div>

                            <div id="inputFields" class="space-y-3">
                                <div id="input1Container" class="inputBox col-span-2">
                                    <label for="input1"
                                        class="block mb-2 text-sm font-medium text-gray-900">Discount
                                        Percentage</label>
                                    <input type="text" name="percentage" placeholder="Enter percentage discount"
                                        id="input1"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                </div>
                                <div id="input2Container" class="inputBox col-span-2 hidden">
                                    <label for="input2"
                                        class="block mb-2 text-sm font-medium text-gray-900">Discount Price</label>
                                    <input type="text" name="amount" placeholder="Enter discount amount"
                                        id="input2"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2" id="maxInput">
                            <label for="max" class="block mb-2 text-sm font-medium text-gray-900">Maximum
                                Discount Price</label>
                            <input type="text" name="max" id="max"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type max discount price">
                        </div>
                        <div class="col-span-2" id="minInput">
                            <label for="min" class="block mb-2 text-sm font-medium text-gray-900">Minimum
                                                Eligibility Amount</label>
                            <input type="text" name="min" id="min"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Type minimum eligibility amount" required="">
                        </div>
                    </div>
                    <button class="text-white inline-flex items-center bg-primary hover:bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
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

    <!-- Delete modal -->
    <div id="delete-popup-modal" tabindex="-1"
        class="bg-black bg-opacity-30 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full">
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
            const deleteBtns = document.querySelectorAll('.delete-btn');
            const deleteForm = document.getElementById('deleteForm');
            const deleteCouponId = document.getElementById('deleteCouponId');
            const deleteModal = document.getElementById('delete-popup-modal');
            const confirmDeleteYes = document.getElementById('confirmDeleteYes');

            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const couponId = this.getAttribute('data-coupon-id');
                    deleteCouponId.value = couponId;
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            confirmDeleteYes.addEventListener('click', function() {
                deleteForm.submit();
            });

            document.querySelectorAll('[data-modal-hide]').forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const expiryInput = document.getElementById('expiry');

            // Get today's date
            const today = new Date();

            // Calculate tomorrow's date
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            // Format the date as YYYY-MM-DD
            const formattedDate = tomorrow.toISOString().split('T')[0];

            // Set the min attribute to tomorrow's date
            expiryInput.setAttribute('min', formattedDate);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.getElementById('toggle-switch');
            const is_fix = document.getElementById('is_fix');
            const input1 = document.getElementById('input1Container');
            const input2 = document.getElementById('input2Container');
            const minInput = document.getElementById('minInput');
            const maxInput = document.getElementById('maxInput');

            toggleSwitch.addEventListener('change', function() {
                if (toggleSwitch.checked) {
                    input1.classList.add('hidden');
                    input2.classList.remove('hidden');
                    maxInput.classList.add('hidden');
                    is_fix.value = 1;
                } else {
                    is_fix.value = 0;
                    input1.classList.remove('hidden');
                    input2.classList.add('hidden');
                    maxInput.classList.remove('hidden');
                }
            });
        });
    </script>
</x-app-layout>
