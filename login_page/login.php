<?php
require_once "login.html";

session_start();

$JFPath = "../data/users.json";
$jsonData = json_decode(file_get_contents($JFPath), true);
$user_name_email;
$password;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extractDataFromInputs();
    if ($user_name_email == 'admin' and $password == 'admin') {
        loginAsAdmin();
    }
    if (isInputsValid()) {
        foreach ($jsonData['users'] as $user) {
            if (($user_name_email == $user['email'] or $user_name_email == $user['userName']) and $password == $user['password']) {
                SuccesfulLogin($user);
                break;
            } elseif ($user_name_email == $user['email'] or $user_name_email == $user['userName'] and $password != $user['password']) {
                echo 'incorect Password';
                break;
            } else {
                echo 'no user found';
                break;
            }
        }
    } else {
    }
}




// extracting data from the form
function extractDataFromInputs()
{
    extractUserNameEmail();
    extractPassword();
}

function extractUserNameEmail()
{
    global $user_name_email;
    $user_name_email = $_POST['userName_email'];
}

function extractPassword()
{
    global $password;
    $password = $_POST['password'];
}

// validate inputes

function isInputsValid()
{
    return isUserNameInputValid() and isPasswordInputValid();
}

function isUserNameInputValid()
{
    global $user_name_email;
    return (str_contains($user_name_email, '@') || str_contains($user_name_email, '_')) && strlen($user_name_email) >= 4;
}

function isPasswordInputValid()
{
    global $password;
    return strlen($password) >= 6;
}

// checking wether is login with user name or email
function isEmail()
{
    global $user_name_email;
    return str_contains($user_name_email, '@');
}
function SuccesfulLogin($user)
{
    global $JFPath, $jsonData;
    $user["lastSastion"] = date('l jS \of F Y h:i:s A');
    $jsonData['users'][$user['userID'] - 1] = $user;
    $fp = fopen($JFPath, 'w');
    fwrite($fp, json_encode($jsonData, JSON_PRETTY_PRINT));
    fclose($fp);
    $_SESSION['as_admin']= 'false';
    $_SESSION['userID']= $user['userID'];
    header('Location: ../home_page/home.php');
    exit;
}

function loginAsAdmin(){
    $_SESSION['as_admin']= 'true';
    header('Location: ../home_page/home.php');
}