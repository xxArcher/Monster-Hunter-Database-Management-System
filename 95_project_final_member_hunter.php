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

<h1> Member -- Hunters</h1>

<p>
Please select which group of members you want to see:
</p>
<form method="post">
  <input type="radio" name="seeAllHunter" value="Hunter"> Hunter<br>
  <input type="radio" name="seeAllElders" value="Elder"> Elder<br>
  <input type="submit" value="See all hunters/elders" />
</form>

<br/>

<p>Search a hunter's information with his ID:
</p>
<form method="post">
Hunter ID:<input type="text" name="Hunter_By_ID" /> <br/>
<input type="submit" value="Submit" name="submit_hunterID">
</form>

<br/>

<p>Search an elder's information with his ID:
</p>
<form method="post">
Hunter ID:<input type="text" name="Elder_By_ID" /> <br/>
<input type="submit" value="Submit" name="submit_elderID">
</form>

<br/>

<p>Search all the hunters' information in a clan:
</p>
<form method="post">
Clan name keyword:<input type="text" name="Hunter_By_Clan" /> <br/>
<input type="submit" value="Submit" name="submit_hunterClan">
</form>

<br/>

<p>Search all the elders' information in a clan:
</p>
<form method="post">
Clan name keyword:<input type="text" name="Elder_By_Clan" /> <br/>
<input type="submit" value="Submit" name="submit_elderClan">
</form>

<?php
require(dirname(__FILE__).'/95_project_final_db_connection.php');
$error = "<br><br><br><br><br>Error Record:";

if($_POST["seeAllHunter"]){
  $query = "SELECT * FROM hunter;";
  $result = mysqli_query($connection,$query);
}

if($_POST["seeAllElders"]){
  $query = "SELECT * FROM elder;";
  $result = mysqli_query($connection,$query);
}

if($_POST["submit_hunterID"]){
  $HunterID=$_POST['Hunter_By_ID'];
  $query = "SELECT * FROM hunter WHERE ID = $HunterID ;";
  $result = mysqli_query($connection,$query);
}

if($_POST["submit_elderID"]){
  $ElderID=$_POST['Elder_By_ID'];
  $query = "SELECT * FROM elder WHERE ID = $ElderID ;";
  $result = mysqli_query($connection,$query);
}

if($_POST["submit_hunterClan"]){
  $HunterClan=$_POST['Hunter_By_Clan'];
  $query = "SELECT * FROM hunter WHERE clanName LIKE '%$HunterClan%' ;";
  $result = mysqli_query($connection,$query);
}

if($_POST["submit_elderClan"]){
  $ElderClan=$_POST['Elder_By_Clan'];
  $query = "SELECT * FROM elder WHERE clanName LIKE '%$ElderClan%' ;";
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
