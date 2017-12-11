<?php
require 'commonFuncs.php'; 
$pdo = connect_db_pdo();
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Advanced Search</title>
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
            <fieldset class="searchForm">
                <legend>Search for an opportunity</legend>
                <form class="advancedSearchForm" action="advancedSearch.php" method="post">
                    <?php
                        if(!(empty($_POST['query']))){
                            echo '<input type="text" name="query" placeholder="' . $_POST['query'] . '" class="searchField"/>';
                        }
                        else{
                            echo '<input type="text" name="query" placeholder="Job title, keywords, organization..." class="searchField"/>';
                        }
                        
                        if(!(empty($_POST['locquery']))){
                            echo '<input type="text" name="locquery" placeholder="' . $_POST['locquery'] . '" class="searchField"/><br>';
                        }
                        else{
                            echo '<input type="text" name="locquery" placeholder="City, state, zip code..." class="searchField"/><br>';
                        }
                        
                        if(!(empty($_POST['remotequery']))){
                            echo '<br><input type="checkbox" name="remotequery" value="yes" checked>Remote opportunities only?<br>';
                        }
                        else{
                            echo '<br><input type="checkbox" name="remotequery" value="yes">Remote opportunities only?<br>';
                        }
                        
                        if(!(empty($_POST['start']))){
                            echo '<p>Earliest Start Date: <input type="date" name="start" value="' . $_POST['start'] . '"/></p>';
                        }
                        else{
                            echo '<p>Earliest Start Date: <input type="date" name="start" /></p>';
                        }
                    ?>
                    <input type="submit" name="submit" value="Search" class="searchButton"/>
                </form>
            </fieldset>
        

        <fieldset class="resultsBox">
        <?php
        $qry = "SELECT oppTitle, oppDescription, oppCity, oppState, oppZip, oppRemote, oppStart FROM opportunities WHERE opportunities.id IS NOT NULL ";
        
        if(!(empty($_POST['query']))){
            $qry .= "AND (MATCH opportunities.oppTitle AGAINST (:searchQry1) ";
            $qry .= "OR MATCH opportunities.oppField AGAINST (:searchQry2) ";
            $qry .= "OR MATCH opportunities.oppDescription AGAINST (:searchQry3)) ";
        }
        if(!(empty($_POST['locquery']))){
            $qry .= "AND (MATCH opportunities.oppCity AGAINST (:locQry1) ";
            $qry .= "OR MATCH opportunities.oppState AGAINST (:locQry2) ";
            $qry .= "OR opportunities.oppZip = (:locQry3)) ";
        }
        
        if(!(empty($_POST['remotequery']))){
            $qry .= "AND opportunities.oppRemote = 'yes' ";
        }
        
        if(!(empty($_POST['start']))){
            $qry .= "AND opportunities.oppStart >= (:dateQry) ";
        }
        
        $stmt = $pdo->prepare($qry);
        
        if(!(empty($_POST['query']))){
            $stmt->bindParam(':searchQry1', $_POST['query']);
            $stmt->bindParam(':searchQry2', $_POST['query']);
            $stmt->bindParam(':searchQry3', $_POST['query']);
        }
        if(!(empty($_POST['locquery']))){
            $stmt->bindParam(':locQry1', $_POST['locquery']);
            $stmt->bindParam(':locQry2', $_POST['locquery']);
            $stmt->bindParam(':locQry3', $_POST['locquery']);
        }
        if(!(empty($_POST['start']))){
            $stmt->bindParam(':dateQry', $_POST['start']);
        }
        
        $stmt->execute();
        
        echo "<div class='resultCount'>" . $stmt->rowCount() . " results found.</div><br />";
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo '<fieldset class="opportunityBox">' . '<div class="oppTitle">' . $row['oppTitle'] . '</div>' 
            . '<div class="oppDescription">' . $row['oppDescription'] . '</div>'
            .  '<div class="oppLocation">' . '<b>Location: </b>'. $row['oppCity'] . ', ' . $row['oppState'] . ', ' . $row['oppZip']
            .  '</div>' . '<div class="oppRemoteInfo">' . '<b>Remote: </b>' . $row['oppRemote'] . '</div>' 
            .  '<div><b>Start Date: </b>' . $row['oppStart'] . '</div>' 
            .  '<div class="oppApplyButton"><button type="button">Apply</button></div>'
            . '</fieldset>';
        }
        ?>
        </fieldset>
        
        
         </div>
    </body>
</html>


