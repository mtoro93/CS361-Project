<?php
### to include in other files: 
### require 'commonFuncs.php'; ###


#connects to db and returns new pdo object
#usage: $pdo = connect_db_pdo();
function connect_db_pdo(){
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
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
    }
}


#connects to db and returns new mysqli object
#usage: $mysqli = connect_db_mysqli();
function connect_db_mysqli(){
    $host = "127.0.0.1";
    $user = "woolfolz";
    $pass = "";
    $db = "sample_db";
    $port = 3306;
    $mysqli = new mysqli($host, $user, $pass, $db);


    if($mysqli->connect_errno){
	    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    return $mysqli;
}


#generates navigation bar
#usage: generate_nav_links();
function generate_nav_links(){
    echo '
    <div class="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="logSearch.php">Search For Opportunities (logged in)</a></li>
            <li><a href="notlogSearch.php">Search For Opportunities (not logged in)</a></li>
            <li><a href="postOpp.php">Post an Opportunity</a></li>
            <li><a href="EditOpp.php">Edit an Opportunity</a></li>
            <li><a href="viewApp.php">View Applicants</a></li>
            <li><a href="advancedSearch.php">Advanced Search</a></li>
        </ul>
    </div>
    ';
}
?>