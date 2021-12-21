<?php
require_once(__DIR__."/../../../lib/functions.php");
session_start();
$user_id=get_user_id();
if($user_id<=0){
    error_log("User not logged in");
    http_response_code(403);
    $respone["message"]="You must be logged in to save your score";
    flash($respone["message"],"warning");
}
else
$score = $_POST['score'];
save_score($score,$user_id, true);
?>