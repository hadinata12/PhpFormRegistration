 <?php
$configs = include('config.php');

$servername = $configs->host;
$username = $configs->username;
$password = $configs->password;
$dbname = $configs->database;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email FROM t_registration where email like "."'%".$_GET['email']."%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo 'false';
  }
} else {
  echo 'true';
}
$conn->close();
?> 