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
    <header class="w-full h-20">
        <div class="flex items-center gap-5 w-full h-full p-3">
            <div id="logoBackBox" class="flex hover:bg-plight items-center justify-center w-14 h-14 rounded-xl border">
                <img id="logoImg" src="/storage/images/logo.webp" class="w-full rounded-xl">
                <i onclick="backForm()" id="backButton" class="hidden cursor-pointer fi fi-rr-left text-2xl"></i>
            </div>
            <div class="flex">
                <span class="text-2xl ">Association Form</span>
            </div>
        </div>
    </header>
    <div class="imgBox p-3">
        <!--<div class="w-full h-48 rounded-xl bg-plight" style="background-image:url(/storage/images/cover_new.jpeg)"></div>-->
        <img src="/storage/images/cover_new.jpeg" class="border rounded-xl">
    </div>
    <div class="slide1 w-full">
        <main class="w-full p-3">
            <form action="{{ route('patient.form.camp.store')}}" id="bookingForm" class="formBox mt-5 w-full" method="POST">
                @csrf
                <div class="flex w-full h-fit">
                    <div class="flex relative w-full min-h-full" action="">
                        <div class="form1 w-full">
                            <div id="addDoctor" class="rounded-xl">
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="d_name" class="text-gray-800">Doctor name</label>
                                <input type="text" id="d_name" name="d_name"
                                    class="px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter doctor name" required>
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="d_phone" class="text-gray-800">Doctor phone</label>
                                <input type="text" id="d_phone" name="d_phone"
                                    class="px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter doctor phone" required>
                            </div>
                            <div class="inputBox flex flex-col space-y-1 mb-3">
                                <label for="clinic_name" class="text-gray-800">Clinic name</label>
                                <input type="text" id="clinic_name" name="clinic_name"
                                    class="px-4 py-3 rounded-xl border-2 border-gray-200 outline-none focus:border-primary hover:border-primary transition-all"
                                    placeholder="Enter clinic name" required>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div id="footer" class="footer w-full my-4">
                    <div class="w-full inputBox flex flex-col space-y-1 mb-3">
                        <input type="submit" id="submitBtn"
                            class="submitBtn bg-primary cursor-pointer text-textColor px-4 py-3 rounded-xl border-2 border-primary outline-none focus:border-primary hover:border-primary transition-all"
                            value="Submit" />

                    </div>
                </div>
            </form>
        </main>
    </div>


</body>

</html>