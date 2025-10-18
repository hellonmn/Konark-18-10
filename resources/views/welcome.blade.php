<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Joy konark CBCT Centre</title>
    <link rel="stylesheet" href="{{ asset('assets/css/output.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <style>
        ::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }

        input[type="radio"],
        input[type="checkbox"] {
            display: none;
        }

        input[type="radio"]:checked+label,
        input[type="checkbox"]:checked+label {
            border: 2px solid #2563EB;
            /* Blue border for checked state */
            background-color: #e0e7ff;
            /* Light blue background for checked state */
            color: #2563EB;
            /* Text color or checked state */
        }

        .form1 {
            /* transform: translateX(-100%); */
            transition: transform 0.3s ease-in-out;
        }

        .stepsBoxChild {
            /* transform: translateX(-100%); */
            transition: transform 3s;
        }

        .step1 {
            /* transform: translateX(-100%); */
            transition: transform 3s;
        }

        .form2 {
            display: none;
            width: 100%;
            left: 100%;
            /* transform: translateX(100%); */
            transition: transform 0.3s linear;
        }

        .nextForm {
            display: block;
            animation: slide-in .3s linear forwards;
        }

        .hideBanner {
            animation: hide-banner .4s linear forwards;
        }

        @keyframes slide-in {
            from {
                left: 100%;
            }

            to {
                left: 0%;
            }
        }

        @keyframes hide-banner {
            from {
                height: 192px;
                opacity: 1;
            }

            to {
                height: 0%;
                opacity: 0;
                display: none;
            }
        }

        .spinnerparentdiv {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            background: rgba(255, 255, 255, 0.8);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner {
            width: 100%;
            height: 100%;
        }

        .spinnderindiv {
            border: 8px solid rgba(0, 0, 0, 0.1);
            border-left-color: #2563EB;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-white w-screen h-screen sm:px-0 md:px-40 lg:px-96">
    
<!-- Popup Modal -->
    <div id="successPopup" class="fixed inset-0 z-10 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <div class="flex justify-center">
                <!-- Lottie Animation Container -->
                <div id="lottieAnimation" class="w-24 h-24"></div>
            </div>
            <div class="text-center mt-4">
                <h2 class="text-lg font-semibold">Form Submitted Successfully!</h2>
                <!--<button onclick="closePopup()" class="mt-4 px-4 py-2 bg-pink-500 text-white rounded-lg">Close</button>-->
            </div>
        </div>
    </div>

    <script>
        // Lottie Animation
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottieAnimation'),
            renderer: 'svg',
            loop: false,
            autoplay: true,
            path: 'https://api.joykonark.com/formsubmission.json' // Path to your JSON file
        });

        // Function to open popup
        function openPopup() {
            document.getElementById('successPopup').classList.remove('hidden');
        }

        // Function to close popup
        function closePopup() {
            document.getElementById('successPopup').classList.add('hidden');
        }

        // Example of triggering the popup
        // setTimeout(() => {
        //     openPopup();
        // }, 1000); // Popup opens after 1 second for demo purposes
    </script>
    
    <header class="w-full h-20">
        <div class="flex items-center gap-5 w-full h-full p-3">
            <div id="logoBackBox" class="flex hover:bg-plight items-center justify-center w-14 h-14 rounded-xl border">
                <img id="logoImg" src="/storage/images/logo.webp" class="w-full rounded-xl">
                <i onclick="backForm()" id="backButton" class="hidden cursor-pointer fi fi-rr-left text-2xl"></i>
            </div>
            <div class="flex">
                <span class="text-2xl ">Appointment Booking Form</span>
            </div>
        </div>
    </header>
    <div class="imgBox p-3">
        <!--<div class="w-full h-48 rounded-xl bg-plight" style="background-image:url(/storage/images/cover_new.jpeg)"></div>-->
        <img src="/storage/images/cover_new.jpeg" class="border rounded-xl">
    </div>
    <div class="slide1 w-full">
        <main class="w-full p-3">
            <form id="bookingForm" class="formBox mt-5 w-full" method="POST">
                @csrf
                <div class="flex w-full h-fit">
                    <div class="flex relative w-full min-h-full" action="">
                        <div class="form1 w-full">
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="patientName" class="text-gray-800">Patient Name</label>
                                <input type="text" id="patientName" name="name"
                                    class="bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter patient name">
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="patientPhone" class="text-gray-800">Phone Number</label>
                                <input type="number" id="patientPhone" name="phone" class="bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all" placeholder="Enter phone number" maxlength="12" @if($phoneNumber==null) @else value="{{$phoneNumber}}" readonly @endif autocomplete="patient-phone">
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="email" class="text-gray-800">Email Address</label>
                                <input type="email" id="email" name="email"
                                    class="bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter email">
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="age" class="text-gray-800">Age</label>
                                <input type="number" id="age" name="age"
                                    class="bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter your age">
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <span for="email" class="text-gray-800">Select Gender</span>
                                <div class="flex w-full gap-5">
                                    <div class="item w-full">
                                        <input type="radio" id="male" name="gender" class="hidden" value="Male" />
                                        <label for="male"
                                            class="flex items-center justify-center text-gray-400 w-full bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:bg-plight hover:border-plight transition-all"><span></span>Male</span></label>
                                    </div>
                                    <div class="item w-full">
                                        <input type="radio" id="female" name="gender" class="hidden" value="Female" />
                                        <label for="female"
                                            class="flex items-center justify-center text-gray-400 w-full bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:bg-plight hover:border-plight transition-all"><span>Female</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="referredBy" class="text-gray-800">Referred by:</label>
                                <select id="referredBy" name="source"
                                    class="bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all">
                                    <option disabled selected>Click here</option>
                                    <option>Social Media / Google</option>
                                    <option>Doctor</option>
                                </select>
                            </div>
                        </div>
                        <div class="form2 w-full absolute">
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="medicalHistory" class="text-gray-800">Patient Location</label>
                                <select type="text" id="medicalHistory" name="medical_history"
                                    class="bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all" required>
                                    <option value="0" disabled selected>Select</option>
                                    <option value="Anand Vihar">Anand Vihar</option>
                                    <option value="Arthala">Arthala</option>
                                    <option value="Centre Delhi">Centre Delhi</option>
                                    <option value="Chander Nagar">Chander Nagar</option>
                                    <option value="Crossings Republik">Crossings Republik</option>
                                    <option value="East Delhi">East Delhi</option>
                                    <option value="Govindpuram">Govindpuram</option>
                                    <option value="Indirapuram">Indirapuram</option>
                                    <option value="Kadkadduma">Kadkadduma</option>
                                    <option value="Kaushambi">Kaushambi</option>
                                    <option value="Kavi Nagar">Kavi Nagar</option>
                                    <option value="Lajpat Nagar">Lajpat Nagar</option>
                                    <option value="Lohia Nagar">Lohia Nagar</option>
                                    <option value="Loni">Loni</option>
                                    <option value="Madhopura">Madhopura</option>
                                    <option value="Mohan Nagar">Mohan Nagar</option>
                                    <option value="Nehru Nagar">Nehru Nagar</option>
                                    <option value="North Delhi">North Delhi</option>
                                    <option value="Noida">Noida</option>
                                    <option value="Old Ghaziabad">Old Ghaziabad</option>
                                    <option value="Pratap Vihar">Pratap Vihar</option>
                                    <option value="Preet Vihar">Preet Vihar</option>
                                    <option value="Prime Target">Prime Target</option>
                                    <option value="Rajendra Nagar">Rajendra Nagar</option>
                                    <option value="Sahibabad">Sahibabad</option>
                                    <option value="Sanjay Nagar">Sanjay Nagar</option>
                                    <option value="Shalimar Garden">Shalimar Garden</option>
                                    <option value="Shyam Park">Shyam Park</option>
                                    <option value="Surya Nagar">Surya Nagar</option>
                                    <option value="Vaishali">Vaishali</option>
                                    <option value="Vasundhara">Vasundhara</option>
                                    <option value="Vijay Nagar">Vijay Nagar</option>
                                    <option value="Vivek Vihar">Vivek Vihar</option>


                                </select>
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3 w-full">
                                <label for="appointment_time" class="text-gray-800">Appointment Time</label>
                                <input type="time" id="appointment_time" name="appointment_time"
                                    class="bg-gray-100 w-full px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Select appointment time" required>
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3 w-full">
                                <label for="appointment_date" class="text-gray-800">Appointment Date</label>
                                <input type="date" id="appointment_date" name="appointment_date"
                                    class="bg-gray-100 w-full px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Select appointment date" required>
                            </div>
                            <div id="doctorInputBox" class="inputBox flex flex-col space-y-1 mb-3"
                                style="display: none;">
                                <label for="medicalHistory" class="text-gray-800">Referral Doctor</label>
                                <div class="relative inline-block w-full">
                                    <!-- Dropdown Trigger Input (Read-Only) -->
                                    <div class="flex items-center w-full">
                                        <input id="dropdown-trigger" type="text" name="doctor"
                                            placeholder="Click to select..."
                                            class="w-full bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                            readonly />
                                    </div>

                                    <!-- Dropdown Menu with Searchable Input -->
                                    <ul id="dropdown-menu"
                                        class="absolute z-10 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                        <!-- Search Box Inside Dropdown -->
                                        <li class="sticky top-0 bg-white px-4 py-2 border-b">
                                            <input id="dropdown-search" type="text" placeholder="Search doctors..."
                                                class="w-full bg-gray-100 px-4 py-2 rounded-xl border-2 border-gray-200 outline-none" />
                                        </li>

                                        <!-- Doctor List -->
                                        <li class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100"
                                            data-id="0">
                                            <div class="flex">
                                                <div class="flex items-center justify-center text-3xl text-gray-400 w-12 h-12 bg-gray-200 rounded-full">
                                                    <i class="fi fi-rr-forbidden-alt text-gray-400"></i>
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span id="doctorNameDropDown" class="font-semibold">Not in the list</span>
                                                <span class="text-gray-500 text-[12px]">Select this option & enter the information manually.</span>
                                            </div>
                                        </li>
                                        @foreach ($doctors as $doctor)
                                        <li class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100"
                                            data-id="{{ $doctor->id }}">
                                            <div class="flex">
                                                <div class="flex items-center justify-center text-3xl text-gray-400 w-12 h-12 bg-gray-200 rounded-full">
                                                    <i class="fi fi-rr-user text-gray-400"></i>
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span id="doctorNameDropDown" class="font-semibold">{{ $doctor->name
                                                    }}</span>
                                                <span class="text-gray-500 text-[12px]">{{ $doctor->clinic_name
                                                    }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" id="doctor_id" name="doctor_id" />
                                </div>
                            </div>
                        <div id="addDoctor" class="hidden bg-pink-100 p-2 rounded-xl">
                            <input hidden id="isCustomDoctorInput" name="isCustomDoctor" value="">
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="d_name" class="text-gray-800">Doctor name</label>
                                <input type="text" id="d_name" name="d_name"
                                    class="px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter doctor name">
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="d_phone" class="text-gray-800">Doctor phone</label>
                                <input type="text" id="d_phone" name="d_phone"
                                    class="px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter doctor phone">
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="clinic_name" class="text-gray-800">Clinic name</label>
                                <input type="text" id="clinic_name" name="clinic_name"
                                    class="px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter clinic name">
                            </div>
                        </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <span for="email" class="text-gray-800">Select Service(s)</span>
                                <div class="flex flex-col w-full gap-2">
                                    @foreach ($services as $service)
                                    <div class="item w-full aspect-auto">
                                        <input type="checkbox" id="{{ $service->id }}" name="service"
                                            class="service-checkbox hidden" data-price="{{ $service->price }}"
                                            data-id="{{ $service->id }}" />
                                        <label for="{{ $service->id }}"
                                            class="flex items-center justify-between text-gray-400 w-full bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none hover:bg-plight hover:border-plight focus:border-primary transition-all">
                                            <span>{{ $service->name }}</span><span class="font-bold">₹{{ $service->price
                                                }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- Hidden input to store selected service IDs -->
                                <input type="text" hidden id="selectedServiceIds" name="selectedServiceIds" value="" />
                            </div>


                            <div class="priceBox flex flex-col gap-2 border border-plight w-full rounded-xl p-3">
                                <div
                                    class="totalAmountBox flex items-center justify-between w-full rounded-xl px-3 py-4">
                                    <span class="text-lg text-gray-800">Total amount:</span>
                                    <span class="text-lg text-gray-900 font-bold">₹ 0</span>
                                </div>
                                <div
                                    class="totalAmountBox flex items-center justify-between w-full rounded-xl px-3 py-4">
                                    <span class="text-lg text-gray-800">Discount:</span>
                                    <span class="text-lg text-gray-900 font-bold">₹ 0</span>
                                </div>
                                <div
                                    class="totalAmountBox flex items-center justify-between w-full border-t px-3 py-4">
                                    <span class="text-lg text-gray-800 font-bold">Final amount:</span>
                                    <span class="text-lg text-gray-900 font-bold">₹ 0</span>
                                </div>
                            </div>
                            <div class="couponBox w-full">
                                <div class="inputBox flex gap-2 mt-3 w-full">
                                    <input type="text" id="couponHiddenInput" name="couponHiddenInput" hidden>
                                    <input type="text" id="couponCode" name="coupon"
                                        class="w-full bg-gray-100 px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                        placeholder="Coupon code">
                                    <button id="applyCouponButton"
                                        class="bg-primary text-textColor rounded-xl px-6">Apply</button>
                                </div>
                                <div class="flex">
                                    <span id="CouponAlertMessage" class="hidden"></span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- <div class="flex w-full max-h-full"><br></div> -->
                <div id="footer" class="footer w-full my-4">
                    <!-- <div class="stepsBox flex flex-col space-y-1 w-full justify-center items-center mb-4">
                        <div class="flex stepsBoxChild items-center rounded-xl gap-2 w-20 bg-plight ">
                            <div class="step1 w-1/2 h-2 bg-primary rounded-xl"></div>
                        </div>
                    </div> -->

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="w-full inputBox flex flex-col space-y-1 mb-3">
                        <input onclick="showForm2()" type="button" id="slideNextBtn"
                            class="slideNextBtn bg-primary cursor-pointer text-textColor px-4 py-3 rounded-xl border-2 border-primary outline-none focus:border-primary hover:border-primary transition-all"
                            value="Next" />
                        <input type="submit" id="submitBtn"
                            class="submitBtn hidden bg-primary cursor-pointer text-textColor px-4 py-3 rounded-xl border-2 border-primary outline-none focus:border-primary hover:border-primary transition-all"
                            value="Submit" />

                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- Spinner -->
    <!-- Spinner -->
    <div id="spinner" class="spinner hidden">
        <div class="spinner div spinnerparentdiv">
            <div class="spinnderindiv"></div>
        </div>
    </div>


    <script src="{{ asset('assets/js/bookingform/slideForm.js') }}"></script>
    <script src="{{ asset('assets/js/bookingform/priceUpdate.js') }}"></script>
    <script src="{{ asset('assets/js/bookingform/doctorDropdown.js') }}"></script>

    <script>
        // Restrict phone number input to 10 digits
        const patientPhoneInput = document.getElementById('patientPhone');

        patientPhoneInput.addEventListener('input', function () {
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12); // Trim the input to the first 10 digits
            }
        });

        patientPhoneInput.addEventListener('keypress', function (event) {
            if (this.value.length >= 10 && event.key !== 'Backspace') {
                event.preventDefault(); // Prevent any additional input beyond 10 digits
            }
        });
    </script>


    <script>
        document.getElementById('submitBtn').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default form submission


            // Get the value of the "Referred by" dropdown
            const referredByValue = document.getElementById('referredBy').value;
            // Get the input value for the selected doctor
            const doctorInput = document.getElementById('dropdown-trigger').value;
            // Get the list of selected services
            const selectedServices = document.querySelectorAll('.service-checkbox:checked');
            
            // Get Medical History, Appointment Time, and Appointment Date fields
            const medicalHistory = document.getElementById('medicalHistory');
            const appointmentTime = document.getElementById('appointment_time');
            const appointmentDate = document.getElementById('appointment_date');

            // Check if Medical History is filled
            if (medicalHistory.value === "0") {
                medicalHistory.classList.add('border-red-500');
                alert('Please select you location.');
                return;
            }else{
                medicalHistory.classList.remove('border-red-500');
            }
        
            // Check if Appointment Time is filled
            if (!appointmentTime.value) {
                appointmentTime.classList.add('border-red-500');
                alert('Please select an appointment time.');
                return;
            }else{
                appointmentTime.classList.remove('border-red-500');
            }
        
            // Check if Appointment Date is filled
            if (!appointmentDate.value) {
                appointmentDate.classList.add('border-red-500');
                alert('Please select an appointment date.');
                return;
            }else{
                appointmentDate.classList.remove('border-red-500');
            }
            // Check if "Doctor" is selected in the "Referred by" dropdown
            if (referredByValue === 'Doctor' && !doctorInput) {
                alert('Please select a doctor.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Ensure at least one service is selected
            if (selectedServices.length === 0) {
                alert('Please select at least one service.');
                event.preventDefault(); // Prevent form submission
                return;
            }
            
            // Show the spinner
            document.getElementById('spinner').classList.remove('hidden');
            document.getElementById('spinner').classList.add('flex');

            // Get the form element
            const form = document.getElementById('bookingForm');
            if (!form) {
                console.error('Form element not found');
                document.getElementById('spinner').classList.add('hidden');
                document.getElementById('spinner').classList.remove('flex'); // Hide spinner in case of error
                return;
            }

            // Create FormData from the form
            const formData = new FormData(form);

            // Perform the fetch request
            fetch('/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    console.log(response);
                    return response.json();
                })
                .then(data => {
                    // Hide the spinner
                    document.getElementById('spinner').classList.add('hidden');
                    document.getElementById('spinner').classList.remove('flex');

                    // Handle response
                    if (data.status === 'success') {
                        form.reset();
                        form.querySelectorAll('input, select, textarea, button').forEach(element => {
                            element.disabled = true;
                        });
                        const submitBtn = document.getElementById('submitBtn');
                        if (submitBtn) {
                            submitBtn.value = 'Submitted'; // Change button text
                            submitBtn.disabled = true; // Optionally, disable the button
                            openPopup();
                        }
                        window.location.href = data.redirectUrl;
                    } else {
                        alert('An error occurred: ' + data.message);
                    }
                })
                .catch(error => {
                    // Hide the spinner
                    document.getElementById('spinner').classList.add('hidden');
                    document.getElementById('spinner').classList.remove('flex');

                    // Handle network error
                    // console.error('Fetch error:', error);
                    alert('Network error: ' + error.message);
                });
        });

        function validateForm(event) {
            // Get the value of the "Referred by" dropdown
            const referredByValue = document.getElementById('referredBy').value;
            // Get the input value for the selected doctor
            const doctorInput = document.getElementById('dropdown-trigger').value;
            // Get the list of selected services
            const selectedServices = document.querySelectorAll('.service-checkbox:checked');

            // Check if "Doctor" is selected in the "Referred by" dropdown
            if (referredByValue === 'Doctor' && !doctorInput) {
                alert('Please select a doctor.');
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Ensure at least one service is selected
            if (selectedServices.length === 0) {
                alert('Please select at least one service.');
                event.preventDefault(); // Prevent form submission
                return;
            }
        }

    </script>



</body>

</html>