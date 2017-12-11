<?php
require 'commonFuncs.php'; 
$mysqli = connect_db_mysqli();
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' type='text/css' href='style.css' />
        <title>Post Opportunity</title>
    </head>
    <body>
        <?php
        generate_nav_links();
        ?>
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

