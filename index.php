<?php
require "index.html";
require "User.php";


define("JFPath", "data/users.json");
$name;
$last_name;
$user_email;
$user_name;
$password;
$confirm_password;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jsonData = json_decode(file_get_contents($jfpath), true);
    extractValues();
    if (isUserDataValid()) {
        $user = createUser();
    }


}

// extracting data from inputs
function extractValues()
{
    getNameFromInput();
    getLastNameFromInput();
    getEmailFromInput();
    getUserNameFromInput();
    getPasswordFromInput();
    getPasswordConfirmationFromInput();
}

function getNameFromInput()
{
    global $name;
    $name = $_POST['name'];
}

function getLastNameFromInput()
{
    global $last_name;
    $last_name = $_POST['last_name'];
}

function getEmailFromInput()
{
    global $email;
    $email = $_POST['email'];
}
function getUserNameFromInput()
{
    global $user_name;
    $user_name = $_POST['userName'];
}

function getPasswordFromInput()
{
    global $password;
    $password = $_POST['password'];
}

function getPasswordConfirmationFromInput()
{
    global $confirm_password;
    $confirm_password = $_POST['confirm_password'];
}


// validate user provided data
function isUserDataValid()
{
    return isNameValid() and isLastNameValid() and isEmailValid() and isPasswordValid() and isSamePassword();
}

function isNameValid()
{
    global $name;
    return $name !== "" && !strlen($name) < 3;
}

function isLastNameValid()
{
    global $last_name;
    return $last_name !== "" && !strlen($last_name) < 3;
}

function isEmailValid()
{
    global $email;
    return $email !== '' and !strlen($email) < 5 and strpos($email, "@");
}

function isPasswordValid()
{
    global $password;
    return !$password < 6;
}

function isSamePassword()
{
    global $confirm_password, $password;
    return $confirm_password === $password;
}

// create a user and sets its data
function createUser()
{
    global $name, $last_name, $email, $user_name, $password;
    $user = new User();
    $user->setName($name);
    $user->setLastName($last_name);
    $user->setEmail($email);
    $user->setUserName($user_name);
    $user->setPassword($password);
    return $user;
}
