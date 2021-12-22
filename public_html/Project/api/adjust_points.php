<?php
require_once(__DIR__ . "/../../../lib/functions.php");
session_start();
$user_id = get_user_id();
if($user_id<=0){
    flash("Must be logged in to save points");
}
else
$points = $_POST['points'];
$reason = $_POST['reason'];
adjust_points($points, $user_id, $reason);
update_points($user_id);
?>