<?php
include("inc/connection.php");
include("inc/header.php");
include("inc/functions.php");

//if there is id in the link, we will pass the id to details_journal to retrive the data we want.
if(isset($_GET["id"])){
    $journal_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $item = details_journal($journal_id);
}

//var_dump(details_journal($_GET["id"]));

?>
<section>
    <div class="container">
        <div class="entry-list single">
            <article>
                <h1><?php echo $item["title"];?></h1>
                <time datetime="<?php echo $item["date"]; ?>"><?php echo date('F d, Y', strtotime($item["date"]));?></time>
                <div class="entry">
                    <h3>Time Spent: </h3>
                    <p><?php echo $item["time_spent"];?></p>
                </div>
                <div class="entry">
                    <h3>What I Learned:</h3>
                    <p><?php echo $item["learned"];?></p>
                </div>
                <div class="entry">
                    <h3>Resources to Remember:</h3>
                    <ul><?php
                        if($item["resources"] == null){
                            echo "No resources available";
                        }else{
                            //I split string(resource) by the comma and list it in each <li> in the forach loop
                            $resources = explode(",", $item["resources"]);
                            foreach($resources as $resource){
                                echo "<li><a href=''>".$resource."</a></li>";
                            }
                        }
                    ?></ul>
                </div>
                <div class="entry">
                    <h3>Tags:</h3>
                    <ul id='tags'><?php
                        if($item["tags"] == null){
                            echo "No Tags available";
                        }else{
                            //I split string(tags) by the comma and list it in each <li> in the forach loop
                            $tags = explode(",", $item["tags"]);
                            foreach($tags as $tag){
                                echo "<li><a href=''>".trim($tag)."</a></li>";
                            }
                        }
                    ?></ul>
                </div>
            </article>
        </div>
    </div>
    <div class="edit"><?php
        //To get the id of journal so I can edit it
        echo "<p><a href='edit.php?id=".$item["id"]."'>Edit Entry</a></p>";
    ?></div>
</section>

<?php
include("inc/footer.php");
?>