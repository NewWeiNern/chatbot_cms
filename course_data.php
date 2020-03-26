<?php
    include_once "./google/firestore/index.php";
    $doc = $GFirestore->getDocumentReference("programme", $_GET["data"]);
    
    if($doc->snapshot()->exists()){
        $data = $GFirestore->getAllDataWhereRef("course", "programme", "=", $doc);
        for($i = 0; $i < count($data); $i++){
            $data[$i]["programme"] = $_GET["data"];
        }
        echo json_encode($data);
        header("Content-Type: application/json");
    }
    else{
        echo json_encode(["error"=>"path not found!"]);
    }
?>