<?php
    session_start();

    $echoedShout = "";

    if(count($_POST) > 0) {
        $_SESSION['shout'] = $_POST['shout'];

        header("HTTP/1.1 303");
        header("Location: http://$_SERVER[HTTP_HOST]/daw/echochamber.php");
        die();
    }
    else if (isset($_SESSION['shout'])){
        $echoedShout = $_SESSION['shout'];

        /*
            Put database-affecting code here.
        */

        session_unset();
        session_destroy();
    }
?>

<!DOCTYPE html>
<html>
<head><title>PRG Pattern Demonstration</title>

<body>
    <?php echo "<p>$echoedShout</p>" ?>
    <form action="/daw/echochamber.php" method="POST">
        <input type="text" name="shout" value="" />
    </form>
</body>
</html>