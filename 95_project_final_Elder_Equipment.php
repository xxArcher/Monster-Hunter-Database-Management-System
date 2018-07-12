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

<h1> Equipment -- Elders </h1>


<p> Show All Equipments </p>
<form method="POST" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>


<p><input type="submit" value="Select All Equipments" name="select_Equipment"></p>
</form>

<p> Show All What equipments hunters are wearing </p>
<form method="POST" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>


<p><input type="submit" value="Select All Wears" name="select_Wears"></p>
</form>

<p> Insert a new equiment by name </p>
<form method="POST" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>

 New equipment name: <input type = "text" name = "insert_EquipName" />  <br/>
 <p><input type="submit" value="Insert" name="insert_Equipment"></p>
</form>

<p> Assign an equipment to a hunter</P>

<form method="POST"  action = <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
Equipment name: <input type = "text" name="insert_EquipName" /> <br/>
HunterID: <input type="text"  name= "insert_HunterID" /> <br/>
<p> <input type ="submit" value="Insert" name="insert_Wears"> </p>
</form>


<p>Retrieve an equipment from a hunter </P>

<form method="POST"  action = <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
Equipment name: <input type ="text" name="delete_Wears_EquipName"/><br/>
ID: <input type="text"  name= "delete_HunterID" /> <br/>

<p> <input type ="submit" value="Delete" name="delete_Wears"> </p>
</form>

<p>Delete an equipment (and also delete corresponding wears relationships) </P>

<form method="POST"  action = <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>

Equipment Name: <input type="text"  name= "delete_EquipName" /> <br/>

<p> <input type ="submit" value="Delete" name="delete_Equipment"> </p>
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

    if (array_key_exists('select_Equipment', $_POST)){

        $result = SQL_execute("SELECT * FROM equipment ;");

        global $success;
        if ($_POST && $success)

        printResult($result);
    }else if (array_key_exists('select_Wears', $_POST)){

        $result = SQL_execute("SELECT * FROM wears ;");

        global $success;
        if ($_POST && $success)

        printResult($result);
    }
    else if (array_key_exists('insert_Equipment', $_POST)){
        echo "<br> inserted new equipment";
        $EquipName = $_POST['insert_EquipName'];

        $sql = "INSERT INTO equipment values('".$EquipName."');";

         SQL_execute($sql);

        global $success;
        if ($_POST && $success){
        $result = SQL_execute("SELECT * FROM equipment ;");
        printResult($result);
        }
    }
    else if (array_key_exists('insert_Wears', $_POST)){

        echo "<br> the newly assigned equipment to the hunter";

        $EquipName = $_POST['insert_EquipName'];
        $HunterID = $_POST['insert_HunterID'];


        $sql = "INSERT INTO wears values ('".$EquipName."','".$HunterID."');";

        $result = SQL_execute($sql);

        global $success;

        if ($_POST && $success)
            {
                $result = SQL_execute("SELECT * FROM wears ;");
                 printResult($result);
            } else {
            echo "<br>Invalid Input: Equipment Name or HunterID does not exist";
        }

    }
    else if (array_key_exists('delete_Wears', $_POST)){
        echo "<br> retrieved the equipment from the hunter";

        $HunterID = $_POST['delete_HunterID'];
        $EquipName = $_POST['delete_Wears_EquipName'];

        $sql = "DELETE FROM wears WHERE HunterID=".$HunterID." AND EquipName='".$EquipName."';";

       SQL_execute($sql);

        global $success;
        if ($_POST &&$success){
            $result = SQL_execute("SELECT * FROM wears ;");

            printResult($result);
        }else {
            echo "<br>Invalid Input: Equipment Name or HunterID does not exist";
        }
    } else if (array_key_exists('delete_Equipment', $_POST)){
        echo "<br> deleted the equipment";


        $EquipName = $_POST['delete_EquipName'];


        $sql = "DELETE FROM Equipment WHERE Name='".$EquipName."';";

        SQL_execute($sql);

        $cascade_sql = "DELETE FROM Wears WHERE EquipName='".$EquipName."';";

        SQL_execute($cascade_sql);

        global $success;
        if ($_POST &&$success){
            $result = SQL_execute("SELECT * FROM equipment ;");

            printResult($result);
        }else {
            echo "<br>Invalid Input: Equipment Name does not exist";
        }
    }
    }else {
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
</div>
</body>
</html>
