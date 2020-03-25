<?php
    include_once "./google/firestore/index.php";
    if(array_search($_GET["type"], ["programme", "course"]) > -1){
        $doc = $_POST["key"];
        $col = $_GET["type"];
        $data = $_POST;
        
        if(isset($data["delete"]))unset($data["delete"]);
        if(isset($data["save"]))unset($data["save"]);
        if(isset($data["key"]))unset($data["key"]);
        if(isset($data["programme"]) && $_GET["type"] == "course"){
            $data["programme"] = $GFirestore->getDocumentReference("programme", $data["programme"]);
        }
        $GFirestore->updateColDocument($col, $doc, $data);
    }
    header("location:index.php");
?>