<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<body>
    <?php
        $user = $_SESSION['user'];
        echo "You Won! Congrats $user! <br>";
        echo "Final Number of Guesses: " . $_SESSION["numGuesses"] . "<br>";

        // server side code for db access
        $servername = "ADD SERVER NAME HERE";
	    $dbusername = "ADD DB USERNAME HERE";
	    $dbpassword = "AD DB PASSWORD HERE";
	    $dbname = "ADD DB NAME HERE";
      
        // Create connection
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else {
            // Insert score to the HighScores table
            $numGuesses = $_SESSION['numGuesses'];
            // Print High Scores
		    echo "<h1> High Scores </h1> <br> ";
            $sql = "SELECT * FROM HighScores ORDER BY NumGuesses ASC LIMIT 10";
			$result = $conn->query($sql);
                 
			if ($result->num_rows > 0) 
			{	
				// Print the top 10 high scores
				echo "<pre>Place |  User  | # Guesses <br><pre>";
				// Print the actual high scores output up to top 10 scores
                $i = 1;
				while ($row = $result->fetch_assoc()) 
				{
				 	echo "<pre>" . $i . ".  " . $row["User"] . "   |   " . $row["NumGuesses"] . "    <br><pre>";
                    $i++;
				}	
			} 
		    else {
		    	echo "Error: " . $sql . "<br>" . $conn->error;
		    }
            unset($_SESSION['numGuesses']);
        }
      $conn->close();
    ?>
    <p>
        <form action="numbergame.php" method="post">
        <input type="submit" value="Play Again"/>
        </form>
    </p>
    <p>
        <form action="../login.php" method="post">
            <input type="submit" value="Log Out"/>
        </form>
    </p>
</body>
</html>