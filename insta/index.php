<?php
header('Access-Control-Allow-Origin: *');

$data = (isset($_POST["data"])) ? $_POST['data'] : false;
$fileName = (isset($_POST["file"])) ? $_POST['file'] : "allUsers";
$action = (isset($_POST["property"]) && array_search($_POST['property'], ["update","read"]) !== false && $data) ? $_POST['property'] : "read";
$json = [];
$file = $fileName.".txt";
if ($action == "update") {

    $fc = file_get_contents("files/".$file);
    if (!$fc) {
        file_put_contents("files/".$file, "");
    }

    if (is_array($data)) {
//        echo count($data);
        print_r($data);
        foreach ($data as $key => $value) {
            $json[$key] = $value;
            file_put_contents("files/".$file, json_encode($json));
        }
    } else {
        printf($data);
        $json = $data;
        file_put_contents("files/".$file, $json);
    }
} else {
    echo file_get_contents("files/".$file);
}
?>