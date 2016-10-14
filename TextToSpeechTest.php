

<script src='responsivevoice.js'></script>
<script type="text/javascript">

var lines = ["Speech Started.", "We don't talk anymore...", "We don't talk anymore?", "Like we used to do!!", "Why does a recognizable novice gasp?", "The releasing military conforms above the industry.", "A hysterical mud punts.", "Will the connecting script involve the cosmic procedure?", "Why won't the handbook chop the guy?", "Before the revised scarf hunts the immortal employee.", "The End"];

var i = 0;
var isPause = false;
function pause() {
    if (isPause == true) {
        responsiveVoice.resume();
        isPause = false;
    } else if (responsiveVoice.isPlaying()) {
        responsiveVoice.pause();
        isPause = true;
    }
}

function voiceStartCallback() {
    document.getElementById('subtitle').innerHTML = lines[i++];
}
 
function voiceEndCallback() {
	if (i < lines.length)
    	speak();
}

var parameters = {
    onstart: voiceStartCallback,
    onend: voiceEndCallback,
    rate: 1.0
}

var line1 = "Why does a recognizable novice gasp? The releasing military conforms above the industry. A hysterical mud punts. Will the connecting script involve the cosmic procedure? Why won't the handbook chop the guy? Before the revised scarf hunts the immortal employee.";

function speak() {

	responsiveVoice.speak(lines[i], "US English Female", parameters);
}

</script>
<input onclick='speak();' type='button' value='Play' />

<input id='pause' onclick='pause();' type='button' value='Pause' />

<p id="subtitle">Hello World!</p>
