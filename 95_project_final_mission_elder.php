<!DOCTYPE=html>
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
<h1> Mission -- Elders </h1>
<form method="post">
    <input type="hidden" name="action" value="view_incomplete"/>
    <input type="submit" value="View incomplete missions" />
</form>
<br />
<form method="post">
    <input type="hidden" name="action" value="view_complete"/>
    <input type="submit" value="View complete missions" />
</form>
<br />
<form method="post">
    <input type="hidden" name="action" value="delete_complete"/>
    <input type="submit" value="Delete complete missions" />
</form>
<br />
<form method="post">
    <input type="hidden" name="action" value="common_missions"/>
    <input type="submit" value="See common missions across all teams" />
</form>
<br />
<form method="post">
    ID: <input type="text" name="mission_id"/><br/>
    RewardPoint: <input type="text" name="points"/> <br/>
    <input type="hidden" name="completed" value="0"/>
    Completion: <input type="checkbox" name="completed" value="1"/> <br/>
    Time Limit: <input type="text" name="time_limit"> <br/>
    Minimum Score: <input type="text" name="min_score"><br/>
    Monster ID: <input type="text" name="mon_id"><br/>
    Elder ID: <input type="text" name="eld_id"><br/>
    <input type="hidden" name="action" value="insert"/>
    <input type="submit" value="Insert new mission" />
</form>
<br />
<form method="post">
    Mission ID: <input type="text" name="mission_id"><br/>
    <input type="hidden" name="action" value="set_complete"/>
    <input type="submit" value="Set this mission complete" />
</form>
<br />

<?php
require(dirname(__FILE__).'/95_project_final_connect2.php');

// $host    = "127.0.0.1";
// $user    = "root";
// $pass    = "xu25672788";
// $db_name = "test";
$query = "";

switch($_POST["action"]) {
    case "view_incomplete":
        $query = "SELECT * from mission where completion = 0";
        break;
    case "view_complete":
        $query = "SELECT * from mission where completion = 1";
        break;
    case "delete_complete":
        $query = "DELETE from mission where completion = 1";
        break;
    case "common_missions":
        $query="select * from mission M WHERE NOT EXISTS (SELECT T.ID from team T WHERE NOT EXISTS(SELECT C.teamID from claims C where C.teamID=T.ID and C.missionID=M.ID))";
        break;
    case "insert":
        $query = "INSERT into mission VALUES(" .
            $_POST["mission_id"] . ", " .
            $_POST["points"] . ", " .
            $_POST["completed"] . ", " .
            $_POST["time_limit"] . ", " .
            $_POST["min_score"] . ", " .
            $_POST["mon_id"] . ", " .
            $_POST["eld_id"] . ")";
        echo($query);
        break;
    case "set_complete":
        $query = "UPDATE mission set completion = 1 where ID = " . $_POST["mission_id"];
        break;
    case "":
        exit();
    default:
        exit("Bad action");
}

//create connection
$connection = mysqli_connect($host, $user, $pass, $db_name);

//test if connection failed
if(mysqli_connect_errno()){
    die("connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")");
}

//get results from database
$result = mysqli_query($connection,$query);
$all_property = array();  //declare an array for saving property

if (!$result){
   exit("<br>Error Record:<br>".mysqli_error($connection));
}
if ($_POST["action"] != "set_complete" && $_POST["action"] != "insert" && $_POST["action"] != "delete_complete") {
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
?>
</div>
</body>
</html>
