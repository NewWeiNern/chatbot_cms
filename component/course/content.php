
<?php 
    include_once "./google/firestore/index.php";
    foreach($GFirestore->getCollections("course") as $document):
?>
    <div class="content" data-id="<?=$document->id();?>">
        <h2><?=$document->id();?></h2>
        <?php foreach($document->data() as $key=>$data):?>
            <div class="topic">
                <h5><?=$key; ?></h5>
                <div><?= join(", ",$data["tag"]);?></div>
            </div>
        <?php endforeach;?>
    </div>
<?php
    endforeach;
?>