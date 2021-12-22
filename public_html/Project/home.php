<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<h1>Home</h1>
<?php
if (is_logged_in()) {
    $game_link = get_url("game.php");
    echo "Welcome home, " . get_username();
    echo "<br>";
    print "<a href='$game_link'>Feel free to play the game to earn points and enter competitions</a>";
    echo "<br>";
    echo "Compete and compare scores with your friends";
    //comment this out if you don't want to see the session variables
    //echo "<pre>" . var_export($_SESSION, true) . "</pre>";
    

} else {
    echo "You're not logged in";
}
?>
<?php 
        $duration = "week";      
        include(__DIR__ . "/../../partials/scoretable.php");
        $duration = "month";
        include(__DIR__ . "/../../partials/scoretable.php");
        $duration = "lifetime";    
        include(__DIR__ . "/../../partials/scoretable.php");
?>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>