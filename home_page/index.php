<?php
session_start();
require_once "home.html";


$jsonData = json_decode(file_get_contents("../data/users.json"), true);


if (isset($_SESSION["as_admin"]) and $_SESSION["as_admin"] == "true") {
    createUsersTable();
    displayUsersForAdmin();
} else {
    $user = $jsonData['users'][$_SESSION['userID'] - 1];
    displayUserData((string)$user['name'], (string)$user['lastName'], (string)$user['birthDay'], (string)$user['userName'], (string)$user['name'], (string)$user['password']);
}


if (isset($_POST['log_out'])) {
  session_destroy();
  header('Location: ../');;
  exit;
}


function createUsersTable()
{
    echo'<script>document.body.innerHtml ="";
    document.querySelector("form").innerHTML = "";</script>';
    echo '
    <h1>Users</h1>
    <table>
    <thead>
      <tr>
        <td>User Name</td>
        <td>Name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>Birth Date</td>
        <td>Passwrod</td>
        <td>Last Login</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
      </tr>
    </tbody>
  </table>';
}

function displayUsersForAdmin()
{
    global $jsonData;
    foreach ($jsonData['users'] as $user) {
        echo "
        <script>
            document.querySelector(' table tbody').innerHTML+=`<tr><td>".$user['userName']."</td><td>".$user['name']."</td>
            <td>".$user['lastName']."</td>
            <td>".$user['email']."</td>
            <td>".$user['birthDay']."</td>
            <td>".$user['password']."</td>
            <td>".$user['lastSastion']."</td>
            </tr>`;
        </script>";
    }
}

function displayUserData($name, $last_name, $birth_date, $email, $user_name, $password)
{
    echo "
    <div class='user-card'>
    <h1 class='name-and-lastName'>$last_name $name</h1>
    <p class='user-name'>$user_name</p>
    <p class='email'>$email</p>
    <p class='birth-date'>$birth_date</p>
    <p class='password'>$password</p>
    </div>";
}
