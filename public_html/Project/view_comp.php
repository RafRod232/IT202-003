<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
$db = getDB();
    $id = se($_GET, "id", -1, false);
    if ($id < 1) {
        flash("Invalid competition", "danger");
        redirect("list_competitions.php");
    }
	$comp = '';
    $scores = get_top_scores_for_comp($id);
?>
<div class="card bg-dark">
    <div class="card-body">
        <div class="card-title">
            <div class="fw-bold fs-3">
                <?php se("View Competition:"); ?>
            </div>
        </div>
        <div class="card-text">
	    <?php $title = $comp . " Top Scores";

    include(__DIR__ . "/../../partials/scoretable.php");
    ?>
        </div>
    </div>
</div>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>