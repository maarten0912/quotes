<!-- TODO:
	Implement admin quote deletion
-->

<?php
include 'dbinfo.php';
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<title>Quotes</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	

		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 

		<script src="script.js"></script>

	</head>
	<body>
		<!-- div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form method="post">
							<div class="form-group">
								<label for="pwd"><b>Password</b></label>
								<input type="password" class="form-control" name="pwd">
							</div>			
								<button type="submit" class="btn btn-primary">Login</button>
						</form>
					</div>
				</div>
			</div>

		</div -->

		<div class="container pt-3" id="alertbox">
		</div>
		<div class="container">
			<!--button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#adminModal">Admin?</button -->
			<h1>Quotes</h1>
			<form method="post">	
				<div class="form-group">
					<label for="quote">Nieuwe quote:</label>
					<input type="text" class="form-control" id="quote" name="quote">
				</div>
				<div class="form-group">
					<label for="speaker">Door:</label>
					<input type="text" class="form-control" id="speaker" name="speaker">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>

			<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				/* if (isset($_POST['pwd'])) {
					$inputpwd = htmlspecialchars($_POST['pwd']);
					if ($inputpwd == 'maarten') {
						$admin = True;					
					} else {
						$admin = False;
					}
					echo "<script>location = location;</script>";
				} elseif (isset($_POST['delete'])) {
					if ($admin == True) {
						$inputid = htmlspecialchars($_POST['delete']);
						$conn = new mysqli ($database_host, $database_user, $database_password, $database_name);
						if ($conn->connect_error) {
							echo "<script> raise_error('Could not connect to database'); </script>";
							$conn->close();
						} else {
							$statement = $conn->prepare("DELETE FROM quotes WHERE id=?");
							$statement->bind_param("s", $inputid);
							$statement->execute();
							$statement->close();
							$conn->close();
						}
						echo "<script>location = location;</script>";
					}
				
				} else {
				*/
				$inputquote = $_POST['quote'];
				$inputspeaker = $_POST['speaker'];

				$inputquote = htmlspecialchars($inputquote);
				$inputspeaker = htmlspecialchars($inputspeaker);

				#echo '<script> alert("'. $inputquote.'") </script>';
				#echo '<script> alert("'. $inputspeaker.'") </script>';

				$exit = False;

				if (empty($inputquote) || is_null($inputquote) || empty($inputspeaker) || is_null($inputspeaker)) {
					echo "<script> raise_error('Input was not accepted'); </script>";
					$exit = True;
				}

				$conn = new mysqli ($database_host, $database_user, $database_password, $database_name);

				if ($conn->connect_error) {
					echo "<script> raise_error('Could not connect to database'); </script>";
					$conn->close();
					$exit = True;
				} elseif ($exit == False) {
					$statement = $conn->prepare("CREATE TABLE IF NOT EXISTS quotes (id int PRIMARY KEY, quote TEXT NOT NULL, speaker TEXT NOT NULL);");
					$statement->execute();
					
					$statement = $conn->prepare("INSERT INTO quotes (quote, speaker) VALUES (?, ?);");
					$statement->bind_param("ss", $inputquote, $inputspeaker);
					$statement->execute();
					$statement->close();
					$conn->close();
				}
				echo "<script>location = location;</script>";
				#}
			}
			?>

			<hr/>
			<ul class="list-group">

				<?php
				$conn = new mysqli ($database_host, $database_user, $database_password, $database_name);
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql = "SELECT quote, speaker FROM quotes ORDER BY id DESC;";
				$result = $conn->query($sql);
		
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
					/* if ($admin == True) {
						echo "<li class=\"list-group-item\"> <button type='button' class='btn btn-danger float-right'>Delete</button>" . $row['quote'] . "<br>-" . $row['speaker'] . "</li>";
					} else {
					*/
					echo "<li class=\"list-group-item\">" . $row['quote'] . "<br>-" . $row['speaker'] . "</li>";
					#}

					}
				} else {
					echo "<p>There are no quotes yet</p>";
				}
				$conn->close();
				?>

			</ul>
		</div>
	</body>
</html>
