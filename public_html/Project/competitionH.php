<?php
require_once(__DIR__ . "/../../partials/nav.php");
//is_logged_in(true);
$user_id = se($_GET, "id", get_user_id(), false);
$isMe = $user_id===get_user_id();
$edit = !!se($_GET, "edit", false, false); 
if ($user_id < 1) {
    flash("Invalid user", "danger");
    redirect("home.php");
}

?>
<div class="container-fluid">
<h1>Competition History</h1>
    <div>
        Best Score: <?php echo get_best_score($user_id); ?>
    </div>
    <div>
        <?php $per_page = 10;
$total_query = "SELECT count(1) as total from Competitions";
$params = [];
paginate($total_query,$params,$per_page);
$query = "SELECT title,expires from Competitions c JOIN CompetitionParticipants cp on c.id=cp.competition_id ";
$query .= " WHERE cp.user_id=$user_id LIMIT $offset, 10";
$stmt = $db->prepare($query); 
$comps=[];
try {
    $stmt->execute(); 
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $comps = $r;
    }
} catch (PDOException $e) {
    flash("No Competitions Joined" . var_export($e, true) . "</pre>");
} ?>
        <?php $points = get_latest_points($user_id); ?> 
        <h3>Competition History</h3>
        <table class="table text-light">
            <thead>
                <th>Competition Title</th>
                <th>Expires</th>
            </thead>
            <tbody>
                <?php foreach ($comps as $comp) : ?>
                    <tr>
                        <td><?php se($comp, "title", 0); ?></td>
                        <td><?php se($comp, "expires", "-"); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php include(__DIR__ . "/../../partials/pagination.php"); ?>
    </div> 
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>