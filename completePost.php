<?php
require 'commonFuncs.php';
$mysqli = connect_db_mysqli();
?>

<html>
    <head>
       <title>Opportunity Posted</title>
       <link rel='stylesheet' type='text/css' href='style.css' />
    </head>
    <body>
        <?php
        generate_nav_links();
        ?>
        <div class="middleContent" class="form">
        
<?php	


if(strcmp($_POST['submit'], "Post New Opportunity") == 0){
	if(!($stmt = $mysqli->prepare("INSERT INTO opportunities(oppTitle, oppField, oppStart, oppEnd, oppDescription, oppExpire, oppStreet, 
oppCity, oppCountry, oppState, oppZip, oppRemote) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("ssssssssssis", $_POST['title'],$_POST['field'],$_POST['start'],$_POST['end'],$_POST['textarea'],$_POST['exp']
,$_POST['street'],$_POST['country'],$_POST['state'],$_POST['city'],$_POST['zip'],$_POST['remote']))){
		echo "Bind Failed: " . $stmt->errno . " " . $stmt->error;
	}
}
else{
	if(!($stmt = $mysqli->prepare("UPDATE opportunities SET oppTitle = ?, oppField=?, oppStart=?, oppEnd=?, oppDescription=?, oppExpire=?, oppStreet=?, 
oppCity=?, oppCountry=?, oppState=?, oppZip=?, oppRemote=? WHERE id=?"))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("ssssssssssisi", $_POST['title'],$_POST['field'],$_POST['start'],$_POST['end'],$_POST['textarea'],$_POST['exp']
,$_POST['street'],$_POST['country'],$_POST['state'],$_POST['city'],$_POST['zip'],$_POST['remote'], $_POST['opp_id']))){
	echo "Bind Failed: " . $stmt->errno . " " . $stmt->error;
}
}

/*
if(!($stmt->bind_param("ssssssssssis", $_POST['title'],$_POST['field'],$_POST['start'],$_POST['end'],$_POST['textarea'],$_POST['exp']
,$_POST['street'],$_POST['country'],$_POST['state'],$_POST['city'],$_POST['zip'],$_POST['remote']))){
	echo "Bind Failed: " . $stmt->errno . " " . $stmt->error;
}*/


if(strcmp($_POST['end'], $_POST['start']) < 0){
	echo "The start date must be before the end date.";
} elseif($_POST['title'] === ""){
	echo "You must provide an opportunity title";
} elseif($_POST['field'] === ""){
	echo "You must provide an opportunity field";
}elseif(!$stmt->execute()){
	echo "Execute Failed: " . $stmt->errno . " " . $stmt->error;
} else{
	//echo "Added " . $stmt->affected_rows . " rows to property.";
	echo "The following opportunity was added or updated:"; 
}
?>


	<div>
		<table>
			<tr>
				<td>Title</td>
				<td>Field</td>
				<td>Start Date</td>
				<td>End Date</td>
				<td>Description</td>
				<td>Expiration Date</td>
				<td>Street</td>
				<td>City</td>
				<td>Country</td>
				<td>State</td>
				<td>Zip</td>
				<td>Work Remote</td>
			</tr>


<?php	


if(!(empty($_POST['opp_id']))){
	if(!($stmt = $mysqli->prepare("SELECT oppTitle, oppField, oppStart, oppEnd, oppDescription, oppExpire, oppStreet, 
oppCity, oppCountry, oppState, oppZip, oppRemote FROM opportunities WHERE id = ?"))){
	echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
	}
	$stmt->bind_param('i', $_POST['opp_id']);
}
else{	
	if(!($stmt = $mysqli->prepare("SELECT oppTitle, oppField, oppStart, oppEnd, oppDescription, oppExpire, oppStreet, 
oppCity, oppCountry, oppState, oppZip, oppRemote FROM opportunities ORDER BY id DESC LIMIT 1"))){
	echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
	}
	
	
}
	
	if(!$stmt->execute()){
		echo "Execute Failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_result($title, $field, $start, $end, $textarea, $exp, $street, $city, $country, $state, $zip, $remote)){
		echo "Bind Failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $title . "</td>\n<td>\n" . $field . "</td>\n<td>\n" . $start . "</td>\n<td>\n" . $end . "</td>\n<td>\n" .
		$textarea . "</td>\n<td>\n" . $exp . "</td>\n<td>\n" . $street . "</td>\n<td>\n" . $city . "</td>\n<td>\n" . $country . "</td>\n<td>\n" . $state .
		"</td>\n<td>\n" . $zip . "</td>\n<td>\n" . $remote . "\n</td>\n</tr>";
	}
	$stmt->close();
?>

	</table>
</div>



    </div>
    </body>
</html>