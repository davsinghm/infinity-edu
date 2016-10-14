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

		<div id="particles-js"></div>
		<script src="js/particles.min.js"></script>

		<script>
			particlesJS("particles-js", {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":50,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"none"},"onclick":{"enable":true,"mode":"none"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});
		</script>

		<div id="lecturePage" style="display: none;">
			Lecture Page
		</div>

		<div id="questionPage" style="background-color: rgb(39, 40, 34); box-shadow: 0px 0px 15px rgb(255, 255, 255); left: 56px; width: 70%; top: 112px; height: calc(100% - 168px); position: absolute; display: none; z-index: 0;">
			Question Page

				<div style="margin-top: 40.25%; margin-left: 17%; font-size: 1.8em;">
					<div id="option1" style="margin-bottom: 3%">
						<a href="javascript:void(0)">-6 Nm2/C, 3 Nm2/C, 6 Nm2/C (Incorrect)</a>
					</div>
					<div id="option2" style="margin-bottom: 3%">
						<a href="javascript:void(0)">6 Nm2/C, 12 Nm2/C, 12 Nm2/C (Incorrect)</a>
					</div>
					<div id="option3" style="margin-bottom: 3%">
						<a href="javascript:void(0)">24 Nm2/C, 0 Nm2/C, -24 Nm2/C (Correct)</a>
					</div>
					<div id="option4" style="margin-bottom: 3%">
						<a href="javascript:void(0)">12 Nm2/C, 0 Nm2/C, -12 Nm2/C (Incorrect)</a>
					</div>
				</div>

		</div>

		<div id="arc_container" style="position: absolute; z-index: 1; left: 36.5%;">
		  <div class="arc_reactor">
		    <div class="case_container">
		      <div class="e7">
		        <div class="semi_arc_3 e5_1">
		          <div class="semi_arc_3 e5_2">
		            <div class="semi_arc_3 e5_3">
		              <div class="semi_arc_3 e5_4"></div>
		            </div>
		          </div>
		        </div>
		        <div class="core2"></div>
		      </div>
		      <ul class="marks">
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		        <li></li><li></li><li></li><li></li><li></li><li></li>
		      </ul>
		    </div>
		  </div>
		</div>


		<script>
			$('#questionPage').show();
			// $('#lecturePage').show();

			document.getElementById("option1").addEventListener("click", wrongFn);
			document.getElementById("option2").addEventListener("click", wrongFn);
			document.getElementById("option4").addEventListener("click", wrongFn);

			document.getElementById("option3").addEventListener("click", rightFn);

			function rightFn()
			{
				pJSDom[0].pJS.fn.modes.pushParticles(25);
				pJSDom[0].pJS.particles.line_linked.distance += 25;
			}

			function wrongFn()
			{
				pJSDom[0].pJS.particles.line_linked.distance *= 0.75;
			}
		</script>
	</body>
</html>