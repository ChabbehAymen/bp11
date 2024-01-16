<?php
session_start();
require_once "home.html";
require_once "../User.php";


$jsonData = json_decode(file_get_contents("../data/users.json"), true);


if (isset($_SESSION["as_admin"]) and $_SESSION["as_admin"] == "true") {
  createUsersTable();
  displayUsersForAdmin();
} else {
  foreach ($jsonData['users'] as $user) {
    if ($user['userID'] == $_SESSION['userID']) {
      $mUser = createUserObject($user);
      displayUserData($mUser);
    }
  }
}



if (isset($_POST['log_out'])) {
  session_destroy();
  header('Location: ../');;
  exit;
}

if (isset($_POST['change_data'])) {
}


function createUsersTable()
{
  echo '<script>document.body.innerHtml ="";
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

function createUserObject($user)
{
  $mUser = new User();
  $mUser->setName($user['name']);
  $mUser->setLastName($user['lastName']);
  $mUser->setUserName($user['userName']);
  $mUser->setBirthDay($user['birthDay']);
  $mUser->setEmail($user['email']);
  $mUser->setPassword($user['password']);
  return $mUser;
}

function displayUsersForAdmin()
{
  global $jsonData;
  foreach ($jsonData['users'] as $user) {
    echo "
        <script>
            document.querySelector(' table tbody').innerHTML+=`<tr><td>" . $user['userName'] . "</td><td>" . $user['name'] . "</td>
            <td>" . $user['lastName'] . "</td>
            <td>" . $user['email'] . "</td>
            <td>" . $user['birthDay'] . "</td>
            <td>" . $user['password'] . "</td>
            <td>" . $user['lastSastion'] . "</td>
            </tr>`;
        </script>";
  }
}

function displayUserData(object $user)
{
  echo "
    <div class='user-card'>
    <div><input type='text' value='".$user->getLastName()."'><input type='text' value='".$user->getName()."'></div>
    <p class='user-name'>".$user->getUserName()."</p>
    <p class='email'>".$user->getEmail()."</p>
    <input type='date' value='".$user->getBirthDay()."'>
    <input type='text' value='".$user->getPassword()."'>
    </div>";
}
