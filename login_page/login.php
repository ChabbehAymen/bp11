<?php
require_once "login.html";


$jsonData = json_decode(file_get_contents("data/users.json"), true);
$user_name_email;
$password;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo"stage1";
    extractDataFromInputs();
    echo"stage2";
    if (isInputsValid()) {
    echo"stage3";
    foreach ($jsonData['users'] as $user) {
            print_r($user);
            // if (isEmail()) {
                
            // }
        }
    }
}




// extracting data from the form
function extractDataFromInputs(){
    extractUserNameEmail();
    extractPassword();
}

function extractUserNameEmail(){
    global $user_name_email;
    $user_name_email = $_POST['userName_email'];
}

function extractPassword(){
    global $password;
    $password = $_POST['password'];
}

// validate inputes

function isInputsValid(){
    return isUserNameInputValid() and isPasswordInputValid();
}

function isUserNameInputValid(){
    global $user_name_email;
    return (str_contains($user_name_email,'@') || str_contains($user_name_email,'_')) && strlen($user_name_email) >= 4;
}

function isPasswordInputValid(){
    global $user_password;
    return strlen($user_password) >= 6;
}

// checking wether is login with user name or email
function isEmail(){
    global $user_name_email;
    return str_contains($user_name_email,'@');
}
