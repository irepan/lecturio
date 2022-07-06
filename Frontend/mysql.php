<?php

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Email</th><th>Password</th><th>Level</th><th>Completed</th><th>In Progress</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
  function __construct($it) { 
    parent::__construct($it, self::LEAVES_ONLY); 
  }

  function current() {
    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
  }

  function beginChildren() { 
    echo "<tr>"; 
  } 

  function endChildren() { 
    echo "</tr>" . "\n";
  } 
} 


$hostname	= "mysql";
$db_port = '3306';
$dbname		= getenv("MYSQL_DATABASE");
$username	= getenv("MYSQL_USER");
$password	= getenv("MYSQL_PASSWORD");

try {

	$conn = new PDO( "mysql:host=$hostname;dbname=$dbname", $username, $password );

	// Configure PDO error mode
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	echo "Connected successfully";
}
catch( PDOException $e ) {

	echo "Failed to connect: " . $e->getMessage();
}


$username = 'root';
$password = 'root';

// // Connect to the database, using the predefined database variables in /assets/repository/mysql.php
// $conn = new mysqli($hostname, $username, $password, $dbname);

// If there are errors (if the no# of errors is > 1), print out the error and cancel loading the page via exit();
// if (mysqli_connect_errno()) {
//     printf("Could not connect to MySQL databse: %s\n", mysqli_connect_error());
//     exit();
// }

$queryCreateUsersTable = "CREATE TABLE IF NOT EXISTS `USERS` (
    `ID` int(11) unsigned NOT NULL auto_increment,
    `EMAIL` varchar(255) NOT NULL default '',
    `PASSWORD` varchar(255) NOT NULL default '',
    `PERMISSION_LEVEL` tinyint(1) unsigned NOT NULL default '1',
    `APPLICATION_COMPLETED` boolean NOT NULL default '0',
    `APPLICATION_IN_PROGRESS` boolean NOT NULL default '0',
    PRIMARY KEY  (`ID`)
)";

if(!$conn->query($queryCreateUsersTable)){
    echo "Table creation failed: (" . $conn->errno . ") " . $conn->error;
}

$sth = $conn->prepare('SELECT count(*) as total from `USERS`');
$sth->execute();
$count=$sth->fetchColumn();
if($count==0){
  $conn->beginTransaction();
  // our SQL statements
  $conn->exec("INSERT INTO `USERS` (EMAIL, PASSWORD, PERMISSION_LEVEL, APPLICATION_COMPLETED, APPLICATION_IN_PROGRESS) 
  VALUES ('john@example.com', 'fake-password', 1, 1, 0)");
  $conn->exec("INSERT INTO `USERS` (EMAIL, PASSWORD, PERMISSION_LEVEL, APPLICATION_COMPLETED, APPLICATION_IN_PROGRESS) 
  VALUES ('mary@example.com', 'fake-password', 3, 0, 1)");
  $conn->exec("INSERT INTO `USERS` (EMAIL, PASSWORD, PERMISSION_LEVEL, APPLICATION_COMPLETED, APPLICATION_IN_PROGRESS) 
  VALUES ('julie@example.com', 'fake-password', 2, 0, 0)");

  // commit the transaction
  $conn->commit();
}

  $stmt = $conn->prepare("SELECT ID, EMAIL, PASSWORD, PERMISSION_LEVEL, APPLICATION_COMPLETED, APPLICATION_IN_PROGRESS FROM `USERS`"); 
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
    echo $v;
  }
//print_r($sth->fetchColumn());
// Perform database operations

// Close the connection
$conn = null;
?>