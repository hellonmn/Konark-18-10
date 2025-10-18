<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Success</title>
  <!-- Tailwind CSS CDN -->
  <link rel="stylesheet" href="{{ asset('assets/css/output.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
  <!-- Lottie Web CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
  <style>
    body {
      background-color: #fbcfe8; /* Tailwind pink-100 */
    }
  </style>
</head>
<body class="flex items-center justify-center h-screen">
    @if (session('status'))
            <div class="text-center">
            <div id="lottie-animation" class="w-48 h-48 mx-auto mb-6"></div>
            <div class="flex flex-col w-full items-center justify-center">
                <h1 class="text-2xl font-bold text-primary text-center">Thank you</h1>
                <h1 class="text-sm text-gray-600 text-center">Form Submitted Successfully. Redirecting you to WhatsApp...</h1>
            </div>
            <div class="absolute bottom-2 flex flex-col w-full items-center justify-center">
                <h1 class="text-sm text-gray-500 text-center">Redirecting you to WhatsApp...</h1>
            </div>
          </div>
        @else
            <h1 class="text-2xl font-bold text-pink-600">Unauthorized Access</h1>
            <p class="text-gray-600">You cannot access this page directly.</p>
        @endif
  
  <script>
        // Prevent caching of the success page
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Load Lottie animation
      var animation = lottie.loadAnimation({
        container: document.getElementById('lottie-animation'), // The DOM element
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/storage/lottie//D2CO1DU7k4.json' // Path to the JSON file
      });
    });
  </script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Time delay in milliseconds (2000ms = 2 seconds)
      setTimeout(function() {
        // WhatsApp deep link
        const whatsappURL = "https://wa.me/917696747696"; // Replace YOUR_PHONE_NUMBER with the actual phone number

        // Redirect to WhatsApp
        window.location.href = whatsappURL;
      }, 2000); // 2000 milliseconds = 2 seconds
    });
  </script>
</body>
</html>
