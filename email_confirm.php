<?php
include("./config/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        /* CSS for the countdown animation */
        @keyframes countdownAnimation {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        /* CSS for the countdown text */
        #countdownDiv {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 24px;
            animation: countdownAnimation 5s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_REQUEST['email_confirmation'])) {
        $email = $_REQUEST['email'];
        $token = $_REQUEST['token'];

        $query = "SELECT * FROM khachhang WHERE email = '$email' AND token = '$token' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_assoc($result);
            if ($fetch['is_veryfied'] == 1) {
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 5000);
                      </script>";
                echo "<div id='countdownDiv'>Account Already Verified! Redirecting...</div>";
            } else {
                $update = "UPDATE khachhang SET is_veryfied = 1 WHERE id = '$fetch[id]'";
                $update1 = mysqli_query($conn, $update);
                if ($update1) {
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'index.php';
                            }, 5000);
                          </script>";
                    echo "<div id='countdownDiv'>Email Verify Successful! Redirecting...</div>";
                } else {
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'index.php';
                            }, 5000);
                          </script>";
                    echo "<div id='countdownDiv'>Email Verify Failed! Server Down. Redirecting...</div>";
                }
            }
        } else {
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 5000);
                  </script>";
            echo "<div id='countdownDiv'>Invalid Link! Redirecting...</div>";
        }
    }
    ?>
    <!-- Chatra {literal} -->
    <script>
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
    </script>
    <!-- /Chatra {/literal} -->
</body>

</html>