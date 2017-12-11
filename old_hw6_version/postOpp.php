<?php
$host = "127.0.0.1";
$user = "woolfolz";
$pass = "";
$db = "sample_db";
$port = 3306;
$mysqli = new mysqli($host, $user, $pass, $db);
?>

<!DOCTYPE html>
<html>
    <link rel='stylesheet' type='text/css' href='style.css' />

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
        <div class="middleContent" class="form">
            <form method="post" action="completePost.php" >
                <fieldset >
                    <legend style="font-size: 21px;">Post A New Opportunity</legend>
                    <p>Opportunity Title: <input type="text" name="title" /></p>
                    <p>Field of Opportunity: <input type="text" name="field" /></p>
                    <p>Opportunity Duration: <input type="date" name="start" /> - <input type="date" name="end" /></p>
                    <p>Please Provide a thorough description of the opportunity:</p>
                    <p></p><textarea name="textarea" style="width: 400px;height:300px;"></textarea></p>
                    <p>When should the opportunity expire: <input type="date" name="exp" /></p>
                    <p>Where is the opportunity located:</p>
                    <p>Street: <input type="text" name="street" /></p>
                    <p>Country: <input type="text" name="country" /> State: <input type="text" name="state" /></p>
                    <p>City: <input type="text" name="city" /> Zipcode: <input type="text" name="zip" /></p>
                    <p>Work Remote: <input type="radio" name="remote" value="yes"/>Yes<input type="radio" name="remote" value="no"/>No</p>
                    <input type="submit" value="Post New Opportunity" class="button"/>
                </fieldset>
            </form>
        </div>
    </body>
</html>

