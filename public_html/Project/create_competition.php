<?php
require_once(__DIR__ . "/../../partials/nav.php");
?>
<div class="container-fluid">
    <h1>Create Competition</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input id="title" name="title" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="reward" class="form-label">Starting Reward</label>
            <input id="reward" type="number" name="starting_reward" class="form-control" onchange="updateCost()" placeholder=">= 1" min="1" />
        </div>
        <div class="mb-3">
            <label for="ms" class="form-label">Min. Score - Score to be placed into  Leaderboard</label>
            <input id="ms" name="min_score" type="number" class="form-control" placeholder=">= 1" min="1" />
        </div>
        <div class="mb-3">
            <label for="mp" class="form-label">Min. Participants</label>
            <input id="mp" name="min_participants" type="number" class="form-control" placeholder=">= 3" min="3" />
        </div>
        <div class="mb-3">
            <label for="jf" class="form-label">Join Cost</label>
            <input id="jf" name="join_fee" type="number" class="form-control" onchange="updateCost()" placeholder=">= 0" min="0" />
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (in Days)</label>
            <input id="duration" name="duration" type="number" class="form-control" placeholder=">= 3" min="3" />
        </div>
        <div class="mb-3">
            <label for="p1" class="form-label">Percent for First Place Winning</label>
            <input id="p1" name="first_place_per"  type ="number"class="form-control" placeholder="Enter percent of the winnings for first place **All Percents must add to 100**" />
        </div>
        <div class="mb-3">
            <label for="p2" class="form-label">Percent for Second Place Winning</label>
            <input id="p2" name="second_place_per" type ="number" class="form-control" placeholder="Enter percent of the winnings for second place **All Percents must add to 100**" />
        </div>
        <div class="mb-3">
            <label for="p3" class="form-label">Percent for Third Place Winning</label>
            <input id="p3" name="third_place_per" type ="number" class="form-control" placeholder="Enter percent of the winnings for thrid place **All Percents must add to 100**" />
        </div>
        <div class="mb-3">
            <input type="submit" value="Create Competition (Cost: 2)" class="btn btn-primary" />
        </div>
    </form>
    <script>
        function validate(form) {
            let first_r = parseInt(form.first_place_per.value);
            let second_r = parseInt(form.second_place_per.value);
            let third_r = parseInt(form.third_place_per.value);

            console.log(first_r+second_r+third_r);

            let flashEle = document.getElementById("flash");
            flashEle.innerHTML="";
            let isValid = true;

            if (first_r + second_r + third_r != 100) {
                flash("Reward cuts must add up to 100", "warning");
                isValid = false;
            }

            return isValid;
        }
    </script>
    <script>
        function updateCost() {
            let starting = parseInt(document.getElementById("reward").value || 0) + 1;
            let join = parseInt(document.getElementById("jf").value || 0);
            if (join < 0) {
                join = 1;
            }
            let cost = starting + join;
            document.querySelector("[type=submit]").value = `Create Competition (Cost: ${cost})`;
        }
    </script>
</div>
<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
$db = getDB();
if (isset($_POST["title"]) && !empty($_POST["title"])) {
    $cost = (int)se($_POST, "starting_reward", 0, false);
    $cost++;
    $cost += (int)se($_POST, "join_fee", 0, false);
    $title = se($_POST, "title", "N/A", false);
    $points = get_points();
    if ($points >= $cost) {
        $db->beginTransaction();
        if (adjust_points($cost*-1, get_user_id(), "Created Competition $title")) {
            $_POST["creator_id"] = get_user_id();
            $comp_id = save_data("Competitions", $_POST);
            $user_id = get_user_id();
            if ($comp_id > 0) {
                if (add_to_competition($comp_id, get_user_id())) {
                    flash("Successfully created your competition", "success");
                    update_points($user_id);
                    $db->commit();
                } else {
                    $db->rollback();
                }
            } else {
                $db->rollback();
            }
        } else {
            flash("There was a problem deducting points", "warning");
            $db->rollback();
        }
    } else {
        flash("You can't afford this right now, play the game more", "warning");
    }
}
?>   
<?php
require(__DIR__ . "/../../partials/flash.php");
?>