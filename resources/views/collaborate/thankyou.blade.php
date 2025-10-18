<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-brands/css/uicons-brands.css'>
    
    <link rel="stylesheet" href="{{ asset('/assets/css/doctorform.css') }}">
    <title>Thank You</title>
</head> 
<body>
        <header>
            <h2 class="headerTitle">Dental Collaboration & Team Visit Tracker</h2>
            <img class="logo" src="/storage/images/logo.webp" alt="">
        </header>
    <div class="container2">
        <div class="sliderParent">
            <div class="introBox">
                <div class="imgBox">
                    <!--<img class="coverImg" src="/storage/images/deskCover.jpg">-->
                    <img class="mobCover" src="/storage/images/mobCover.png">
                </div>
                <h4 class="introTitle">Dear {{$name}},</h4>
                <p class="introSubtitle">Thank you for taking the time to fill out our form and for your interest in associating with us. We are truly delighted to have you on board!<br> <br> We have sent all the necessary details to your<br> <br>WhatsApp and email. These include important information about our collaboration, as well as resources that will assist you in our joint efforts to provide exceptional care to our patients. <br> <br> We are looking forward to a fruitful and successful partnership. If you have any questions or need further assistance, please don't hesitate to reach out. Your engagement and collaboration are highly valued.</p>
                <br>
                <span class="introBottomSpan">Warm regards,<br>Joy konark CBCT Centre Team</span>
    
                <!--<div class="introTiming">-->
                <!--    <i class="fi fi-sr-calendar-clock"></i>-->
                <!--    <span>10:00AM - 09:00PM</span>-->
                <!--</div>-->
                <div class="bottomSpacer">
                    
                </div>
            </div>
        </div>
    </div>
        <!--<footer>-->
        <!--    <span>Copyright 2024 | JOY konark</span>-->
        <!--    <a href="/storage/files/Dr_Aarti_Singh Profile_Govt.ppt" class="slideNextBtn" download><i class="fi fi-rr-info"></i> <span>About us</span></a>-->
        <!--</footer>-->

    <!--<script src="{{ asset('/storage/js/doctorFormScript.js') }}"></script>-->
</body>
</html>