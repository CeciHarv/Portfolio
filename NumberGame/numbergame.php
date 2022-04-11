<?php
// Start a session
session_start();
?>
<!DOCTYPE html>
<html>
<body>
    <?php
        // Game in session
        if($_SESSION["invalidinput"]) {
            echo "Your guess wasn't a number, or it was out of range. Please try again. <br>";
            $_SESSION["invalidinput"] = false;
        } 
        // Game starting 
        else if (!isset($_SESSION['randNum'])){
            $_SESSION['numGuesses'] = 0;
            $_SESSION['randNum'] = random_int(1, 100);
        }
        // For Testing
        // echo "My randomNum is: " . $_SESSION["randNum"] . " <br>";
    ?>
    <p>
        <form action="capture.php" method="post">
            <p><h3>Guess a number between 1-100 (inclusive): </h3><input type="text" name="UserGuess"/></p>
            <input type="submit" value="Submit"/>  
        </form>
    </p>
    <p>
        <form action="../login.php" method="post">
            <input type="submit" value="Log Out"/>
        </form>
    </p>
</body>
</html>