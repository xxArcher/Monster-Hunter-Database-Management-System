<!DOCTYPE HTML>
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
<h1>Hunters' page for teams</h1>
<p> Join missions OR hunters </p>
<!-- Create the form for joining team with either missions or hunters -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Team ID: <input type="text" name="teamid">
  <br><br>
  Join with:
  <input type="radio" name="morh" value="mission">mission
  <input type="radio" name="morh" value="hunter">hunter
  <input type="radio" name="morh" value="none">none
  <br><br>
  <input type="submit" name="submit1" value="See JOIN">
</form>

<p> See # of team members in the inc/dec order </p>

<!-- Create the form to see # of team members in the inc/dec order -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  INC/DEC:
  <input type="radio" name="incdec" value="ASC">INC
  <input type="radio" name="incdec" value="DESC">DEC
  <br><br>
  <input type="submit" name="submit2" value="See #">
</form>

<p> Insert a new team, delete a team, and check modifications </p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
TeamID:
    <input type="text" name="teamidd" />
    <br><br>
  <input type="submit" name="submit3" value="Insert Team">
  <br><br>

    <input type="submit" name="submit4" value="Delete Team" />
    <br><br>
    <input type="submit" name="submit5" value="Check Changes" />
</form>

<?php
require(dirname(__FILE__).'/95_project_final_connect2.php');

// $host    = "127.0.0.1";
// $user    = "root";
// $pass    = "xu25672788";
// $db_name = "test";
$error = "Error Record:";
$result;

//create connection
$connection = mysqli_connect($host, $user, $pass, $db_name);

//test if connection failed
if(mysqli_connect_errno()){
    $error = "connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")";
}


//if there is input on both moth and teamid
if ($_POST["submit1"]){
    if ($_POST["morh"]){
        if ($_POST["teamid"]){
            if ($_POST["morh"] == "mission"){
                $result = mysqli_query($connection,"SELECT TeamID, teamScore AS TeamScore, MissionID, RewardPoint, Completion, TimeLimit, MinimumScore as MinimumScoreToClaim, MonsterID, ElderID FROM team JOIN claims ON team.ID = claims.TeamID JOIN mission ON claims.MissionID = mission.ID WHERE team.ID = " . $_POST["teamid"] . ";");
            }elseif ($_POST["morh"] == "hunter"){
                $result = mysqli_query($connection,"SELECT TeamID, HunterID, teamScore AS TeamScore,    NAME AS HunterName, ClanName FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID WHERE team.ID = " . $_POST["teamid"] . ";");
            }elseif ($_POST["morh"] == "none"){
                $result = mysqli_query($connection,"SELECT ID AS TeamID, teamScore AS TeamScore FROM team WHERE team.ID = " . $_POST["teamid"] . ";");
            }
        }
        if (!$_POST["teamid"]){
            if ($_POST["morh"] == "mission"){
                $result = mysqli_query($connection,"SELECT TeamID, teamScore AS TeamScore, MissionID, RewardPoint, Completion, TimeLimit, MinimumScore as MinimumScoreToClaim, MonsterID, ElderID FROM team JOIN claims ON team.ID = claims.TeamID JOIN mission ON claims.MissionID = mission.ID;");
            }elseif ($_POST["morh"] == "hunter"){
                $result = mysqli_query($connection,"SELECT TeamID, HunterID, teamScore AS TeamScore,    NAME AS HunterName, ClanName FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID;");
            }elseif ($_POST["morh"] == "none"){
                $result = mysqli_query($connection,"SELECT ID AS TeamID, teamScore AS TeamScore FROM team;");
            }
        }
    }
}

if ($_POST["submit2"]){
    if ($_POST["incdec"]){
        if ($_POST["incdec"] == "ASC"){
            $result = mysqli_query($connection,"SELECT TeamID, COUNT(HunterID) AS Number_Of_Members FROM consistsof GROUP BY TeamID ORDER BY Number_Of_Members " . $_POST["incdec"] . ";");
        }
        if ($_POST["incdec"] == "DESC"){
            $result = mysqli_query($connection,"SELECT TeamID, COUNT(HunterID) AS Number_Of_Members FROM consistsof GROUP BY TeamID ORDER BY Number_Of_Members " . $_POST["incdec"] . ";");
        }
    }
}

if ($_POST["submit3"]){
    mysqli_query($connection,"insert into team values(" . $_POST["teamidd"] . ", 0);");
}

if ($_POST["submit4"]){
    if ($_POST["teamidd"]){

        mysqli_query($connection,"DELETE FROM team WHERE ID = " . $_POST["teamidd"] . ";");

    }
}

if ($_POST["submit5"]){
    if ($_POST["teamidd"]){
        // echo "SELECT * FROM team WHERE ID = " . $_POST["teamidu"] . "AND teamScore = " . $_POST["scoreu"] . ";";
        $result = mysqli_query($connection,"SELECT * FROM team WHERE ID = " . $_POST["teamidd"] . ";");

    }
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
}

// if ($_POST["query"]){
// //get results from database
// $result = mysqli_query($connection,$_POST["query"]);
// $all_property = array();  //declare an array for saving property

// //showing property
// echo '<table class="data-table">
//         <tr class="data-heading">';  //initialize table tag
// while ($property = mysqli_fetch_field($result)) {
//     echo '<td>' . $property->name . '</td>';  //get field name for header
//     array_push($all_property, $property->name);  //save those to array
// }
// echo '</tr>'; //end tr tag

// //showing all data
// while ($row = mysqli_fetch_array($result)) {
//     echo "<tr>";
//     foreach ($all_property as $item) {
//         echo '<td>' . $row[$item] . '</td>'; //get items using property value
//     }
//     echo '</tr>';
// }
// echo "</table>";
// }

?>

<p><?php echo $error; ?></p>

</div>
</body>
</html>
