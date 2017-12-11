<?php
require 'commonFuncs.php'; 
$pdo = connect_db_pdo();
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Search Opportunities</title>
        <link rel='stylesheet' type='text/css' href='style.css' />
    </head>
    <body>
        <?php
        generate_nav_links();
        ?>
        <div style="float:right;">
	        <a href="" class="signupButton">Sign up!</a>
        </div>
        <div class="middleContent">
            <div class="searchForm">
            <fieldset >
                <legend>Search for an opportunity</legend>
                <form  action="notlogSearch.php" method="post" >
                    <input type="text" name="query" placeholder="Job title, keywords, organization..." class="searchField"/>
                    <input type="submit" name="submit" value="Search" class="searchButton"/>
                </form>
                <p style="margin: 0;"><a class="advancedSearchButton" href="advancedSearch.php">Advanced Search</a></p>
            </fieldset>
            </div>
        
        
            
        <fieldset class="resultsBox">
        <?php
        $qry = "SELECT oppTitle, oppDescription FROM opportunities WHERE opportunities.id IS NOT NULL ";
        
        if(!(empty($_POST['query']))){
            $qry .= "AND MATCH opportunities.oppTitle AGAINST (:searchQry1) ";
            $qry .= "OR MATCH opportunities.oppField AGAINST (:searchQry2) ";
            $qry .= "OR MATCH opportunities.oppDescription AGAINST (:searchQry3) ";
        }
        $stmt = $pdo->prepare($qry);
        
        if(!(empty($_POST['query']))){
            $stmt->bindParam(':searchQry1', $_POST['query']);
            $stmt->bindParam(':searchQry2', $_POST['query']);
            $stmt->bindParam(':searchQry3', $_POST['query']);
        }
        
        $stmt->execute();
        
        echo "<div class='resultCount'>" . $stmt->rowCount() . " results found.</div><br />";
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo '<fieldset class="opportunityBox">' . '<div class="oppTitle">' . $row['oppTitle'] . '</div>' 
            . '<div class="oppDescription">' . $row['oppDescription']
            . '</div>' . '</fieldset>';
        }
        ?>
        </fieldset>
        
        
            
        </div>
    </body>
</html>