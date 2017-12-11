<?php
require 'commonFuncs.php';
$mysqli = connect_db_mysqli();
?>

<html>
    <head>
       <title>Edit Opportunity</title>
       <link rel='stylesheet' type='text/css' href='style.css' />
    </head>
    <body>
        <?php
        generate_nav_links();
        ?>
        <div class="middleContent" class="form">
        
<?php	

	if(!($stmt = $mysqli->prepare("SELECT oppTitle, oppField, oppStart, oppEnd, oppDescription, oppExpire, oppStreet, 
oppCity, oppCountry, oppState, oppZip, oppRemote, id FROM opportunities WHERE id = ?"))){
	echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!(empty($_POST['opp_id']))){
	    $stmt->bind_param("i", $_POST['opp_id']);
	}
	if(!$stmt->execute()){
		echo "Execute Failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_result($title, $field, $start, $end, $textarea, $exp, $street, $city, $country, $state, $zip, $remote, $id)){
		echo "Bind Failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		 $form = '<form method="post" action="completePost.php" >' // need to change this later
		 . '<fieldset>'
		 . '<legend style="font-size: 21px;">Edit Opportunity</legend>'
		 . '<p>Opportunity Title: <input type="text" name="title" value="'  . $title . '"/></p>'
         . '<p>Field of Opportunity: <input type="text" name="field" value="' . $field . '"/></p>'
         . '<p>Opportunity Duration: <input type="date" name="start" value="' . $start .  '"/>-' 
         . '<input type="date" name="end" value="'  . $end . '"/></p>'
         . '<p>Please Provide a thorough description of the opportunity:</p>'
         . '<p>'
         . '<textarea name="textarea" style="width: 400px;height:300px;">'   . $textarea . '</textarea></p>'
         . '<p>When should the opportunity expire: <input type="date" name="exp" value="' . $exp . '" /></p>'
         . '<p>Where is the opportunity located:</p>'
         . '<p>Street: <input type="text" name="street" value="' . $street . '" /></p>'
         . '<p>Country: <input type="text" name="country" value="' . $country .'"/>'
         .  'State: <input type="text" name="state" value="' . $state . '"/></p>'
         .  '<p>City: <input type="text" name="city" value="' . $city . '" />' 
         . 'Zipcode: <input type="text" name="zip" value="' . $zip .'" /></p>';
         
         if (strcmp($remote, 'yes') == 0)
        	$form .= '<p>Work Remote: <input type="radio" name="remote" value="yes" checked = "checked"/>Yes<input type="radio" name="remote" value="no"/>No</p>';
         else
        	$form .= '<p>Work Remote: <input type="radio" name="remote" value="yes"/>Yes<input type="radio" name="remote" value="no" checked = "checked"/>No</p>';
         $form .= '<input type="hidden" id="editID" name="opp_id" value="' . $id . '"></input>';
         $form .= '<input type="submit" name="editOpp" value="Submit Changes" class="button"/></fieldset></form>';
         echo $form;
	}
	$stmt->close();
?>
    </div>
    </body>
</html>