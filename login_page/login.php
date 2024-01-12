<?php
require_once "login.html";


$JFPath = "../data/users.json";
$jsonData = json_decode(file_get_contents($JFPath), true);
$user_name_email;
$password;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extractDataFromInputs();
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
$user["lastSastion"]= "hello";
$jsonData[$user['userID']-1] = $user;
    $fp = fopen($JFPath, 'w');
    fwrite($fp, json_encode($jsonData));
    fclose($fp);
    // header('');
    // exit;
}
