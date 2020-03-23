<?php
include_once "google/firestore/index.php";

$collection = $_GET["type"];
$data = $_POST;
$GFirestore->addToCollection($collection, $data);
?>