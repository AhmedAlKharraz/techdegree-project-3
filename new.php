<?php 

include('inc/header.php');
require('inc/functions.php');
include("inc/connection.php");

//To set back the submitted variable when it didn't meet the requirement. 
$title = $date = $time_spent = $learned = $resources = $tags = '';

//to check if the request is post
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT));
    $time_spent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
    $tags = trim(filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING));

    $dateMatch = explode('-', $date);

    if(empty($title) || empty($date) || empty($time_spent) || empty($learned)){
        $error_message = "Please fill all required fields";
    } elseif (count($dateMatch) != 3 || strlen($dateMatch[0]) != 4 || strlen($dateMatch[1]) != 2 || strlen($dateMatch[2]) != 2 || !checkdate($dateMatch[2], $dateMatch[1], $dateMatch[0])){
        $error_message = "Invalid Date";
    } else {
        if(add_journal($title, $date, $time_spent, $learned, $resources, $tags)){
            header("Location: index.php");
            exit;
        } else{
            $error_message = "could not add journal";
        }
    }
}
?>

<section>
    <div class="container">
        <div class="new-entry">
            <h2>New Entry</h2>
            <?php /* to display error message */ if(isset($error_message)){ echo "<p class='error-msg'>".$error_message."</p><br>\n"; } ?>
            <form method="POST">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"><br>
                <label for="date">Date</label>
                <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" placeholder="yyyy-mm-dd"><br>
                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="timeSpent" value="<?php echo htmlspecialchars($time_spent); ?>"><br>
                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo htmlspecialchars($learned); ?></textarea>
                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"><?php echo htmlspecialchars($resources); ?></textarea>
                <label for="tags">Tags</label>
                <input id="tags" type="text" name="tags" value="<?php echo htmlspecialchars($tags); ?>"><br>
                <input type="submit" value="Publish Entry" class="button">
                <a href="<?php echo 'index.php'; ?>" class="button button-secondary">Cancel</a>
            </form>
        </div>
    </div>
 </section>

<?php 
include('inc/footer.php');



?>
        