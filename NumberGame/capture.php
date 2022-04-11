<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<?php
			// Evaluate the user's guess
			$guess = $_POST["UserGuess"];
			;
			if(!filter_var($guess, FILTER_VALIDATE_INT) || $guess > 100 || $guess < 1 ){
				$_SESSION['invalidinput'] = true;
				header('Location: numbergame.php');
				exit();
			}
			if($guess > $_SESSION["randNum"]) {
				$highLow = "high";
			}
			else if($guess < $_SESSION["randNum"]){
				$highLow = "Low";
			}
			else{
				 // server side code for db access
				$servername = "ADD SERVER NAME HERE";
				$dbusername = "ADD DB USERNAME HERE";
				$dbpassword = "ADD DBPASSWORD HERE";
				$dbname = "ADD DB NAME HERE";
      
				// Create connection
				$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				else {
					// Insert score to the HighScores table
					$numGuesses = $_SESSION['numGuesses'];
					$user = $_SESSION['user'];
					$sql = "INSERT INTO HighScores ( User, NumGuesses) VALUES ('$user', '$numGuesses')";
					if ($conn->query($sql) === TRUE) {
						echo "New score inserted to record.";
					} 
					else {
		    			echo "Error: " . $sql . "<br>" . $conn->error;
					}
					unset($_SESSION["randNum"]);
					header('Location: endgame.php');
				}
				$conn->close();
				exit();
			}
			
			$_SESSION['numGuesses'] += 1;
			
			// Give hint if they didn't get it right'
			echo "Your guess was: " . $guess . " <br>";
			echo "This was too " . $highLow . " <br>";
			echo "Number of Guesses: " . $_SESSION['numGuesses'] . "<br>";

		?>
		<p>
			<form action="numbergame.php">
				<input type="submit" value="Guess Again" />
			</form>
		</p>
		<p>
			<form action="../login.php" method="post">
				<input type="submit" value="Log Out"/>
			</form>
		</p>
	</body>
</html>