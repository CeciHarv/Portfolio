# Hangman
![Hangman GIF](Screenshots/Hangman.gif)
<br>

## Description
Created a web app hangman game that includes authentication, a database, and asynchronous programming with websockets
<br>

## Authors
Tage Higley <br>
Dennis Chase <br>
Hunter Olson <br>
Cecilia Harvey <br>

### Date
Feb 2022
<br>

## Tools Used
ASP.NET Core 6.0: The server side functionality uses ASP.NET Core  <br>
Blazor: The client side was a Blazor WebAssemnbly App which work with razor pages <br>
SignalR: We ran our asynchronous tasks through SignalR, which mostly uses websockets <br>
Access Database: For the user accounts and high scores we used an Access database file  <br>
Visual Studio: For the IDE, I used Visual Studio <br>
<br>

### Cecilia Harvey's Contributions
Password salting and hashing <br>
Login with SignalR <br>
SignalR set up and examples <br>
Database set up (with a lot of help from teamates, especially Dennis Chase)<br>
Git: Version control was managed through Git and GitHub <br>

### Usage
**Logging In**
- Use an existing username and password, or create a new account--or create a new account 
- Account names and passwords persist locally in an access database file
- Passwords are salted and hashed before storage in the local database
- After logging in, you will be redirected to the Hangman game. 
<br>

**Scoring**
- The score is displayed in the top left corner. 
- The score is the number of incorrect guesses you've made. 
- The lower the score, the better. 
<br>

**How to Win**<br>
In order to win you must successfully guess all the letters of the random word. <br>
You have a maximum of 5 incorrect guesses before losing the game. 
<br>

