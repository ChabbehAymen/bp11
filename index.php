<?php
session_start();
require_once "signup.html";
require_once "User.php";


$JFPath = "data/users.json";
$jsonData = json_decode(file_get_contents($JFPath), true);
$name;
$last_name;
$user_birth_date;
$user_email;
$user_name;
$password;
$confirm_password;


if (isset($_SESSION['is_loged_account'])) {
    if ($_SESSION['is_loged_account'] !== 'false') {
        $loged_account;
        if($_SESSION['is_loged_account'] === 'admin') navigateToHomePage();
        else{
            foreach($jsonData['users'] as $user){
                if ($user['userName'] === $_SESSION['is_loged_account']) navigateToHomePage();
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = sizeof($jsonData['users']) + 1;
    extractValues();
    if (isUserDataValid()) {
        if (isUserExist()) {
            echo "there is a user with this data";
        }else {
            $user = createUser();
            array_push($jsonData['users'], $user->__toArray($userId));
            $fp = fopen($JFPath, 'w');
            fwrite($fp, json_encode($jsonData));
            fclose($fp);
            header('Location: /login_page/');
            exit;
        }
    } else {
        sendErrorMassege('Unvalid User Data');
    }
}

// extracting data from inputs
function extractValues()
{
    getNameFromInput();
    getLastNameFromInput();
    getBirthDateFromInput();
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

function getBirthDateFromInput()
{
    global $birth_date;
    $birth_date = $_POST['birth_date'];
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
    return isNameValid() and isLastNameValid() and isBirthDateValid() and isEmailValid() and isPasswordValid() and isSamePassword();
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

function isBirthDateValid()
{
    global $birth_date;
    return $birth_date !== "";
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

// checks if user exist
function isUserExist()
{
    global $jsonData, $email, $user_name;
    foreach ($jsonData['users'] as $user) {
        if ($user['email'] === $email || $user['userName'] === $user_name) {
            return true;
        }
    }
    return false;
}

// create a user and sets its data
function createUser()
{
    global $name, $last_name, $birth_date, $email, $user_name, $password;
    $user = new User();
    $user->setName($name);
    $user->setLastName($last_name);
    $user->setBirthDay($birth_date);
    $user->setEmail($email);
    $user->setUserName($user_name);
    $user->setPassword($password);
    return $user;
}

function sendErrorMassege($massege){
    echo"<script>document.querySelector('input[name='error-controler']').value = $massege;</script>";
}

function navigateToHomePage(){
    header('Location: /home_page/');
    exit;
}
