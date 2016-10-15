<html>
	<head>
		<title>Infinity Edu</title>

		<link rel="stylesheet" href="css/style.css"/>

		<script src="js/jquery.js"></script>
        <script src="js/jquery-ui.js"></script>
	</head>
	<body>
		<script>
			function parseGraphicsScript(str, canvas) {
				lines = str.split(';');

				variables = {};

				for (i = 0; i < lines.length; i++)
				{
					if (lines[i].length == 0)
						continue;

					tokens = lines[i].split(' ');
					usefulTokens = [];

					for (j = 0; j < tokens.length; j++)
					{
						if (tokens[j].length == 0)
							continue;

						if (usefulTokens[usefulTokens.length - 1] == 'circle')
							variables[tokens[j]] = {type: "circle", r: 30, x: 0, y: 0, vx: 0, vy: 0, ax: 0, ay: -0.001, ex: 0.99, ey: 0.5, fillStyle: "red"};
						else if (usefulTokens[usefulTokens.length - 1] == '=')
						{
							subTokens = usefulTokens[usefulTokens.length - 2].split('->');
							if (subTokens[1] == "fillStyle")
								variables[subTokens[0]][subTokens[1]] = tokens[j];
							else
								variables[subTokens[0]][subTokens[1]] = parseFloat(tokens[j]);
						}

						usefulTokens.push(tokens[j]);
					}
				}


				ctx = canvas.getContext("2d");

				SCREEN_WIDTH = canvas.width = 978;
		    	SCREEN_HEIGHT = canvas.height = 620;

				var t = 0;

			    var oldTime = new Date().getTime();

			    console.log(variables);

			    function redraw() {
			    	requestAnimationFrame(redraw);

			    	newTime = new Date().getTime();
					dt = newTime - oldTime;
					oldTime = newTime;

					ctx.fillStyle = "black";
					ctx.fillRect(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT);

					for (obj in variables) {
						if (variables[obj].type == 'circle')
						{
							// console.log(variables[obj].x + ' ' + variables[obj].y + ' ' + variables[obj].vy + ' ' + variables[obj].ay);
							ctx.fillStyle = variables[obj].fillStyle;

							ctx.beginPath();
							ctx.arc(SCREEN_WIDTH/2 + variables[obj].x, SCREEN_HEIGHT - variables[obj].y, variables[obj].r, 0, 2 * Math.PI, false);
							ctx.fill();
							ctx.closePath();

							//ctx.fillRect(variables[obj].x/2, variables[obj].y/2, 100, 100);

							variables[obj].x += dt * variables[obj].vx;
							variables[obj].y += dt * variables[obj].vy;

							variables[obj].vx += dt * variables[obj].ax;
							variables[obj].vy += dt * variables[obj].ay;

							variables[obj].vx *= variables[obj].ex;

							if (variables[obj].y < variables[obj].r)
							{
								if (Math.abs(variables[obj].vy) < 0.1) {
									variables[obj].y = variables[obj].r;
									variables[obj].vy = variables[obj].ay = 0;
								}
								else
								{
									variables[obj].y -= dt * variables[obj].vy;
									variables[obj].vy *= -variables[obj].ey;
								}
							}

							if (Math.abs(variables[obj].vx) < 0.005) {
								variables[obj].vx = 0;
							}

						}
					}


					t += dt / 10;
			    }

				redraw();
			}
		</script>

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

		<div id="lecturePage"  style="background-color: black; box-shadow: 0 0 15px 2px #1fc139,#1fc139 0 0 11px 3px inset; left: 56px; width: 70%; top: 112px; height: calc(100% - 168px); position: absolute; display: none; z-index: 0;">

			<p id="lectureContent" style="position: fixed; width: 978px; height: 620px; top: 102px; left: 66px; color: white; z-index: 3;">Now is the winter of our discontent
Made glorious summer by this sun of York;
And all the clouds that lour'd upon our house
In the deep bosom of the ocean buried.
Now are our brows bound with victorious wreaths;
Our bruised arms hung up for monuments;
Our stern alarums changed to merry meetings,
Our dreadful marches to delightful measures.
Grim-visaged war hath smooth'd his wrinkled front;
And now, instead of mounting barded steeds
To fright the souls of fearful adversaries,
He capers nimbly in a lady's chamber
To the lascivious pleasing of a lute.
But I, that am not shaped for sportive tricks,
Nor made to court an amorous looking-glass;
I, that am rudely stamp'd, and want love's majesty
To strut before a wanton ambling nymph;
I, that am curtail'd of this fair proportion,
Now is the winter of our discontent
Made glorious summer by this sun of York;
And all the clouds that lour'd upon our house
In the deep bosom of the ocean buried.
Now are our brows bound with victorious wreaths;
Our bruised arms hung up for monuments;
Our stern alarums changed to merry meetings,
Our dreadful marches to delightful measures.
Grim-visaged war hath smooth'd his wrinkled front;
And now, instead of mounting barded steeds
To fright the souls of fearful adversaries,
He capers nimbly in a lady's chamber
To the lascivious pleasing of a lute.
But I, that am not shaped for sportive tricks,
Nor made to court an amorous looking-glass;
I, that am rudely stamp'd, and want love's majesty
To strut before a wanton ambling nymph;
I, that am curtail'd of this fair proportion,
Now is the winter of our discontent
Made glorious summer by this sun of York;
And all the clouds that lour'd upon our house
In the deep bosom of the ocean buried.
Now are our brows bound with victorious wreaths;
Our bruised arms hung up for monuments;
Our stern alarums changed to merry meetings,
Our dreadful marches to delightful measures.
Grim-visaged war hath smooth'd his wrinkled front;
And now, instead of mounting barded steeds
To fright the souls of fearful adversaries,
He capers nimbly in a lady's chamber
To the lascivious pleasing of a lute.
</p>

			<canvas id="lectureCanvas" style="position: fixed; width: 978px; height: 620px; top: 122px; left: 66px; z-index: 2;"></canvas>

			<script>
				parseGraphicsScript('circle c; c->y = 300; c->ey = 0.6; circle c2; c2->x = -100; c2->y = 300; c2->ey = 0.3; c2->fillStyle = blue;', document.getElementById("lectureCanvas"));
				parseGraphicsScript('circle c3; c3->x = -490; c3->y = 30; c3->vx = 0.25; c3->vy = 0.6; c3->fillStyle = green; circle c4; c4->x = -490; c4->vx = 0.3; c4->y = 30; c4->vy = 0.8; c4->fillStyle = purple; ', document.getElementById("lectureCanvas"));
			</script>
		</div>

		<div id="questionPage" style="background-color: rgb(39, 40, 34); box-shadow: 0 0 15px 2px #1fc139,#1fc139 0 0 11px 3px inset; left: 56px; width: 70%; top: 112px; height: calc(100% - 168px); position: absolute; display: none; z-index: 0;">
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
			// $('#questionPage').show();
			$('#lecturePage').show();

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