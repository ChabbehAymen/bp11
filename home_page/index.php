<?php
session_start();
require_once "home.html";
require_once "../User.php";


$jsonData = json_decode(file_get_contents("../data/users.json"), true);
$mUser; $user_index;


if (isset($_SESSION["as_admin"]) and $_SESSION["as_admin"] == "true") {
  createUsersTable();
  displayUsersForAdmin();
} else {
  global $mUser, $user_index, $jsonData;
  for ($i=0; $i < count($jsonData['users']); $i++) { 
    if ($jsonData['users'][$i]['userID'] == $_SESSION['userID']) {
      $user_index = $i;
      $mUser = createUserObject($jsonData['users'][$i]);
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
  global $jsonData;
  $newName = $_POST['name'];
  $newUserLastName = $_POST['last_name'];
  $newUserBirthDate = $_POST['birth_date'];
  $newUserPassword = $_POST['password'];
  UpdateUsersData($newName, $newUserLastName, $newUserBirthDate, $newUserPassword);
  updateDataBase();
  saveDataChanges();
  echo "<meta http-equiv='refresh' content='0'>";
}

function UpdateUsersData(string $name, string $last_name, string $birthDate, string $password)
{
  global $mUser;
  $mUser->setName($name);
  $mUser->setLastName($last_name);
  $mUser->setBirthDay($birthDate);
  $mUser->setPassword($password);

}


  // updating user in data base
function updateDataBase(){
  global $mUser, $user_index, $jsonData;
  $jsonData['users'][$user_index]['name'] = $mUser->getName();
  $jsonData['users'][$user_index]['lastName'] = $mUser->getLastName();
  $jsonData['users'][$user_index]['birthDay'] = $mUser->getBirthDay();
  $jsonData['users'][$user_index]['password'] = $mUser->getPassword();
}

function saveDataChanges(){
  global $jsonData;
  $fp = fopen("../data/users.json", 'w');
  fwrite($fp, json_encode($jsonData, JSON_PRETTY_PRINT));
  fclose($fp);
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
    <form action='index.php' method='POST'>
    <div><input type='text' value='" . $user->getLastName() . "' name='last_name'><input type='text' value='" . $user->getName() . "' name='name'></div>
    <p class='user-name'>" . $user->getUserName() . "</p>
    <p class='email'>" . $user->getEmail() . "</p>
    <input type='date' value='" . $user->getBirthDay() . "' name='birth_date'>
    <input type='text' value='" . $user->getPassword() . "' name='password'>
    <input type='submit' value='change_data' name='change_data'>
    <form>
    </div>";
}
