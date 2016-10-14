<html>
	<head>
		<title>Hackathon</title>

		<link rel="stylesheet" href="css/style.css"/>

		<script src="js/jquery.js"></script>
        <script src="js/jquery-ui.js"></script>
	</head>
	<body>
		<nav>
			<ul>
				<?php
					require_once 'dbConnection.php';

					$subjects = ["Physics", "Chemistry", "Maths"];
					for ($i = 0; $i < 3; $i++)
					{
						echo '	<li>
									<a href="javascript:void(0)">'.$subjects[$i].' <span class="caret"></span></a>
									<div>
										<ul>';

						$dbCon = new dbConnection();
						$con = $dbCon->con;

						$result = mysqli_query($con, "SELECT * FROM Course WHERE subject='".$subjects[$i]."'");

						while($row = mysqli_fetch_assoc($result))
						{
							echo '			<li>
												<a href="javascript:void(0)">'.$row["name"].' <span class="caret"></span></a>
												<div>
													<ul>';

							$result2 = mysqli_query($con, "SELECT * FROM SubTopic WHERE topicId=".$row["id"]);

							while($row2 = mysqli_fetch_assoc($result2))
							{
								echo '					<li><a href="javascript:void(0)">'.$row2["name"].'</a></li>';
							}

							echo '					</ul>
												</div>
											</li>';
						}

						echo '			</ul>
									</div>
								</li>';
					}
				?>
			</ul>
		</nav>

		<div id="lecturePage" style="display: none;">
			<div id="arcReactor"></div>
		</div>

		<div id="questionPage" style="background-color: white; left: 10%; width: 80%; position: absolute; display: none;">
			question page
		</div>

		<script>
			$('#lecturePage').show();
		</script>
	</body>
</html>