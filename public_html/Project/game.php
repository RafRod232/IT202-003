<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<canvas id="canvas" width="600" height="400" tabindex="1"></canvas>

<script>
// Get a reference to the canvas DOM element
var canvas = document.getElementById('canvas');
// Get the canvas drawing context
var context = canvas.getContext('2d');
var background = new Image();
background.src = "graveyard_background.jpg";
background.onload = function(){
  context.drawImage(background,0,0);
  context.font = '36px Arial';
  context.fillStyle ='#E1E1E1';
  context.textAlign = 'center';
  context.fillText('Attack The Zombies', canvas.width / 2, canvas.height / 4);
  context.font = '24px Arial';
  context.fillText('Click to Start', canvas.width / 2, canvas.height / 2);
  context.font = '18px Arial'
  context.fillText('Use the arrow keys to move', canvas.width / 2, (canvas.height / 4) * 3);
  // Start the game on a click
  canvas.addEventListener('click', startGame);

}
// Your score
var score = 0;
var points = 0;
var reason = "Played game";
// Properties for your square
var x = 50; // X position
var y = 100; // Y position
var speed = 6; // Distance to move each frame
var sideLength = 50; // Length of each side of the square

// FLags to track which keys are pressed
var down = false;
var up = false;
var right = false;
var left = false;

// Properties for the target square
var targetX = 0;
var targetY = 0;
var targetLength = 25;

// Determine if number a is within the range b to c (exclusive)
function isWithin(a, b, c) {
  return (a > b && a < c);
}

// Countdown timer (in seconds)
var countdown = 30;
// ID to track the setTimeout
var id = null;

// Listen for keydown events
canvas.addEventListener('keydown', function(event) {
  event.preventDefault();
  console.log(event.key, event.keyCode);
  if (event.keyCode === 40) { // DOWN
    down = true;
  }
  if (event.keyCode === 38) { // UP
    up = true;
  }
  if (event.keyCode === 37) { // LEFT
    left = true;
  }
  if (event.keyCode === 39) { // RIGHT
    right = true;
  }
});

// Listen for keyup events
canvas.addEventListener('keyup', function(event) {
  event.preventDefault();
  console.log(event.key, event.keyCode);
  if (event.keyCode === 40) { // DOWN
    down = false;
  }
  if (event.keyCode === 38) { // UP
    up = false;
  }
  if (event.keyCode === 37) { // LEFT
    left = false;
  }
  if (event.keyCode === 39) { // RIGHT
    right = false;
  }
});

// Show the start menu
function menu() {
  erase();
  context.drawImage(background,0,0);
  context.fillStyle = '#E1E1E1';
  context.font = '36px Arial';
  context.textAlign = 'center';
  context.fillText('Attack The Zombies', canvas.width / 2, canvas.height / 4);
  context.font = '24px Arial';
  context.fillText('Click to Start', canvas.width / 2, canvas.height / 2);
  context.font = '18px Arial'
  context.fillText('Use the arrow keys to move', canvas.width / 2, (canvas.height / 4) * 3);
  // Start the game on a click
  canvas.addEventListener('click', startGame);
}

// Start the game
function startGame() {
	// Reduce the countdown timer ever second
  id = setInterval(function() {
    countdown--;
  }, 1000)
  // Stop listening for click events
  canvas.removeEventListener('click', startGame);
  // Put the target at a random starting point
	moveTarget();
  // Kick off the draw loop
  draw();
}

// Show the game over screen
function endGame() {
	// Stop the countdown
  clearInterval(id);
  // Display the final score
  erase();
  sendscore();
  if(points>0){
    sendpoints();
  }
  var background = new Image();
background.src = "graveyard_background.jpg";
context.drawImage(background,0,0);
  
  context.fillStyle = '#E1E1E1';
  context.font = '24px Arial';
  context.textAlign = 'center';
  context.fillText('Final Score: ' + score, canvas.width / 2, canvas.height / 4);
  context.fillText('Points Earned: ' + points, canvas.width / 2, canvas.height / 2);
}

// Move the target square to a random position
function moveTarget() {
  targetX = Math.round(Math.random() * canvas.width - targetLength);
  targetY = Math.round(Math.random() * canvas.height - targetLength)
}

// Clear the canvas
function erase() {
  context.fillStyle = '#FFFFFF';
  context.fillRect(0, 0, 600, 400);
}

// The main draw loop
function draw() {
  erase();
var background = new Image();
background.src = "graveyard_background.jpg";
context.drawImage(background,0,0);

  // Move the square
  if (down) {
    y += speed;
  }
  if (up) {
    y -= speed;
  }
  if (right) {
    x += speed;
  }
  if (left) {
    x -= speed;
  }
  // Keep the square within the bounds
  if (y + sideLength > canvas.height) {
    y = canvas.height - sideLength;
  }
  if (y < 0) {
    y = 0;
  }
  if (x < 0) {
    x = 0;
  }
  if (x + sideLength > canvas.width) {
    x = canvas.width - sideLength;
  }
  // Collide with the target
  if (isWithin(targetX, x, x + sideLength) || isWithin(targetX + targetLength, x, x + sideLength)) { // X
    if (isWithin(targetY, y, y + sideLength) || isWithin(targetY + targetLength, y, y + sideLength)) { // Y
      // Respawn the target
      moveTarget();
      // Increase the score
      score++;
      //Double score in final seconds
      if(countdown<=5){
        score++;
      }
      if(score%4==0){
        points++;
      }
    }
  }
  // Draw the square
  context.fillStyle = '#CD853F';
  context.fillRect(x, y, sideLength, sideLength);
  // Draw the target 
  context.fillStyle = '#292E5C'; //making color to try to blend in and distract the user and delay from finding square
  context.fillRect(targetX, targetY, targetLength, targetLength);
  // Draw the score and time remaining
  context.fillStyle = '#000000';
  context.font = '24px Arial';
  context.textAlign = 'left';
  context.fillText('Score: ' + score, 10, 24);
  context.fillText('Points: ' + points, 200,24);
  context.fillText('Time Remaining: ' + countdown, 10, 50);
  // End the game or keep playing
  if (countdown <= 0) {
    endGame();
  } else {
    window.requestAnimationFrame(draw);
  }
}
function sendscore(){
  const http = new XMLHttpRequest();
  http.onload = function() {
    flash("Score has been sent if logged in", "warning");
  }
  http.open("POST","api/save_score.php", true);
  http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  http.send(`score=${score}`);
}
function sendpoints(){
  const http = new XMLHttpRequest();
  http.onload = function() {
    flash("Points have been sent if logged in", "warning");
  }
  http.open("POST","api/adjust_points.php", true);
  http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  http.send(`points=${points}&reason=${reason}`);
}
// Start the game
menu();
canvas.focus();
</script>
<body>
<p>Defeat As Many Zombies as Possible
  <br>
Final 5 Seconds Earn You Double Points</p>
</body>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>