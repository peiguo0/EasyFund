<?php
session_start();
require 'db.php';
require 'js_functions.html';

date_default_timezone_set('America/New_York');

echo "test:    ";
echo $_POST["searchtext"];

?>




<?php

	$search_query = "SELECT *  FROM project  where (pname like '%{$_POST["searchtext"]}%'  or category like '%{$_POST["searchtext"]}%'  or tags like '%{$_POST["searchtext"]}%'  or description like '%{$_POST["searchtext"]}%')";
	$search_result = mysqli_query($connection,$search_query);


		echo "<table border ='1'>
		<th>Projects List</th>
		<tr>
		<th>Project ID</th>
		<th>Project Name</th>
		<th>Min amount</th>
		<th>Max amount</th>
		<th>Owner ID</th>
		<th>fund Deadline</th>
		<th>Project DeadLine</th>
		<th>Category</th>
		<th>Tags</th>
		<th>Description</th>
		<th>Details</th>
		</tr>";

	while($row = mysqli_fetch_array($search_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['pname'] . "</td>";
    		echo "<td>" . $row['minamount'] . "</td>";
    		echo "<td>" . $row['maxamount'] . "</td>";

    		echo "<td>" . $row['uid'] . "</td>";
    		// echo '<td><a href="userpage.php?id='.$row['uid'].'">'.$row['uid'].'</a></td>';
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		echo "<td>" . $row['projDdl'] . "</td>";
    		echo "<td>" . $row['category'] . "</td>";
    		echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>" . $row['description'] . "</td>";
    		echo "<td><input type='submit' value='See Details' onClick='detailed_projects(this)';></td>";
    		echo "</tr>";

	}; 

	$currenttime = date('Y-m-d H:i:s');
	$insert_search = "INSERT into keywordHistory (uid, keyword, searchKwTime) values ('{$_SESSION["uid"]}', '{$_POST["searchtext"]}', '$currenttime')";

	if(mysqli_query($connection, $insert_search)) {
		echo "Congratulations ";
		echo ":  ";
    	echo "New record created successfully";
		}
	else{
    	echo "Error: " . $sql . "<br>" . mysqli_error($connection);
		}


?>