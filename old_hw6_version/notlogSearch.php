<?php
ini_set('display_errors', 'On');

$host = "127.0.0.1";
$db = 'sample_db';
$user = "woolfolz";
$pass = "";
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES      => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Search Opportunities</title>
        <link rel='stylesheet' type='text/css' href='style.css' />
    </head>
    <body>
        <div class="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="logSearch.php">Search For Opportunities (logged in)</a></li>
            <li><a href="notlogSearch.php">Search For Opportunities (not logged in)</a></li>
            <li><a href="postOpp.php">Post an Opportunity</a></li>
            <li><a href="EditOpp.php">Edit an Opportunity</a></li>
            <li><a href="viewApp.php">View Applicants</a></li>
        </ul>
        </div>
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