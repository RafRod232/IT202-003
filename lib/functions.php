<?php
require_once(__DIR__ . "/db.php");
$BASE_PATH = '/Project/'; //This is going to be a helper for redirecting to our base project path since it's nested in another folder
function se($v, $k = null, $default = "", $isEcho = true)
{
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        //added 07-05-2021 to fix case where $k of $v isn't set
        //this is to kep htmlspecialchars happy
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        }
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}
//TODO 2: filter helpers
function sanitize_email($email = "")
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}
function is_valid_email($email = "")
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}
//TODO 3: User Helpers
function is_logged_in($redirect = false, $destination = "login.php")
{
    $isLoggedIn = isset($_SESSION["user"]);
    if ($redirect && !$isLoggedIn) {
        flash("You must be logged in to view this page", "warning");
        die(header("Location: $destination"));
    }
    return $isLoggedIn; //se($_SESSION, "user", false, false);
}
function has_role($role)
{
    if (is_logged_in() && isset($_SESSION["user"]["roles"])) {
        foreach ($_SESSION["user"]["roles"] as $r) {
            if ($r["name"] === $role) {
                return true;
            }
        }
    }
    return false;
}
function get_username()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "username", "", false);
    }
    return "";
}
function get_user_email()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "email", "", false);
    }
    return "";
}
function get_user_id()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "id", false, false);
    }
    return false;
}
//TODO 4: Flash Message Helpers
function flash($msg = "", $color = "info")
{
    $message = ["text" => $msg, "color" => $color];
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $message);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $message);
    }
}

function getMessages()
{
    if (isset($_SESSION['flash'])) {
        $flashes = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flashes;
    }
    return array();
}
//TODO generic helpers
function reset_session()
{
    session_unset();
    session_destroy();
}
function users_check_duplicate($errorInfo)
{
    if ($errorInfo[1] === 1062) {
        //https://www.php.net/manual/en/function.preg-match.php
        preg_match("/Users.(\w+)/", $errorInfo[2], $matches);
        if (isset($matches[1])) {
            flash("The chosen " . $matches[1] . " is not available.", "warning");
        } else {
            //TODO come up with a nice error message
            flash("<pre>" . var_export($errorInfo, true) . "</pre>");
        }
    } else {
        //TODO come up with a nice error message
        flash("<pre>" . var_export($errorInfo, true) . "</pre>");
    }
}
function get_url($dest)
{
    global $BASE_PATH;
    if (str_starts_with($dest, "/")) {
        //handle absolute path
        return $dest;
    }
    //handle relative path
    return $BASE_PATH . $dest;
}
function save_score($score, $user_id, $showFlash = false)
{
    if ($user_id < 1) {
        flash("Error saving score, you may not be logged in", "warning");
        return;
    }
    if ($score <= 0) {
        flash("Scores of zero are not recorded", "warning");
        return;
    }
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO GameScores (score, user_id) VALUES (:score, :uid)");
    try {
        $stmt->execute([":score" => $score, ":uid" => $user_id]);
        if ($showFlash) {
            flash("Saved score of $score", "success");
        }
    } catch (PDOException $e) {
        flash("Error saving score: " . var_export($e->errorInfo, true), "danger");
    }
}
function get_top_10($duration = "day")
{
    $d = "day";
    if (in_array($duration, ["day", "week", "month", "lifetime"])) {
        //variable is safe
        $d = $duration;
    }
    $db = getDB();
    $query = "SELECT user_id,score,username GameScores.created from GameScores join Users on GameScores.user_id = Users.id";
    if ($d !== "lifetime") {
        $query .= " WHERE GameScores.created >= DATE_SUB(NOW(), INTERVAL 1 $d)";
    }
    $query .= " ORDER BY score Desc, GameScores.created desc LIMIT 10"; 
    error_log($query);
    $stmt = $db->prepare($query);
    $results = [];
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log("Error fetching scores for $d: " . var_export($e->errorInfo, true));
    }
    return $results;
}

function get_best_score($user_id)
{
    $query = "SELECT score from GameScores WHERE user_id = :id ORDER BY score desc LIMIT 1";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":id" => $user_id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            return (int)se($r, "score", 0, false);
        }
    } catch (PDOException $e) {
        error_log("Error fetching best score for user $user_id: " . var_export($e->errorInfo, true));
    }
    return 0;
}

function get_latest_scores($user_id, $limit = 10)
{
    if ($limit < 1 || $limit > 50) {
        $limit = 10;
    }
    $query = "SELECT score, created from GameScores where user_id = :id ORDER BY created desc LIMIT :limit";
    $db = getDB();
    
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":id" => $user_id, ":limit" => $limit]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            return $r;
        }
    } catch (PDOException $e) {
        error_log("Error getting latest $limit scores for user $user_id: " . var_export($e->errorInfo, true));
    }
    return [];
}
function get_latest_points($user_id){
    $query = "SELECT points from Users where id = :id";
    $db = getDB();
    $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":id" => $user_id]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            return $r;
        }
    } catch (PDOException $e) {
        error_log("Error getting points for user $user_id: " . var_export($e->errorInfo, true));
    }
    return [];
}
function get_points(){
    if (is_logged_in()) { 
        return se($_SESSION["user"], "points", "0", false);
    }
    return "";
}
function update_points($user_id, $showFlash = false) 
{
    if ($user_id < 1) {
        // flash("Error adjusting points, you may not be logged in", "warning");
        return;
    }
    $db = getDB();
    $stmt = $db->prepare("UPDATE Users SET points = (SELECT IFNULL(SUM(point_change), 0) FROM PointsHistory P WHERE P.user_id = :uid) WHERE Users.id = :userid");
    try {
        $stmt->execute([":uid" => $user_id, "userid" => $user_id]);
        if ($showFlash) {
            flash("updated points", "success");
        }
    } catch (PDOException $e) {
        flash("Error updating points: " . var_export($e->errorInfo, true), "danger");
    }
    $db = getDB();
    $stmt = $db->prepare("SELECT points from Users where id = :uid");
    $stmt->execute([":uid"=>$user_id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["user"]["points"] = (int)se($r, "points", 0, false);
}
function adjust_points($points, $user_id, $reason, $showFlash = false) 
{
    if ($user_id < 1) {
        // flash("Error adjusting points, you may not be logged in", "warning");
        return;
    }
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO PointsHistory (user_id, point_change, reason) VALUES (:uid, :point_change, :reason)");
    try {
        $stmt->execute([":uid" => $user_id, "point_change" => $points, "reason" => $reason]);
        if ($showFlash) {
            flash("Adjust points by $points", "success");
        }
        return true;
    } catch (PDOException $e) {
        flash("Error adjusting points: " . var_export($e->errorInfo, true), "danger");
        return false;
    }
}
function update_participants($comp_id)
{
    $db = getDB();
    $stmt = $db->prepare("UPDATE Competitions set current_participants = (SELECT IFNULL(COUNT(1),0) FROM CompetitionParticipants WHERE competition_id = :cid),
    current_reward = IF(join_fee >= 0, current_reward + CEILING(join_fee * 0.5), current_reward) WHERE id = :compid");
    try {
        $stmt->execute([":cid" => $comp_id, ":compid" => $comp_id]);
        return true;
    } catch (PDOException $e) {
        error_log("Update competition participant error: " . var_export($e, true));
    }
    return false;
}
function add_to_competition($comp_id, $user_id)
{
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO CompetitionParticipants (user_id, competition_id) VALUES (:uid, :cid)");
    try {
        $stmt->execute([":uid" => $user_id, ":cid" => $comp_id]);
        update_participants($comp_id);
        return true;
    } catch (PDOException $e) {
        error_log("Join Competition error: " . var_export($e, true));
    }
    return true;
}
function save_data($table, $data, $ignore = ["submit"])
{
    $table = se($table, null, null, false);
    $db = getDB();
    $query = "INSERT INTO $table "; //be sure you trust $table
    //https://www.php.net/manual/en/functions.anonymous.php Example#3
    $columns = array_filter(array_keys($data), function ($x) use ($ignore) {
        return !in_array($x, $ignore); // $x !== "submit";
    });
    //arrow function uses fn and doesn't have return or { }
    //https://www.php.net/manual/en/functions.arrow.php
    $placeholders = array_map(fn ($x) => ":$x", $columns);
    $query .= "(" . join(",", $columns) . ") VALUES (" . join(",", $placeholders) . ")";

    $params = [];
    foreach ($columns as $col) {
        $params[":$col"] = $data[$col];
    }
    $stmt = $db->prepare($query);
    try {
        $stmt->execute($params);
        //https://www.php.net/manual/en/pdo.lastinsertid.php
        //echo "Successfully added new record with id " . $db->lastInsertId();
        return $db->lastInsertId();
    } catch (PDOException $e) {
        //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        flash("<pre>" . var_export($e->errorInfo, true) . "</pre>");
        return -1;
    }
}
function get_user_id_from_comp($comp_id){//This should return all user ids in the comp and if userid from join competition is already in this array then it should return already in competition
    $query = "SELECT user_id from CompetitionParticipants where competition_id = :comp_id";
    $db = getDB();
    $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":comp_id" => $comp_id]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            return $r;
            //return false;
        }
    } catch (PDOException $e) {
        error_log("Error getting user_if for competition $comp_id: " . var_export($e->errorInfo, true));
    }
    return [];
    //return false; 
}
function join_competition($comp_id, $user_id, $cost)
{
    $points = get_points();
    echo($points);
    if ($comp_id > 0) {
        if ($points >= $cost) {
            $db = getDB();
            $stmt = $db->prepare("SELECT title, join_fee from Competitions where id = :id");
            try {
                $stmt->execute([":id" => $comp_id]);
                $r = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($r) {
                    $cost = (int)se($r, "join_fee", 0, false);
                    $name = se($r, "title", "", false);
                    echo($cost);    
                    echo($points);
                    if ($points >= $cost) {
                        if (adjust_points($cost*-1, get_user_id(), "Join Competition" . $comp_id)) {
                            if (add_to_competition($comp_id, $user_id)) {
                                flash("Successfully joined $name", "success");
                                update_points($user_id);
                                return true;
                            }
                        } else {
                            flash("Failed to pay for competition", "danger");
                            return false;
                        }
                    } else {
                        flash("You can't afford to join this competition", "warning");
                        return false;

                    }
                }
            } catch (PDOException $e) {
                error_log("Comp lookup error " . var_export($e, true));
                flash("There was an error looking up the competition", "danger");
                return false;
            }
        } else {
            flash("You can't afford to join this competition", "warning");
            return false;
        }
    } else {
        flash("Invalid competition, please try again", "danger");
        return false;
    }
}
function get_latest_10_comp()
{
    $db = getDB();
    $query = "SELECT id, title, duration, expires, current_reward, starting_reward, join_fee, current_participants, min_participants, min_score, first_place_per, second_place_per, third_place_per from Competitions";
    $query .= " WHERE paid_out = 0 ORDER BY expires ASC LIMIT 10";

    error_log($query);
    $stmt = $db->prepare($query);
    $results = [];
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log("Error fetching competitions: " . var_export($e->errorInfo, true));
    }
    return $results;
}
//for last bullet and option 1 betwwen created and expired timestamps
function elog($data)
{
    echo "<br>" . var_export($data, true) . "<br>";
    error_log(var_export($data, true));
}
 function get_top_scores_for_comp($comp_id, $limit = 10)
{
    $db = getDB();
    //below if a user can win more than one place
    $stmt = $db->prepare(
        "SELECT score, s.created, u.id as user_id,u.username as username FROM GameScores s 
    JOIN CompetitionParticipants pc on pc.user_id = s.user_id 
    JOIN Competitions c on c.id = pc.competition_id
    JOIN Users u on u.id = s.user_id WHERE c.id = :cid AND s.score >= c.min_score AND s.created 
    BETWEEN c.created AND c.expires ORDER BY s.score desc LIMIT :limit"
    );
    $scores = [];
    try {
        $stmt->bindValue(":cid", $comp_id, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $scores = $r;
        }
    } catch (PDOException $e) {
        flash("There was a problem fetching scores, please try again later", "danger");
        error_log("List competition scores error: " . var_export($e, true));
    }
    return $scores;
}
function calc_winners()
{
    $db = getDB();
    elog("Starting winner calc");
    $calced_comps = [];
    $stmt = $db->prepare("select c.id,c.title, first_place_per, second_place_per, third_place_per, current_reward 
    from Competitions c where expires <= CURRENT_TIMESTAMP() AND paid_out = 0 AND current_participants >= min_participants LIMIT 10"); // gets expired scores frm expired comps
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $rc = $stmt->rowCount();
            elog("Validating $rc comps");
            foreach ($r as $row) {
                $fp = floatval(se($row, "first_place_per", 0, false) / 100);
                $sp = floatval(se($row, "second_place_per", 0, false) / 100);
                $tp = floatval(se($row, "third_place_per", 0, false) / 100);
                $reward = (int)se($row, "current_reward", 0, false);
                $title = se($row, "title", "-", false);
                $fpr = ceil($reward * $fp);
                $spr = ceil($reward * $sp);
                $tpr = ceil($reward * $tp);
                $comp_id = se($row, "id", -1, false);
                
                try {
                    $r = get_top_scores_for_comp($comp_id, 3);
                    if ($r) {
                        $atleastOne = false;
                        foreach ($r as $index => $row) {
                            $score = se($row, "score", 0, false);
                            $user_id = se($row, "user_id", -1, false);
                            if ($index == 0) {
                                if (adjust_points($fpr, "won-comp", $user_id, "First place in $title with score of $score")) {
                                    $atleastOne = true;
                                    update_points($user_id);
                                }
                                elog("User $user_id First place in $title with score of $score");
                            } else if ($index == 1) {
                                if (adjust_points($spr, "won-comp", $user_id, "Second place in $title with score of $score")) {
                                    $atleastOne = true;
                                    update_points($user_id);

                                }
                                elog("User $user_id Second place in $title with score of $score");
                            } else if ($index == 1) {
                                if (adjust_points($tpr, "won-comp", $user_id, "Third place in $title with score of $score")) {
                                    $atleastOne = true;
                                    update_points($user_id);

                                }
                                elog("User $user_id Third place in $title with score of $score");
                            }
                        }
                        if ($atleastOne) {
                            array_push($calced_comps, $comp_id);
                        }
                    } else {
                        elog("No eligible scores");
                    }
                } catch (PDOException $e) {
                    error_log("Getting winners error: " . var_export($e, true));
                }
            }
        } else {
            elog("No competitions ready");
        }
    } catch (PDOException $e) {
        error_log("Getting Expired Comps error: " . var_export($e, true));
    }
    //closing calced comps
    if (count($calced_comps) > 0) {
        $query = "UPDATE Competitions set paid_out = 1 WHERE id in ";
        $query = "(" . str_repeat("?,", count($calced_comps) - 1) . "?)";
        elog("Close query: $query");
        $stmt = $db->prepare($query);
        try {
            $stmt->execute($calced_comps);
            $updated = $stmt->rowCount();
            elog("Marked $updated comps complete and calced");
        } catch (PDOException $e) {
            error_log("Closing valid comps error: " . var_export($e, true));
        }
    } else {
        elog("No competitions to calc");
    }
    //close invalid comps
    $stmt = $db->prepare("UPDATE Competitions set paid_out = 1 WHERE expires <= CURRENT_TIMESTAMP() AND current_participants < min_participants AND paid_out = 0");
    try {
        $stmt->execute();
        $rows = $stmt->rowCount();
        elog("Closed $rows invalid competitions");
    } catch (PDOException $e) {
        error_log("Closing invalid comps error: " . var_export($e, true));
    }
    elog("Done calc winners");
} 
function paginate($query, $params = [], $per_page = 10)
{
    global $page; //will be available after function is called
    try {
        $page = (int)se($_GET, "page", 1, false);
    } catch (Exception $e) {
        //safety for if page is received as not a number
        $page = 1;
    }
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("paginate error: " . var_export($e, true));
    }
    $total = 0;
    if (isset($result)) {
        $total = (int)se($result, "total", 0, false);
    }
    global $total_pages; //will be available after function is called
    $total_pages = ceil($total / $per_page);
    global $offset; //will be available after function is called
    $offset = ($page - 1) * $per_page;
}
function persistQueryString($page)
{
    $_GET["page"] = $page;
    return http_build_query($_GET);
}
function redirect($path)
{ //header headache
    //https://www.php.net/manual/en/function.headers-sent.php#90160
    /*headers are sent at the end of script execution otherwise they are sent when the buffer reaches it's limit and emptied */
    if (!headers_sent()) {
        //php redirect
        die(header("Location: " . get_url($path)));
    }
    //javascript redirect
    echo "<script>window.location.href='" . get_url($path) . "';</script>";
    //metadata redirect (runs if javascript is disabled)
    echo "<noscript><meta http-equiv=\"refresh\" content=\"0;url=" . get_url($path) . "\"/></noscript>";
    die();
}