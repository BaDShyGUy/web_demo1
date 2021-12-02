<?php session_start(); 
require 'Card.php';
include ('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Collection Search</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<header>
	<nav>
		<div class="headerBar">
		<span id="loginText" class="bigText" style="text-align: left; margin-left: 25px;">
		<?php if ((isset($_POST["checkLogin"])) && !(isset($_COOKIE["user"])))
			{
				$user = $_POST["uname"];
				$pw = $_POST["psw"];
				
				try {
					$pdo = new PDO("mysql:host=localhost;dbname=test","admin", "YES");
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $pdo->prepare("SELECT * FROM users WHERE username='". $_POST["uname"] ."' AND password='" .$_POST["psw"]. "'");
					$stmt->execute();
					
					$res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
					if ($res != null)
					{
						//create cookie and display login and allow creation funcs
						setcookie("user", $_POST["uname"], time() + (3600)); #1 hour = 3600
						echo "Welcome, ". $_POST["uname"] .", to the Card Collection Search";
						
					}
					
				} catch(Exception $e)
				{
					die($e->getMessage());
				}
				finally
				{
					$pdo = null;
				}
			} else if (isset($_COOKIE["user"]))
			{
				echo "Welcome, ". $_COOKIE["user"] .", to the Card Collection Search";
				//allow creation funcs
			} else
			{
				echo "Welcome, Guest, to the Card Collection Search";
				//if available remove the creation funcs
			}
		?></span>
		<button onclick="document.getElementById('loginForm').style.display='block';" class="loginButton" style="margin-left: 50%;">Login</button>
		</div>
	</nav>
</header>
<body>
	<div id="loginForm">
		<button onclick="document.getElementById('loginForm').style.display='none';" class="loginButton" style="margin-left: 95%;">X</button>
		<form method="post" style="text-align: center;">
			<label for="uname" class="normalText"><b>Username:</b></label>
			<input type="text" placeholder="Enter Username" name="uname" required><br><br><br>
			<label for="psw" class="normalText"><b>Password:</b></label>
			<input type="password" placeholder="Enter Password" name="psw" required><br><br>
			<button type="submit" name="checkLogin" class="loginButton">Login</button>
		</form>
	</div>
	<div id="searchMenu">
      <div style="padding-left: 25%;">
      <form method="get">
        <input type="text" name="searchQuery" placeholder="Search the collection..." class="searchBar">
        <button type="submit" class="submitButton"><i class="fa fa-folder" style="color: rgb(25, 50, 100); font-size: 24px;"></i></button>
      </form>
      </div>
    </div>
	<div id="resultMenu">
	
		<?php #utility functions here...
			function parseSpecialHtml($str)
			{
				$str = stripslashes($str);
				$str = htmlspecialchars($str);
				return trim($str);
			}
			
			function deleteCardById($id)
			{
				$pdo = new PDO("mysql:host=localhost;dbname=test","admin", "YES");
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $pdo->prepare("DELETE FROM cards WHERE ID=\'".$id."\'");
					$count = $stmt->execute();
					
					if (count == 1)
					{
						#remove the card from the list too
					
					}
			}
			
		
		?>
		
		<?php
			
		
			try{
					$pdo = new MyPDO("mysql:host=localhost;dbname=test","admin", "YES", array());
					$CardClass = new TestCard($pdo);
					$searchType;
					
					if (isset($_GET["searchQuery"]) && $_GET["searchQuery"] != null)
					{
						$_SESSION["searchQuery"] = parseSpecialHtml(trim($_GET["searchQuery"]));
					}
				
					if (isset($_SESSION["searchQuery"]) && $_SESSION["searchQuery"] != null)
					{
						
						$parsedQuery = explode(":", $_SESSION["searchQuery"], 2);
						
						#need to implement sorting before the query is sent in some way so that it can retrieve it using ORDER BY
						
						switch($parsedQuery[0])
						{
							case "set":
								$searchType = $CardClass->GetCardBySet($parsedQuery[1]);
								break;
							case "name":
								switch(strlen($parsedQuery[1]))
								{
									case 1:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 1));
										break;
									case 2:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 2));
										break;
									case 3:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 3));
										break;
									case 4:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 4));
										break;
									case 5:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 5));
										break;
									case 6:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 6));
										break;
									case 7:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 7));
										break;
									case 8:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 8));
										break;
									case 9:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 9));
										break;
									case 10:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 10));
										break;
									case 11:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 11));
										break;
									case 12:
										$searchType = $CardClass->GetCardByName(substr($parsedQuery[1], 0, 12));
										break;
									default:
										$searchType = $CardClass->GetCardByName($parsedQuery[1]);
										break;
								}
								break;
							default:
								$searchType = null;
								break;
						}
						
						if ($searchType == null)
						{
							echo "<h2>You entered an invalid search query ' ". $_SESSION["searchQuery"] ." '.<br> Try, set:2XM, set:MIR, set:IMA, set:C18, set:C19, set:CMR or, set:WAR.<br> Or try, name:Ghi, name:Fea or, name:Vor.</h2>";
							return; #stop rest of code from executing
						}
						
						foreach($searchType->fetchAll() as $key=>$val)
						{
							echo "<div class=\"card_container\" id=" . $val["ID"] . "\">";
								echo "<img width=210px src=". $val["ImageURL"] ."></img>";
								#add the text for the prices here
								#going to implement the count of owned cards, prices later in here, get the prices by imeplmenting the json curl thingy from lab19, and also send to the database if the value isn't the same then update it maybe? depending on request limit
								echo "</div>";
						}						
						
						
					}
				} #end try
				catch(Exception $e)
				{
					die($e->getMessage());
				}
				finally
				{
					$pdo = null;
				}
		?>
	</div>
</body>

</html>