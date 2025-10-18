<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-brands/css/uicons-brands.css'>
    <title>Doctor Collaboration Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F8BBD0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            background: #EC407A;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .headerTitle {
            font-size: 1.4rem;
            font-weight: 600;
        }
        .logo {
            height: 35px;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        .logo:hover {
            transform: scale(1.1);
        }
        .header-actions {
            display: flex;
            gap: 8px;
        }
        .actionBtn {
            padding: 8px 16px;
            background: #FFFFFF;
            color: #EC407A;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .actionBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(236, 64, 122, 0.3);
        }
        .actionBtn:active {
            transform: translateY(1px);
            box-shadow: 0 1px 2px rgba(236, 64, 122, 0.3);
        }
        .actionBtn:disabled {
            background: #E0E0E0;
            color: #B0BEC5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .logoutBtn {
            background: #F8BBD0;
            color: #FFFFFF;
        }
        .logoutBtn:hover {
            background: #EC407A;
            box-shadow: 0 4px 8px rgba(236, 64, 122, 0.3);
        }
        .logoutForm {
            display: inline;
        }

        /* Main Container */
        main.container {
            max-width: 600px;
            margin: 80px auto 20px;
            padding: 0 15px;
            flex: 1;
        }

        /* Form Styles */
        .formBox {
            background: #FFFFFF;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #F8BBD0;
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .formTitle {
            text-align: center;
            margin-bottom: 25px;
            color: #EC407A;
            font-size: 1.6rem;
            font-weight: 600;
            position: relative;
        }
        .formTitle::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #EC407A;
            border-radius: 3px;
        }
        .inputBox {
            margin-bottom: 24px;
            opacity: 0;
            transform: translateY(10px);
            animation: slideIn 0.4s ease-out forwards;
        }
        .inputBox:nth-child(1) { animation-delay: 0.1s; }
        .inputBox:nth-child(2) { animation-delay: 0.2s; }
        .inputBox:nth-child(3) { animation-delay: 0.3s; }
        .inputBox:nth-child(4) { animation-delay: 0.4s; }
        .inputBox:nth-child(5) { animation-delay: 0.5s; }
        .inputBox:nth-child(6) { animation-delay: 0.6s; }
        .inputBox:nth-child(7) { animation-delay: 0.7s; }
        .inputBox:nth-child(8) { animation-delay: 0.8s; }
        .inputBox:nth-child(9) { animation-delay: 0.9s; }
        .inputBox:nth-child(10) { animation-delay: 1.0s; }
        .inputBox:nth-child(11) { animation-delay: 1.1s; }
        @keyframes slideIn {
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Improved Input Wrapper */
        .inputWrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #F5F5F5;
            border-radius: 10px;
            padding: 4px 10px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 56px; /* Fixed height for consistency */
        }
        .inputWrapper:focus-within {
            border-color: #EC407A;
            background: #FFF;
            box-shadow: 0 0 10px rgba(236, 64, 122, 0.15);
        }
        .inputWrapper i {
            color: #EC407A;
            font-size: 1.2rem;
            margin-right: 10px;
            transition: transform 0.2s;
            min-width: 20px; /* Ensure icon has fixed width */
        }
        .inputWrapper:focus-within i {
            transform: scale(1.1);
        }
        
        /* Improved Label Positioning */
        .inputLabel {
            position: absolute;
            left: 40px; /* Position after icon */
            top: 50%;
            transform: translateY(-50%);
            color: #90A4AE;
            font-size: 0.9rem;
            font-weight: 400;
            pointer-events: none;
            transition: all 0.25s ease;
            background: transparent;
            padding: 0 4px;
            z-index: 1;
        }
        .inputWrapper.filled .inputLabel,
        .inputWrapper:focus-within .inputLabel {
            top: 0;
            transform: translateY(-50%) scale(0.85);
            left: 35px;
            color: #EC407A;
            background: #FFFFFF;
            z-index: 2;
        }
        
        /* Improved Text Input */
        .textInput {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            padding: 8px 5px;
            font-size: 0.95rem;
            color: #424242;
            position: relative;
            z-index: 1;
            margin-top: 4px; /* Ensure text doesn't get cut off */
            height: 40px; /* Fixed height */
            line-height: normal;
        }
        
        /* For dropdowns, ensure they have enough space */
        select.textInput {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23EC407A' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 8px) center;
            padding-right: 30px;
        }
        
        /* Location Button */
        .locationBtn {
            margin-left: 8px;
            padding: 8px 12px;
            background: #EC407A;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(236, 64, 122, 0.3);
            min-width: 110px;
            text-align: center;
        }
        .locationBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(236, 64, 122, 0.4);
        }
        .locationBtn:active {
            transform: translateY(1px);
            box-shadow: 0 1px 2px rgba(236, 64, 122, 0.3);
        }
        .locationBtn:disabled {
            background: #E0E0E0;
            color: #B0BEC5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .errorMessage {
            color: #EC407A;
            font-size: 0.8rem;
            margin-top: 6px;
            min-height: 16px;
            font-weight: 500;
        }
        .bottomSpacer {
            height: 20px;
        }

        /* Popup Styles */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(2px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .popup.show {
            opacity: 1;
            visibility: visible;
        }
        .popupContent {
            background: #FFFFFF;
            padding: 25px;
            border-radius: 16px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border-top: 5px solid #EC407A;
            transform: translateY(50px);
            transition: all 0.4s ease;
            opacity: 0;
        }
        .popup.show .popupContent {
            transform: translateY(0);
            opacity: 1;
        }
        .popupContent h4 {
            margin: 0 0 20px;
            text-align: center;
            color: #EC407A;
            font-size: 1.4rem;
            font-weight: 600;
        }
        .popupActions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 25px;
        }
        .backBtn {
            padding: 10px 20px;
            background: #E0E0E0;
            color: #424242;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            min-width: 80px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .backBtn:hover {
            transform: translateY(-2px);
            background: #D0D0D0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .backBtn:active {
            transform: translateY(1px);
        }

        /* Footer Styles */
        footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #FFFFFF;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: auto;
        }
        footer span {
            color: #90A4AE;
            font-size: 0.85rem;
        }
        .submitBtn {
            padding: 10px 30px;
            background: #EC407A;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 3px 8px rgba(236, 64, 122, 0.3);
            letter-spacing: 0.5px;
        }
        .submitBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(236, 64, 122, 0.4);
            background: #D81B60;
        }
        .submitBtn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 5px rgba(236, 64, 122, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 10px 15px;
            }
            .header-left {
                flex-direction: row;
                align-items: center;
                width: 100%;
                justify-content: space-between;
            }
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            .actionBtn {
                flex: 1;
                text-align: center;
                padding: 8px 10px;
                font-size: 0.8rem;
            }
            main.container {
                margin-top: 110px;
                padding: 0 12px;
            }
            .formBox {
                padding: 20px 15px;
            }
            .formTitle {
                font-size: 1.4rem;
            }
            .inputWrapper {
                height: 52px;
            }
            .locationBtn {
                min-width: auto;
                padding: 6px 10px;
                font-size: 0.8rem;
            }
            .popupContent {
                width: 95%;
                padding: 20px 15px;
            }
            .popupActions {
                flex-direction: column-reverse;
                gap: 10px;
            }
            .popupActions button {
                width: 100%;
            }
        }
    </style>
</head> 
<body>
    <header>
        <div class="header-left">
            <img class="logo" src="/storage/images/logo.webp" alt="Joy Konark Logo">
            <h2 class="headerTitle">Dental Collaboration</h2>
        </div>
        <div class="header-actions">
            <button type="button" id="punchLocationBtn" class="actionBtn">Punch Location</button>
            <form action="{{ route('logout') }}" method="POST" class="logoutForm">
                @csrf
                <button type="submit" class="actionBtn logoutBtn">Logout</button>
            </form>
        </div>
    </header>
    <main class="container">
        <div class="formBox">
            <h4 class="formTitle">Collaboration Form</h4>
            <form action="{{ route('doctors.collaborate.store') }}" method="POST" id="mainForm">
                @csrf
                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-user"></i>
                        <input type="text" class="textInput" id="doctor_name" name="doctor_name" value="{{ old('doctor_name') }}" required>
                        <label for="doctor_name" class="inputLabel">Doctor's Name</label>
                    </div>
                    <x-input-error :messages="$errors->get('doctor_name')" />
                </div>
                
                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-brands-whatsapp"></i>
                        <input type="tel" 
                               class="textInput" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required 
                               maxlength="10" 
                               minlength="10" 
                               pattern="[0-9]{10}" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <label for="phone" class="inputLabel">WhatsApp Number</label>
                    </div>
                    <x-input-error :messages="$errors->get('phone')" />
                </div>
                
                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-envelope"></i>
                        <input type="email" class="textInput" id="email" name="email" value="{{ old('email') }}" required>
                        <label for="email" class="inputLabel">Email ID</label>
                    </div>
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-hospital"></i>
                        <input type="text" class="textInput" id="clinic_name" name="clinic_name" value="{{ old('clinic_name') }}" required>
                        <label for="clinic_name" class="inputLabel">Clinic's Name</label>
                    </div>
                    <x-input-error :messages="$errors->get('clinic_name')" />
                </div>

                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-marker"></i>
                        <select class="textInput" id="clinic_location" name="clinic_location" required>
                            <option value="" disabled {{ old('clinic_location') ? '' : 'selected' }}></option>
                            <option value="Vasundhra" {{ old('clinic_location') == 'Vasundhra' ? 'selected' : '' }}>Vasundhra</option>
                            <option value="Vaishali" {{ old('clinic_location') == 'Vaishali' ? 'selected' : '' }}>Vaishali</option>
                            <option value="Indirapuram" {{ old('clinic_location') == 'Indirapuram' ? 'selected' : '' }}>Indirapuram</option>
                            <option value="Sahibabad" {{ old('clinic_location') == 'Sahibabad' ? 'selected' : '' }}>Sahibabad</option>
                            <option value="East Delhi" {{ old('clinic_location') == 'East Delhi' ? 'selected' : '' }}>East Delhi</option>
                            <option value="North Delhi" {{ old('clinic_location') == 'North Delhi' ? 'selected' : '' }}>North Delhi</option>
                            <option value="Other" {{ old('clinic_location') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <label for="clinic_location" class="inputLabel">Clinic Location</label>
                    </div>
                    <x-input-error :messages="$errors->get('clinic_location')" />
                </div>
                
                <!--<div class="inputBox">-->
                <!--    <div class="inputWrapper">-->
                <!--        <i class="fi fi-sr-id-card-clip-alt"></i>-->
                <!--        <input type="number" class="textInput" id="gpay_number" name="gpay_number" value="{{ old('gpay_number') }}" required>-->
                <!--        <label for="gpay_number" class="inputLabel">GPay Number</label>-->
                <!--    </div>-->
                <!--    <x-input-error :messages="$errors->get('gpay_number')" />-->
                <!--</div>-->

                <!--<div class="inputBox">-->
                <!--    <div class="inputWrapper">-->
                <!--        <i class="fi fi-brands-google"></i>-->
                <!--        <input type="text" class="textInput" id="upi" name="upi" value="{{ old('upi') }}" required>-->
                <!--        <label for="upi" class="inputLabel">UPI ID</label>-->
                <!--    </div>-->
                <!--    <x-input-error :messages="$errors->get('upi')" />-->
                <!--</div>-->

                <div class="inputBox">
                    <div class="inputWrapper filled">
                        <i class="fi fi-sr-id-card-clip-alt"></i>
                        <input type="text" class="textInput" id="representative_name" name="representative_name" value="{{ Auth::user()->name }}" disabled>
                        <label for="representative_name" class="inputLabel">Representative</label>
                        <input type="hidden" name="representative" value="{{ Auth::user()->id }}">
                    </div>
                    <x-input-error :messages="$errors->get('representative')" />
                </div>

                <!--<div class="inputBox">-->
                <!--    <div class="inputWrapper">-->
                <!--        <i class="fi fi-sr-messages"></i>-->
                <!--        <select class="textInput" id="meeting_purpose" name="meeting_purpose" required>-->
                <!--            <option value="" disabled {{ old('meeting_purpose') ? '' : 'selected' }}></option>-->
                <!--            <option value="Meeting for CBCT Centre Collaboration" {{ old('meeting_purpose') == 'Meeting for CBCT Centre Collaboration' ? 'selected' : '' }}>CBCT Centre Collaboration</option>-->
                <!--            <option value="Team Visit for Gifts Distribution" {{ old('meeting_purpose') == 'Team Visit for Gifts Distribution' ? 'selected' : '' }}>Gifts Distribution</option>-->
                <!--            <option value="Team Visit for Referral Fee Distribution" {{ old('meeting_purpose') == 'Team Visit for Referral Fee Distribution' ? 'selected' : '' }}>Referral Fee Distribution</option>-->
                <!--            <option value="Oral Consultant Visit" {{ old('meeting_purpose') == 'Oral Consultant Visit' ? 'selected' : '' }}>Oral Consultant Visit</option>-->
                <!--            <option value="Followup Meeting" {{ old('meeting_purpose') == 'Followup Meeting' ? 'selected' : '' }}>Followup Meeting</option>-->
                <!--            <option value="Other" {{ old('meeting_purpose') == 'Other' ? 'selected' : '' }}>Other</option>-->
                <!--        </select>-->
                <!--        <label for="meeting_purpose" class="inputLabel">Meeting Purpose</label>-->
                <!--    </div>-->
                <!--    <x-input-error :messages="$errors->get('meeting_purpose')" />-->
                <!--</div>-->
                
                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-flag"></i>
                        <input type="text" class="textInput" id="feedback" name="feedback" value="{{ old('feedback') }}" required>
                        <label for="feedback" class="inputLabel">Address</label>
                    </div>
                    <x-input-error :messages="$errors->get('feedback')" />
                </div>

                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-marker"></i>
                        <input type="text" class="textInput" id="form_location" name="location_display" readonly>
                        <label for="form_location" class="inputLabel">Your Location</label>
                        <button type="button" id="getFormLocationBtn" class="locationBtn">Get Location</button>
                    </div>
                    <x-input-error :messages="$errors->get('location')" />
                    <div id="formLocationError" class="errorMessage"></div>
                </div>

                <!-- Hidden fields for doctor form location -->
                <input type="hidden" name="latitude" id="form_latitude">
                <input type="hidden" name="longitude" id="form_longitude">
                
                <div class="bottomSpacer"></div>
            </form>
        </div>
    </main>

    <!-- Location Punch Popup -->
    <div id="locationPopup" class="popup">
        <div class="popupContent">
            <h4>Punch Location</h4>
            <form id="locationForm" action="{{ route('representative.location.store') }}" method="POST">
                @csrf
                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-marker"></i>
                        <select class="textInput" id="punch_type" name="type" required>
                            <option value="" disabled selected></option>
                            <option value="In">In</option>
                            <option value="Out">Out</option>
                        </select>
                        <label for="punch_type" class="inputLabel">Punch Type</label>
                    </div>
                    <x-input-error :messages="$errors->get('type')" />
                </div>
                <div class="inputBox">
                    <div class="inputWrapper">
                        <i class="fi fi-sr-marker"></i>
                        <input type="text" class="textInput" id="punch_location" name="location_display" readonly>
                        <label for="punch_location" class="inputLabel">Location</label>
                        <button type="button" id="getPunchLocationBtn" class="locationBtn">Get Location</button>
                    </div>
                    <x-input-error :messages="$errors->get('location')" />
                    <div id="punchLocationError" class="errorMessage"></div>
                </div>
                <input type="hidden" name="latitude" id="punch_latitude">
                <input type="hidden" name="longitude" id="punch_longitude">
                <div class="popupActions">
                    <button type="button" id="closePopupBtn" class="backBtn">Cancel</button>
                    <button type="submit" id="saveLocationBtn" class="actionBtn" disabled>Save</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <span>Copyright 2025 | JOY Konark</span>
        <button type="button" id="submitButton" class="submitBtn">Submit</button>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('mainForm');
            const locationForm = document.getElementById('locationForm');
            const submitButton = document.getElementById('submitButton');
            const getFormLocationBtn = document.getElementById('getFormLocationBtn');
            const getPunchLocationBtn = document.getElementById('getPunchLocationBtn');
            const saveLocationBtn = document.getElementById('saveLocationBtn');
            const punchLocationBtn = document.getElementById('punchLocationBtn');
            const closePopupBtn = document.getElementById('closePopupBtn');
            const locationPopup = document.getElementById('locationPopup');
            const formLocationInput = document.getElementById('form_location');
            const punchLocationInput = document.getElementById('punch_location');
            const formLatitudeInput = document.getElementById('form_latitude');
            const formLongitudeInput = document.getElementById('form_longitude');
            const punchLatitudeInput = document.getElementById('punch_latitude');
            const punchLongitudeInput = document.getElementById('punch_longitude');
            const formLocationError = document.getElementById('formLocationError');
            const punchLocationError = document.getElementById('punchLocationError');
            let formLocationObtained = false;
            let punchLocationObtained = false;

            // Function to toggle 'filled' class on inputWrapper
            function toggleFilledClass(element, wrapper) {
                const isFilled = element.tagName === 'SELECT'
                    ? element.value !== '' && element.value !== null
                    : element.value.trim() !== '';
                wrapper.classList.toggle('filled', isFilled);
            }

            // Initialize floating labels for all inputs and selects
            document.querySelectorAll('.inputWrapper').forEach(wrapper => {
                const input = wrapper.querySelector('.textInput');
                if (input) {
                    // Initial check
                    toggleFilledClass(input, wrapper);

                    // On input change
                    input.addEventListener('input', () => toggleFilledClass(input, wrapper));

                    // On focus
                    input.addEventListener('focus', () => wrapper.classList.add('filled'));

                    // On blur
                    input.addEventListener('blur', () => toggleFilledClass(input, wrapper));
                }
            });

            // Function to perform reverse geocoding
            async function reverseGeocode(lat, lon) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`);
                    const data = await response.json();
                    return data.display_name || `Lat: ${lat.toFixed(4)}, Lon: ${lon.toFixed(4)}`;
                } catch (error) {
                    console.error('Reverse geocoding failed:', error);
                    return `Lat: ${lat.toFixed(4)}, Lon: ${lon.toFixed(4)}`;
                }
            }

            // Function to get location
            function getLocation(input, latInput, lonInput, btn, errorDiv, callback, retryCount = 0, maxRetries = 3) {
                if (navigator.geolocation) {
                    btn.textContent = 'Getting Location...';
                    btn.disabled = true;
                    
                    navigator.geolocation.getCurrentPosition(
                        async function (position) {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            latInput.value = latitude;
                            lonInput.value = longitude;

                            const locationName = await reverseGeocode(latitude, longitude);
                            input.value = locationName;

                            // Update filled state after setting value
                            const wrapper = input.closest('.inputWrapper');
                            toggleFilledClass(input, wrapper);

                            const isCorrect = confirm(`Is this your location: ${locationName}?`);
                            if (isCorrect) {
                                callback(true);
                                btn.textContent = 'Location Captured';
                                btn.disabled = true;
                                errorDiv.style.display = 'none';
                            } else if (retryCount < maxRetries) {
                                alert('Please try again to get a more accurate location.');
                                btn.textContent = 'Get Location';
                                btn.disabled = false;
                                getLocation(input, latInput, lonInput, btn, errorDiv, callback, retryCount + 1, maxRetries);
                            } else {
                                alert('Maximum retry attempts reached. Please ensure location services are enabled.');
                                callback(false);
                                btn.textContent = 'Retry Location';
                                btn.disabled = false;
                                errorDiv.style.display = 'none';
                            }
                        },
                        function (error) {
                            callback(false);
                            btn.textContent = 'Get Location';
                            btn.disabled = false;
                            errorDiv.style.display = 'block';
                            if (error.code === error.PERMISSION_DENIED) {
                                errorDiv.textContent = 'Location permission denied. Please enable location access.';
                            } else if (retryCount < maxRetries) {
                                errorDiv.textContent = `Unable to retrieve location. Retrying (${retryCount + 1}/${maxRetries})...`;
                                setTimeout(() => getLocation(input, latInput, lonInput, btn, errorDiv, callback, retryCount + 1, maxRetries), 1000);
                            } else {
                                errorDiv.textContent = 'Failed to get location. Please try again.';
                            }
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Geolocation is not supported by your browser.');
                    callback(false);
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = 'Geolocation not supported.';
                }
            }

            // Show/hide popup with animation
            punchLocationBtn.addEventListener('click', () => {
                locationPopup.classList.add('show');
            });

            closePopupBtn.addEventListener('click', () => {
                locationPopup.classList.remove('show');
                setTimeout(() => {
                    locationForm.reset();
                    punchLocationObtained = false;
                    getPunchLocationBtn.textContent = 'Get Location';
                    getPunchLocationBtn.disabled = false;
                    saveLocationBtn.disabled = true;
                    punchLocationError.style.display = 'none';
                    punchLocationError.textContent = '';
                    // Reset filled state for popup inputs
                    locationForm.querySelectorAll('.inputWrapper').forEach(wrapper => {
                        wrapper.classList.remove('filled');
                    });
                }, 300); // Match animation duration
            });

            // Event listener for punch location
            getPunchLocationBtn.addEventListener('click', () => {
                punchLocationError.style.display = 'none';
                punchLocationError.textContent = '';
                getLocation(punchLocationInput, punchLatitudeInput, punchLongitudeInput, getPunchLocationBtn, punchLocationError, (success) => {
                    punchLocationObtained = success;
                    saveLocationBtn.disabled = !success || !document.getElementById('punch_type').value;
                });
            });

            // Event listener for doctor form location
            getFormLocationBtn.addEventListener('click', () => {
                formLocationError.style.display = 'none';
                formLocationError.textContent = '';
                getLocation(formLocationInput, formLatitudeInput, formLongitudeInput, getFormLocationBtn, formLocationError, (success) => {
                    formLocationObtained = success;
                });
            });

            // Event listener for punch type selection
            document.getElementById('punch_type').addEventListener('change', () => {
                saveLocationBtn.disabled = !punchLocationObtained || !document.getElementById('punch_type').value;
                toggleFilledClass(document.getElementById('punch_type'), document.getElementById('punch_type').closest('.inputWrapper'));
            });

            // Event listener for saving location
            locationForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (!punchLocationObtained) {
                    alert('Please capture your location first.');
                    return;
                }
                if (!document.getElementById('punch_type').value) {
                    alert('Please select a punch type.');
                    return;
                }

                const formData = new FormData(locationForm);
                try {
                    const response = await fetch(locationForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (response.ok) {
                        alert(data.message);
                        locationPopup.classList.remove('show');
                        setTimeout(() => {
                            locationForm.reset();
                            punchLocationObtained = false;
                            getPunchLocationBtn.textContent = 'Get Location';
                            getPunchLocationBtn.disabled = false;
                            saveLocationBtn.disabled = true;
                            punchLocationError.style.display = 'none';
                            punchLocationError.textContent = '';
                            // Reset filled state for popup inputs
                            locationForm.querySelectorAll('.inputWrapper').forEach(wrapper => {
                                wrapper.classList.remove('filled');
                            });
                        }, 300);
                    } else {
                        alert(data.error || 'Failed to save location.');
                    }
                } catch (error) {
                    console.error('Error saving location:', error);
                    alert('An error occurred: ' + error.message);
                }
            });

            // Event listener for doctor form submission
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();
                
                if (!formLocationObtained) {
                    alert('Please provide your location before submitting.');
                    getFormLocationBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                if (form.checkValidity()) {
                    form.submit();
                } else {
                    // Find the first invalid input and scroll to it
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                    form.reportValidity();
                }
            });
        });
    </script>
</body>
</html>