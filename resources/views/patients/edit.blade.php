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
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Patients</span>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">Edit</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                </div>
                <div class="flex">
                </div>
            </div>
            <div class="p-5 bg-white rounded-xl w-full">


                <div class="container mx-auto">
                    <div class="flex border-b border-gray-200">
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="general">Patient Details</button>
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="marketing">Marketing</button>
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="finance">Finance</button>
                        <button class="tab-button w-1/3 py-2 px-4 text-gray-700 font-medium focus:outline-none"
                            data-tab="additional">Additional</button>
                    </div>

                    <div class="tab-content mt-6" id="general">
                        <form class="max-w-sm" action="{{ route('patients.general.update', ['id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Patient
                                    Name</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter patient name" value="{{$patient->name}}" required />
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" id="phone"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter patient phone" value="{{$patient->phone}}" required />
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter patient phone" value="{{$patient->email}}" required />
                            </div>
                            <div class="mb-4">
                                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                                <input type="number" name="age" id="age"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter patient age" value="{{$patient->age}}" required />
                            </div>
                            <div class="mb-4">
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select type="text" name="gender" id="gender"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Select patient gender" required>
                                    @if ($patient->gender == 'male')
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                    @elseif ($patient->gender == 'female')
                                        <option value="male">Male</option>
                                        <option value="female" selected>Female</option>
                                    @else
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="medical_history" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="medical_history" id="medical_history"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter patient address" value="{{$patient->medical_history}}" />
                            </div>
                            <div class="mb-4 w-full flex justify-end">
                                <button class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-xl hover:shadow-pink-300 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content mt-6 hidden" id="marketing">
                        <form class="max-w-sm" action="{{ route('patients.marketing.update', ['id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                                <select name="source" id="sourceInput"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    required>
                                    @if ($patient->source == 'Social Media / Google')
                                        <option value="Social Media / Google" selected>Social Media / Google</option>
                                        <option value="Doctor">Doctor</option>
                                    @elseif ($patient->source == 'Doctor')
                                        <option value="Social Media / Google">Social Media / Google</option>
                                        <option value="Doctor" selected>Doctor</option>
                                        @else
                                        <option value="Social Media / Google">Social Media / Google</option>
                                        <option value="Doctor">Doctor</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-4" id="doctorInputBox">
                                <label for="doctor" class="block text-sm font-medium text-gray-700">Doctor</label>
                                <select name="doctor" id="doctor"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Select doctor" value="{{$patient->appointment_time}}">
                                    @foreach ($doctors as $doctor)
                                        <option @if($patient->doctor == $doctor->id) selected @else @endif value="{{$doctor->id}}">{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 w-full flex justify-end">
                                <button class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-xl hover:shadow-pink-300 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content mt-6 hidden" id="finance">
                        <form class="max-w-sm" action="{{ route('patients.finance.update', ['id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="coupon" class="block text-sm font-medium text-gray-700">Coupon <span class="text-gray-500"></span></label>
                                <select name="coupon" id="coupon" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm" placeholder="Select coupon">
                                        <option>No coupon</option>
                                    @foreach ($coupons as $coupon)
                                        <option @if($patient->coupon == $coupon->code) selected @else @endif value="{{$coupon->code}}">{{$coupon->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="discount" class="block text-sm font-medium text-gray-700">Discount <span class="text-gray-500"></span></label>
                                <input type="number" name="discount" id="discount"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter discount" value="{{$patient->discount}}" />
                            </div>
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Total Price <span class="text-gray-500"></span></label>
                                <input type="number" name="amount" id="amount"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Enter amount" value="{{$patient->amount}}" />
                            </div>
                            <div class="mb-4 w-full flex justify-end">
                                <button class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-xl hover:shadow-pink-300 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content mt-6 hidden" id="additional">
                        <form class="max-w-sm" action="{{ route('patients.additional.update', ['id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700">Appointment Date</label>
                                <input type="date" name="appointment_date" id="appointment_date"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Select date" value="{{$patient->appointment_date}}" required />
                            </div>
                            <div class="mb-4">
                                <label for="appointment_time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
                                <input type="time" name="appointment_time" id="appointment_time"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                    placeholder="Select time" value="{{$patient->appointment_time}}" required />
                            </div>
                            
                            <div class="mb-4 flex flex-col gap-2">
                                <span class="block text-sm font-medium text-gray-700">Services</span>
                                @foreach ($services as $service)
                                <label for="service[{{$service->id}}]" class="flex gap-2 p-3 border border-gray-300 rounded-xl">
                                    <input type="checkbox" name="service" id="service[{{$service->id}}]"
                                        class="mt-1 block p-2 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:ring-primary focus:border-primary sm:text-sm"
                                        value="{{$service->id}}"
                                        @if(in_array($service->id, json_decode($patient->services, true))) checked @endif>
                                    <span class="block text-sm font-medium text-gray-700">{{$service->name}}</span>
                                </label>
                                @endforeach
                            </div>

                            <input type="hidden" name="selected_services" id="selected_services" value="{{ $patient->services }}">



                            <div class="mb-4 w-full flex justify-end">
                                <button class="flex items-center justify-center gap-2 bg-primary rounded-xl text-white px-4 py-2 hover:shadow-xl hover:shadow-pink-300 transition-all">
                                    <i class="fi fi-sr-disk"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('input[name="service"]');
            const hiddenInput = document.getElementById('selected_services');

            function updateSelectedServices() {
                const selectedServices = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedServices.push(checkbox.value);
                    }
                });
                hiddenInput.value = JSON.stringify(selectedServices);
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedServices);
            });

            updateSelectedServices();
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const sourceInput = document.getElementById("sourceInput");
    const doctorInputBox = document.getElementById("doctorInputBox");

    // Function to toggle visibility of the doctor input box
    function toggleDoctorInputBox() {
        if (sourceInput.value === "Doctor") {
            doctorInputBox.style.display = "block";
        } else {
            doctorInputBox.style.display = "none";
        }
    }

    // Initialize the visibility on page load
    toggleDoctorInputBox();

    // Add event listener to the "Referred by" dropdown
    sourceInput.addEventListener("change", toggleDoctorInputBox);
});
</script>
</x-app-layout>
