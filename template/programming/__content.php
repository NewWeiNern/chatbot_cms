<?php
    include_once "./template/index.php";
    
    $data = new Template();
    $data_programme = $GFirestore->getAllData("programme");
    for($i = 0; $i < count($data_programme); $i++){
        foreach($data_programme[$i] as $k=>$v){
            $data->assign($k, $v);
        }
        $data->render("programming", "content");
    }
?>
