<!DOCTYPE=html>
<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./95_project_final_unionstyle.css">

</head>

<body>
  <div class="sidenav">
    <a href="./95_project_final_landingpage.html">Home</a>
    <a href="./95_project_final_clan_hunter.php">Clan</a>
    <a href="./95_project_final_member_hunter.php">Member</a>
    <a href="./95_project_final_Hunter_Equipment.php">Equipment</a>
    <a href="./95_project_final_hunterteam_by_Tim.php">Team</a>
    <a href="./95_project_final_mission_hunter.php">Mission</a>
    <a href="./95_project_final_Hunter_Monster.php">Monster</a>
  </div>

<div class="main">

<h1> Monster -- Hunters </h1>




<p> Select living or dead monsters </p>

<form method="POST" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>


<p><input type="submit" value="select alive monsters" name="select_alive"></p>
</form>

<form method="POST" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>


 <p><input type="submit" value="select dead monsters" name="select_dead"></p>
</form>






<?php
require(dirname(__FILE__).'/95_project_final_connect2.php');

// $host    = "127.0.0.1";
// $user    = "root";
// $pass    = "xu25672788";
// $db_name = "test";
$success = true;

//create connection
$connection = mysqli_connect($host, $user, $pass, $db_name);



function SQL_execute($statement){
        global $connection;
        global $success;
        //get results from database
        $result = mysqli_query($connection, $statement);
        if ($result){
            $success = true;
       }else{
           $success = false;
           echo "<br>Error Record:<br>".mysqli_error($connection);
       }

        return $result;

    }

function printResult($result) {

    $all_property = array();  //declare an array for saving property

    //showing property
    echo '<table class="data-table">
            <tr class="data-heading">';  //initialize table tag
    while ($property = mysqli_fetch_field($result)) {
        echo '<th>' . $property->name . '</th>';  //get field name for header
        array_push($all_property, $property->name);  //save those to array
    }
    echo '</tr>'; //end tr tag

    //showing all data
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        foreach ($all_property as $item) {
            echo '<td>' . $row[$item] . '</td>'; //get items using property value
        }
        echo '</tr>';
    }
    echo "</table>";
}


#region
if($connection){

    if (array_key_exists('select_alive', $_POST)){
        echo "<br> select alive monsters";

        $result = SQL_execute("SELECT ID, Name, Location, MonsterLevel FROM monster WHERE ALIVE = 1;");
        if ($_POST && $success)

        printResult($result);
    }
    else if (array_key_exists('select_dead', $_POST)){
        echo "<br> select dead monsters";

        $result = SQL_execute("SELECT ID, Name, Location, MonsterLevel FROM monster WHERE ALIVE = 0;");

        if ($_POST && $success)

        printResult($result);
    }
    }
else {
    echo "cannot connect";
    //test if connection failed
   if(mysqli_connect_errno()){
    die("connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")");
}

}
#endregin


mysqli_close($connection);
?>
