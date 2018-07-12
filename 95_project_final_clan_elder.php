<!DOCTYPE=html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./95_project_final_unionstyle.css">

<body>
  <div class="sidenav">
    <a href="./95_project_final_landingpage.html">Home</a>
    <a href="./95_project_final_clan_elder.php">Clan</a>
    <a href="./95_project_final_member_elder.php">Member</a>
    <a href="./95_project_final_Elder_Equipment.php">Equipment</a>
    <a href="./95_project_final_elderteam_by_Tim.php">Team</a>
    <a href="./95_project_final_mission_elder.php">Mission</a>
    <a href="./95_project_final_Elder_Monster.php">Monster</a>
  </div>

<div class="main">

<h1> Clan -- Elders  </h1>

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

<br/>

<p> Find clan(s) with the largest/minimum Maximum age </p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <input type="radio" name="maxmin" value="MAX">MAX
    <input type="radio" name="maxmin" value="MIN">MIN
    <br><br>
    <input type="submit" name="submit6" value="Which group?" />
</form>


<?php
require(dirname(__FILE__).'/95_project_final_db_connection.php');
$error = "<br><br><br><br><br>Error Record:";

if($_POST["maxmin"] == "MAX"){
    if ($_POST["submit6"]){
    
    $tempresult = mysqli_query($connection,"SELECT MAX(MaxAge) FROM (SELECT ClanName, MAX(Age) AS MaxAge FROM clan JOIN hunter ON hunter.ClanName = clan.Name GROUP BY clan.Name) AS myalias;");
    $remembermax = 0;
    if (mysqli_num_rows($tempresult) > 0) {
        while($row = mysqli_fetch_assoc($tempresult)) {
            echo "The largest maximum age is " . $row["MAX(MaxAge)"] . "<br>";
            $remembermax = $row["MAX(MaxAge)"];
        }
        $tempresult2 =  mysqli_query($connection,"SELECT ClanName, MAX(Age) AS MaxAge FROM clan JOIN hunter ON hunter.ClanName = clan.Name GROUP BY clan.Name;");
        $tempteamid = "";
        // echo $remembermax;
        if (mysqli_num_rows($tempresult2) > 0) {
            while($row = mysqli_fetch_assoc($tempresult2)) {
                if ($row["MaxAge"] == $remembermax) {
                    $tempteamid .= $row["ClanName"] . " ";
                }
            }
            echo "The name(s) of clan(s) with the largest maximum age is/are " . $tempteamid;
        }
    }
}
}

if($_POST["maxmin"] == "MIN"){
    if ($_POST["submit6"]){
    $tempresult = mysqli_query($connection,"SELECT MIN(MaxAge) FROM (SELECT ClanName, MAX(Age) AS MaxAge FROM clan JOIN hunter ON hunter.ClanName = clan.Name GROUP BY clan.Name) AS myalias;");
    $remembermax = 0;
    if (mysqli_num_rows($tempresult) > 0) {
        while($row = mysqli_fetch_assoc($tempresult)) {
            echo "The smallest minimum age is " . $row["MIN(MaxAge)"] . "<br>";
            $remembermax = $row["MIN(MaxAge)"];
        }
        $tempresult2 =  mysqli_query($connection,"SELECT ClanName, MAX(Age) AS MaxAge FROM clan JOIN hunter ON hunter.ClanName = clan.Name GROUP BY clan.Name;");
        $tempteamid = "";
        // echo $remembermax;
        if (mysqli_num_rows($tempresult2) > 0) {
            while($row = mysqli_fetch_assoc($tempresult2)) {
                if ($row["MaxAge"] == $remembermax) {
                    $tempteamid .= $row["ClanName"] . " ";
                }
            }
            echo "The name(s) of clan(s) with the smallest maximum age is/are " . $tempteamid;
        }
    }
}
}

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
    $error = "<br><br><br><br>Error Record:<br>" . mysqli_error($connection);
} elseif ($result == false){
$error = "<br><br><br><br>Error Record:<br>" . mysqli_error($connection);
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
