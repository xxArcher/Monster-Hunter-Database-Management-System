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

<h1> Mission -- Hunters </h1>

<form method="post">
    <input type="hidden" name="action" value="view_incomplete"/>
    <input type="submit" value="View incomplete missions" />
</form>
<br />
<form method="post">
    Minimum Score >=: <input type="text" name="min_score"/>
    <input type="hidden" name="action" value="filter_by_min"/>
    <input type="submit" value="Filter by minimum" />
</form>
<br />
<form method="post">
    Reward Points >=: <input type="text" name="points"/>
    <input type="hidden" name="action" value="filter_by_points"/>
    <input type="submit" value="Filter by points" />
<!-- </form>
<br />
<form method="post">
    Reward Points >=: <input type="text" name="points"/>
    <input type="hidden" name="action" value="filter_by_points"/>
    <input type="submit" value="Filter by points" />
</form> -->

<?php
require(dirname(__FILE__).'/95_project_final_connect2.php');

// $host    = "127.0.0.1";
// $user    = "root";
// $pass    = "xu25672788";
// $db_name = "test";
$query = "";

switch($_POST["action"]) {
    case "view_incomplete":
        $query = "select * from mission where completion = 0";
        break;
    case "filter_by_min":
        $query = "select * from mission where minimumscore >= " . $_POST["min_score"];
        break;
    case "filter_by_points":
        $query = "select * from mission where rewardpoint >= " . $_POST["points"];
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
?>
</div>
</body>
</html>
