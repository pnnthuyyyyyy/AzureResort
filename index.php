<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure Resort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Links -->
    <?php require('inc/links.php'); ?>
</head>

<body>

    <!-- Header -->
    <?php
    require('inc/header.php');
    ?>
    <!-- The slideshow -->
    <div class="container-fluid px-lg-4 mt-4">
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="30" effect="fade" navigation="true">
            <swiper-slide>
                <img src="./images/banner/1.png" />
            </swiper-slide>
            <swiper-slide>
                <img src="./images/banner/2.png" />
            </swiper-slide>
            <swiper-slide>
                <img src="./images/banner/3.png" />
            </swiper-slide>
            <swiper-slide>
                <img src="./images/banner/4.png" />
            </swiper-slide>
        </swiper-container>
    </div>
    <!--  Kiểm tra phòng trống (tìm kiếm phòng)-->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form action="filerrooms.php" method="post">
                    <div class="row align-items-end">
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-in</label>
                            <input type="date" class="form-control shadow-none" name = "checkinroom" required>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-out</label>
                            <input type="date" class="form-control shadow-none" name = "checkoutroom" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Number of Guests</label>
                            <input type="text" class="form-control shadow-none" name = "numberpeople" required>
                        </div>
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white custom-bg" name="searchrooms">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Phòng của resort - review qua -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">OUR ROOM</h2>
    <div class="container">
        <div class="row">
            <?php
            $i = 0;
            $max_rooms = 3; // maximum number of rooms to display
            $sql_phong = "SELECT * FROM phong";
            $query_phong = mysqli_query($conn, $sql_phong);
            
            if (mysqli_num_rows($query_phong) > 0) {
                while ($row_phong = mysqli_fetch_assoc($query_phong)) {
                    if ($i >= $max_rooms) {
                        break;
                    }
            
                    if ($row_phong['hangPhong'] == 0) {
                        $row_phong['hangPhong'] = "Thường";
                    } elseif ($row_phong['hangPhong'] == 1) {
                        $row_phong['hangPhong'] = "VIP";
                    } else {
                        $row_phong['hangPhong'] = "Tổng Thống";
                    }
            
                    echo '<div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="./admin/uploads/' . $row_phong['hinhAnh'] . '" class="card-img-top">
            
                            <div class="card-body">
                                <h5 class="card-title">' . $row_phong['tenPhong'] . '</h5>
                                <h6 class="mb-4">' . number_format($row_phong['gia']) . ' VNĐ per night</h6>
                                <div class="features mb-4">
                                    <h6 class="mb-1">Diện Tích</h6>
                                    <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                        ' . $row_phong['dienTich'] . ' m<sup>2</sup>
                                    </span>
                                </div>
                                <div class="service mb-4">
                                    <h6 class="mb-1">Hạng Phòng</h6>
                                    <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                        ' . $row_phong['hangPhong'] . '
                                    </span>
                                </div>
                                
                                <div class="guests mb-4">
                                    <h6 class="mb-1">Số Người</h6>
                                    <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                        ' . $row_phong['songuoi'] . '
                                    </span>
                                </div>
                                <div class="d-flex justify-content-evenly mb-2">
                                    <a href="booking.php?id=' . $row_phong['id'] . '" class="btn btn-sm text-white custom-bg">Book now</a>
                                    <a href="chitietphong.php?id=' . $row_phong['id'] . '" class="btn btn-sm btn-outline-dark">More details</a>
                                </div>
                            </div>
                        </div>
                    </div>';
            
                    $i++;
                }
            } else {
                echo '<div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="./images/phong/room-1.jpg" class="card-img-top">
            
                        <div class="card-body">
                            <h5 class="card-title">VIP Single room with a sea view</h5>
                            <h6 class="mb-4">2.000.000 VND per night</h6>
                            <div class="features mb-4">
                                <h6 class="mb-1">Features</h6>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    1 Bed
                                </span>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    1 Bathroom
                                </span>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    1 Banlcony
                                </span>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    3 Sofa
                                </span>
                            </div>
                            <div class="service mb-4">
                                <h6 class="mb-1">Service</h6>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    Wifi
                                </span>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    Buffet breakfast
                                </span>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    Gym
                                </span>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    Spa
                                </span>
                            </div>
                            <div class="guests mb-4">
                                <h6 class="mb-1">Guests</h6>
                                <span class="mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    2 Adults
                                </span>
                                <span class=" mb-1 badge rounded-pill bg-info text-dark text-wrap lh-base">
                                    0 childrens
                                </span>
                            </div>
                            <div class="d-flex justify-content-evenly mb-2">
                                <a href="rooms.php" class="btn btn-sm text-white custom-bg">Book now</a>
                                <a href="rooms.php" class="btn btn-sm btn-outline-dark">More details</a>
                            </div>
                        </div>
            
                    </div>
                </div>';
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold">More Rooms >>></a>
            </div>
        </div>
    </div>

    <!-- Dịch vụ của rì sọt -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">OUR SERVICE</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./images/dich-vu/dinner.png" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title text-center">Dinner on the beach at sunset</h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./images/dich-vu/gym.png" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title text-center">VIP Gym and Spa</h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./images/dich-vu/breakfast.png" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title text-center">Buffet breakfast</h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 text-center mt-5">
                <a href="services.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold">More Service >>></a>
            </div>
        </div>
    </div>
    <!-- Map nè má -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">REACH US</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d249525.14317069115!2d109.08168324550108!3d12.259756501901176!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3170677811cc886f%3A0x5c4bbc0aa81edcb9!2zTmhhIFRyYW5nLCBLaMOhbmggSMOyYSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1711208525443!5m2!1svi!2s" width="600" height="320" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">

                    <h5><i class="bi bi-telephone-plus-fill"></i> Call us</h5>
                    <a href="tel: +84 937822102" class="d-inline-block mb-2 text-decoration-none text-dark">
                        +84 937822102
                    </a>
                </div>
                <div class="bg-white p-4 rounded mb-4">

                    <h5><i class="bi bi-envelope-at-fill"></i> Email</h5>
                    <a href="email: azureresort@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark">
                        azureresort@gmail.com
                    </a>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5><i class="bi bi-facebook"></i> Facebook</h5>
                    <a href="fb: Azure Resort" class="d-inline-block mb-2 text-decoration-none text-dark">
                        Azure Resort
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php
    require('inc/footer.php');
    ?>
    <!-- Link JS -->
    <script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>
    <script>
    window.botpressWebChat.init({
        "composerPlaceholder": "Chat với Azure",
        "botConversationDescription": "By Azure Resort ",
        "botId": "326647f2-a16f-41d2-becb-8edf7c6fdbcd",
        "hostUrl": "https://cdn.botpress.cloud/webchat/v1",
        "messagingUrl": "https://messaging.botpress.cloud",
        "clientId": "326647f2-a16f-41d2-becb-8edf7c6fdbcd",
        "webhookId": "1e23bdf7-da4b-4327-af89-7c3804440b25",
        "lazySocket": true,
        "themeName": "prism",
        "botName": "Azure Bot",
        "stylesheet": "https://webchat-styler-css.botpress.app/prod/b93a3edb-4d8f-48a0-a4fa-d1098729ad48/v27397/style.css",
        "frontendVersion": "v1",
        "useSessionStorage": true,
        "enableConversationDeletion": true,
        "showPoweredBy": true,
        "theme": "prism",
        "themeColor": "#2563eb",
        "allowedOrigins": []
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <!-- <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            effect: "fade",
            navigation: {
                nextEl: ".swipper-button-next",
                prevEl: ".swipper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });
    </script> -->
    <!-- Chatra {literal} -->
    <!-- <script>
        (function(d, w, c) {
            w.ChatraID = 'CBQ3fukS8PFGnSbiW';
            var s = d.createElement('script');
            w[c] = w[c] || function() {
                (w[c].q = w[c].q || []).push(arguments);
            };
            s.async = true;
            s.src = 'https://call.chatra.io/chatra.js';
            if (d.head) d.head.appendChild(s);
        })(document, window, 'Chatra');
    </script> -->
    <!-- /Chatra {/literal} -->
</body>

</html>