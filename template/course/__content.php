<?php
    include_once "./template/index.php";
    
    $data = new Template();
    $doc = $GFirestore->getDocumentReference("programme", "nsa");
    $data_programme = $GFirestore->getAllDataWhereRef("course", "programme", "=", $doc);
    for($i = 0; $i < count($data_programme); $i++){
        foreach($data_programme[$i] as $k=>$v){
            if($k == "programme"){
                $data->assign($k, $v->snapshot()->id());
            }
            else
                $data->assign($k, $v);
        }
        $data->render("course", "content");
    }
?>
