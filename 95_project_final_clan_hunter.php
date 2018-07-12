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

<h1> Clan -- Hunters</h1>

<p>
See all the clans:
</p>
<form method="post">
  <input type="submit" name="seeAllClans" value="Display">
</form>

<br/>

<p>Search a clan using clan name:
</p>
<form method="post">
Clan name keyword:<input type="text" name="Clan_By_Name" /> <br/>
<input type="submit" value="Submit" name="submit_ClanName">
</form>


<?php
require(dirname(__FILE__).'/95_project_final_db_connection.php');
$error = "<br><br><br><br><br>Error Record:";

if($_POST["seeAllClans"]){
  $query = "SELECT * FROM clan;";
  $result = mysqli_query($connection,$query);
}

if($_POST["submit_ClanName"]){
  $ClanName = $_POST['Clan_By_Name'];
  $query = "SELECT * FROM clan WHERE Name LIKE '%$ClanName%'; ";
  $result = mysqli_query($connection,$query);
}

if (is_null($result)){
    $error = "Error Record:<br>" . mysqli_error($connection);
} elseif ($result == false){
$error = "Error Record:<br>" . mysqli_error($connection);
} else{
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
    echo "<br><br></table>";

    // echo $error;
}
echo $error;
?>
</div>
</body>
</html>
