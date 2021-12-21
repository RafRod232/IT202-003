<?php
require_once(__DIR__ . "/../lib/functions.php");
$db = getDB();
$results = get_latest_10_comp();
if (isset($_POST["join"])) {
    $user_id = get_user_id();
    $comp_id = se($_POST, "competition_id", 0, false);
    $cost = se($_POST, "join_fee", 0, false);
    if (join_competition($comp_id, $user_id, $cost)) {
        update_participants($comp_id);
    }
}
$per_page = 10;
$total_query = "SELECT count(1) as total from Competitions where paid_out<1";
$params = [];
paginate($total_query,$params,$per_page);
$query = "SELECT id,title,duration,expires,current_reward,starting_reward,join_fee,current_participants, min_participants, paid_out, min_score, first_place_per, second_place_per, third_place_per from Competitions";
$query .= " WHERE paid_out = 0 ORDER BY expires Asc LIMIT $offset, 10";
$stmt = $db->prepare($query); 
$results=[];
try {
    $stmt->execute(); 
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
} catch (PDOException $e) {
    flash("Error getting Competitions" . var_export($e, true) . "</pre>");
}
$participants = [];
foreach ($results as $result) {
    $comp_id = $result["id"];
    $participants[$comp_id] = get_user_id_from_comp($comp_id);
}
foreach ($participants as $comp_id => $key) {
    $compsAndParticipants[$comp_id] = [];
}
foreach ($participants as $comp_id => $key) {
    foreach ($participants[$comp_id] as $user_id) {
        foreach ($user_id as $uid) {
            array_push($compsAndParticipants[$comp_id], $uid);
        }
    }
} 
?>
<div class="card bg-dark">
    <div class="card-body">
        <div class="card-title">
            <div class="fw-bold fs-3">
                <?php se("Competitions"); ?>
            </div>
        </div>
        <div class="card-text">
            <table class="table text-light">
                <thead>
                <th>Title</th>
                <th>Participants</th>
                <th>Reward (Points)</th>
                <th>Min Score</th>
                <th>Expires</th>
                <th>Actions</th>
                </thead>
                <tbody>
                    <?php if (!$results || count($results) == 0) : ?>
                        <tr>
                            <td colspan="100%">No scores available</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($results as $result) : ?>
                            <tr>
                                <td>
                                    <!--<a href="profile.php?id=<?php se($result, 'user_id'); ?>"><?php se($result, "username"); ?></a>-->
                                    <?php se($result, "title"); ?>
                                </td>
                                <td><?php se($result, "current_participants"); ?></td>
                                <td><?php se($result, "current_reward") ?></td>
                                <td><?php se($result, "min_score"); ?></td>
                                <td><?php se($result, "expires"); ?></td>
                                <td>
                                <?php if (in_array(get_user_id(), $compsAndParticipants[$result["id"]])) : ?>
                                        <button class="btn btn-primary disabled" onclick="event.preventDefault()" disabled>Already Joined</button>
                                            
                                    <?php else : ?>
                                        <form method="POST">
                                            <input type="hidden" name="competition_id" value="<?php se($result, 'id'); ?>" />
                                            <input type="hidden" name="cost" value="<?php se($result, 'join_fee', 0); ?>" />
                                            <input type="submit" name="join" class="btn btn-light" value="Join (Cost: <?php se($result, "join_fee", 0) ?>)" />
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php include(__DIR__ . "/pagination.php"); ?>
        </div>
    </div>
</div>
