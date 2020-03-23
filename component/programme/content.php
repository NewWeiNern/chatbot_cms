    <?php 
        include_once "./google/firestore/index.php";
        foreach( $GFirestore->getCollections("programme") as $document):
    ?>
    <div class="content" data-id="<?=$document->id();?>">
        <h2 class="name"><input type="text" name="full_name" value="<?=$document["full_name"]; ?>"/></h2>
        <h4>Duration: <span class="duration"><input type="text" name="duration" value="<?=$document["duration"]; ?>"/></span></h4>
        <h4>Description: <br><span class="description"><input type="text" name="description" value="<?=$document["description"];?>"/></span></h4>
        <input type="button" value="save" onclick="saveDocument.call(this, 'programme')"/>
    </div>
    <?php endforeach;?>