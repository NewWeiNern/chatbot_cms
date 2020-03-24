<?php
include_once "google/firestore/index.php";

$collection = $_GET["type"];
$data = $_POST["doc"];
$GFirestore->deleteFromCollection($collection, $data);
?>