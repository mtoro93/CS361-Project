<?php
require 'commonFuncs.php'; 
$pdo = connect_db_pdo();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Applicants</title>
        <link rel='stylesheet' type='text/css' href='style.css' />
    </head>
    <body>
        <?php
        generate_nav_links();
        ?>
        <div style="float:right;">
	        <p>Welcome user!</p>
        </div>
        <div class="middleContent">
            
        <div>Select Opportunity</div>
    	<form action="viewApp.php" method="post">
		    <?php
		    echo '<select name="Opportunity">';
		        $stmt = $pdo->prepare("SELECT id, oppTitle FROM opportunities");
		        $stmt->execute();
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            echo '<option name="id" value="'. $row['id'] . '"'; 
		            
		            if(!(empty($_POST['Opportunity']))){
		                if($_POST['Opportunity'] == $row['id']){
		                    echo ' selected="selected"';
		                }
		            }
		            
		            
		            echo '"> ' . $row['oppTitle'] . '</option>\n';
		        }

		    ?>
		    <p><input type="submit" value="View Applicants" /></p>
		</form>


        <fieldset class="resultsBox">
        <?php
        $qry = "SELECT volunteers.firstName, volunteers.lastName, volunteers.resume 
        FROM opp_vol JOIN volunteers ON opp_vol.vol_id = volunteers.id WHERE opp_vol.opp_id IS NOT NULL ";
        
        if(!(empty($_POST['Opportunity']))){
            $qry .= "AND opp_vol.opp_id = :oppId ";
        }
        else{
            $qry .= "AND opp_vol.opp_id = 1 ";
        }
      
        $stmt = $pdo->prepare($qry);
        
        if(!(empty($_POST['Opportunity']))){
            $stmt->bindParam(':oppId', $_POST['Opportunity']);
        }
      
        $stmt->execute();
        
        echo "<div class='resultCount'>" . $stmt->rowCount() . " Applicants for this Opportunity.</div>"
        . '<p>Opportunity Status:<input type="radio" name="keep" value="yes"/>Available<input type="radio" name="keep" value="no"/>Filled</p>
        <br />';
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo '<fieldset class="volBox">' . '<div class="firstName">' . $row['firstName'] . '</div>' 
            . '<div class="lastName">' . $row['lastName'] . '</div>' 
            . '<div class="resume">' . $row['resume']
            . '</div>' 
            . '<div class="appButton"><button type="button">Select Candidate</button>'
            . '<button type="button">Remove Candidate</button></div>'
            . '</fieldset>';
        }
        ?>
        </fieldset>
        
        
         </div>
    </body>
</html>
