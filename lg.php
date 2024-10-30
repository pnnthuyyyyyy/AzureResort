<?php
session_start();
require_once('google/vendor/autoload.php');
require_once('./config/connect.php');

$clientID = '896175657386-ar6etcg05fa99pc3hbu4kje50hj4udou.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost/Resort_Azure/lg.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrl);
$client->addScope("profile");
$client->addScope("email");

if(isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client ->setAccessToken($token);
    
    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth->userinfo->get();

    $email = $google_info->email;
    $name = $google_info->name;

    $sql_check = "SELECT * FROM khachhang WHERE email = '$email' AND is_veryfied = 1 AND status = 1";
    $check = mysqli_query($conn, $sql_check);
    $check_data = mysqli_fetch_assoc($check);

    if(mysqli_num_rows($check) == 0){
        // user not exits
        $dateinsert = date('Y-m-d');
        $tokeninsert = bin2hex(random_bytes(16));
        $sql_insert_google = "INSERT INTO khachhang (ho, ten, sdt, email, diaChi, password, token, date, status, is_veryfied, token_created_at) VALUES ('".$name."', ' ', '0123456789', '".$email."', ' ', '1111', '".$tokeninsert."', current_timestamp(), '1', '1', '".$dateinsert."');";
        $result_insert = mysqli_query($conn, $sql_insert_google);
        if ($result_insert) {
            $_SESSION['user'] = $check_data;
            var_dump($_SESSION['user']);
            header('Location: index.php');
            exit();
        } else {
            echo 'Insert failed!';
        }
    }else{
        // user already exits
        $_SESSION['user'] = $check_data;
        var_dump($_SESSION['user']);
        header('Location: index.php');
        exit();
    }

}else {
    if (!isset($_SESSION['user'])) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login with Google</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                .login-btn {
                    background-color: #DB4437;
                    color: #fff;
                    padding: 12px 30px;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    text-decoration: none;
                    font-size: 18px;
                    font-weight: bold;
                    transition: background-color 0.3s;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .login-btn:hover {
                    background-color: #C13584;
                }
            </style>
        </head>
        <body>
            <a href="<?php echo $client->createAuthUrl(); ?>" class="login-btn">Login with Google</a>
        </body>
        </html>
        <?php
    } else {
        header('Location: index.php');
        exit();
    }
}
?>