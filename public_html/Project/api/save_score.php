<?php
require_once(__DIR__."/../../../lib/functions.php");
session_start();
$user_id=get_user_id();
$score = $_POST['score'];
save_score($score,$user_id, true);
?>