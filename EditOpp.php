<?php
require 'commonFuncs.php'; 
$pdo = connect_db_pdo();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit an Opportunity</title>
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
        <h1>Edit an Opportunity</h1>
        <fieldset class="resultsBox">
        <?php
        $qry = "SELECT oppTitle, oppDescription, id FROM opportunities WHERE opportunities.id IS NOT NULL ";
        $stmt = $pdo->prepare($qry);
        $stmt->execute();
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo '
            <fieldset class="opportunityBox">' 
            . '<div class="oppTitle">' . $row['oppTitle']  . '</div>'
            . '<div class="oppDescription">' . $row['oppDescription'] . '</div>' 
            . '<form action="test.php" method="post">'
            . '<input type="hidden" id="editID" name="opp_id" value="' . $row['id'] . '"></input>'
            . '<input type="submit" id="edit" name="submit" value="Edit"></input>'
            . '</form>'
            . '</fieldset>';
        }
        ?>
        </fieldset>
         </div>
    </body>
</html>


