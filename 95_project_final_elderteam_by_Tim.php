<!DOCTYPE HTML>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./95_project_final_unionstyle.css">

</head>


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
<h1>Team -- Elders </h1>

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

<p> See the highest score from all teams </p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <input type="submit" name="submit3" value="See MAX_SCORE">
</form>

<p> Update team score and check modifications </p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    TeamID:
    <input type="text" name="teamidu" />
    <br><br>
    Score:
    <input type="text" name="scoreu" />
    <br><br>
    <input type="submit" name="submit4" value="Update Score" />
    <br><br>
    <input type="submit" name="submit5" value="Check Changes" />
</form>

<p> Find team(s) with the largest/minimum average age </p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <input type="radio" name="maxmin" value="MAX">MAX
    <input type="radio" name="maxmin" value="MIN">MIN
    <br><br>
    <input type="submit" name="submit6" value="Which group?" />
</form>

<p> Add a hunter to a team / Help a team to claim a mission, and check changes <br>If trying to add a hunter to a non-exsiting team, a trigger will work and create the team automatically </p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    TeamID:
    <input type="text" name="addhuntertoteam" />
    <br><br>
    HunterID / MissionID:
    <input type="text" name="addhunterid" />
    <br><br>
    <input type="submit" name="submit7" value="Add Hunter" />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit10" value="Claim Mission" />
    <br><br>
    <input type="submit" name="submit8" value="Delete Hunter From Team" />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit11" value="Cancel Claim" />
    <br><br>
    <input type="submit" name="submit9" value="Check Changes of team & Hunter" />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit12" value="Check Changes of team & mission" />
</form>


<?php
require(dirname(__FILE__).'/95_project_final_connect2.php');

// $host    = "127.0.0.1";
// $user    = "root";
// $pass    = "xu25672788";
// $db_name = "test";$error = "Error Record:";
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
    $result = mysqli_query($connection,"SELECT MAX(TeamScore) FROM team");
}

if ($_POST["submit4"]){
    if ($_POST["teamidu"]){
    //     if ($_POST["scoreu"]){
            // We do not want to update a team score to be less than 0!
            if($_POST["scoreu"] < 0){
                echo "The entered score is out of range (0)!";
            } else {
                // echo "Update team Set teamScore = " . $_POST["scoreu"] . " WHERE ID = " . $_POST["teamidu"] . ";";
            mysqli_query($connection,"Update team Set teamScore = " . $_POST["scoreu"] . " WHERE ID = " . $_POST["teamidu"] . ";");
            }
    //     }
    }
}

if ($_POST["submit5"]){
    if ($_POST["teamidu"]){
        // if ($_POST["scoreu"]){
            // echo "SELECT * FROM team WHERE ID = " . $_POST["teamidu"] . "AND teamScore = " . $_POST["scoreu"] . ";";
            $result = mysqli_query($connection,"SELECT * FROM team WHERE ID = " . $_POST["teamidu"] . " AND teamScore = " . $_POST["scoreu"] . ";");
        // }
    }
}

if($_POST["maxmin"] == "MAX"){
    if ($_POST["submit6"]){
    
    $tempresult = mysqli_query($connection,"SELECT MAX(AvgAge) FROM (SELECT TeamID, AVG(Age) AS AvgAge FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID GROUP BY team.ID) AS myalias;");
    $remembermax = 0;
    if (mysqli_num_rows($tempresult) > 0) {
        while($row = mysqli_fetch_assoc($tempresult)) {
            echo "The maximum average age is " . $row["MAX(AvgAge)"] . "<br>";
            $remembermax = $row["MAX(AvgAge)"];
        }
        $tempresult2 =  mysqli_query($connection,"SELECT TeamID, AVG(Age) AS AvgAge FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID GROUP BY team.ID");
        $tempteamid = "";
        // echo $remembermax;
        if (mysqli_num_rows($tempresult2) > 0) {
            while($row = mysqli_fetch_assoc($tempresult2)) {
                if ($row["AvgAge"] == $remembermax) {
                    $tempteamid .= $row["TeamID"] . " ";
                }
            }
            echo "The ID(s) of team(s) with the maximum average is/are " . $tempteamid;
        }
    }
}
}


if($_POST["maxmin"] == "MIN"){
    if ($_POST["submit6"]){
    $tempresult = mysqli_query($connection,"SELECT MIN(AvgAge) FROM (SELECT TeamID, AVG(Age) AS AvgAge FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID GROUP BY team.ID) AS myalias;");
    $remembermax = 0;
    if (mysqli_num_rows($tempresult) > 0) {
        while($row = mysqli_fetch_assoc($tempresult)) {
            echo "The minimum average age is " . $row["MIN(AvgAge)"] . "<br>";
            $remembermax = $row["MIN(AvgAge)"];
        }
        $tempresult2 =  mysqli_query($connection,"SELECT TeamID, AVG(Age) AS AvgAge FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID GROUP BY team.ID");
        $tempteamid = "";
        // echo $remembermax;
        if (mysqli_num_rows($tempresult2) > 0) {
            while($row = mysqli_fetch_assoc($tempresult2)) {
                if ($row["AvgAge"] == $remembermax) {
                    $tempteamid .= $row["TeamID"] . " ";
                }
            }
            echo "The ID(s) of team(s) with the minimum average is/are " . $tempteamid;
        }
    }
}
}

if ($_POST["submit7"]){
    mysqli_query($connection,"insert into consistsof values(" . $_POST["addhuntertoteam"] . ", " . $_POST["addhunterid"] . ");");
}

if ($_POST["submit8"]){

    mysqli_query($connection,"DELETE FROM consistsof WHERE TeamID = " . $_POST["addhuntertoteam"] . " AND HunterID = " . $_POST["addhunterid"] . ";");
}

if ($_POST["submit9"]){
    $result = mysqli_query($connection,"SELECT TeamID, HunterID, teamScore AS TeamScore,    NAME AS HunterName, ClanName FROM team JOIN consistsof ON team.ID = consistsof.TeamID JOIN hunter ON consistsof.HunterID = hunter.ID WHERE TeamID = " . $_POST["addhuntertoteam"] . " AND HunterID = " . $_POST["addhunterid"] . ";");
}

if ($_POST["submit10"]){
    mysqli_query($connection,"insert into claims values(" . $_POST["addhuntertoteam"] . ", " . $_POST["addhunterid"] . ");");
}

if ($_POST["submit11"]){

    mysqli_query($connection,"DELETE FROM claims WHERE TeamID = " . $_POST["addhuntertoteam"] . " AND MissionID = " . $_POST["addhunterid"] . ";");
}

if ($_POST["submit12"]){
    $result = mysqli_query($connection,"SELECT TeamID, teamScore AS TeamScore, MissionID, RewardPoint, Completion, TimeLimit, MinimumScore as MinimumScoreToClaim, MonsterID, ElderID FROM team JOIN claims ON team.ID = claims.TeamID JOIN mission ON claims.MissionID = mission.ID WHERE team.ID = " . $_POST["addhuntertoteam"] . " AND MissionID = " . $_POST["addhunterid"] . ";");
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
