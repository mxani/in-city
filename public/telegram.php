<?php 

$data=file_get_contents('php://input');

$json=json_decode($data,true);
$log='logs/'.$json['update_id'].'.log';
$path='../bot';
if(!empty($_GET['tenant'])){
    $path.='/tenants/'.$_GET['tenant'];
}

if(file_exists($path)){
    `echo 'input:\n\n$data\n\noutput:\n\n'> $path/$log`;
    `nohup ../artisan bot '$data' >> $path/$log &`;
}

echo "hi :)";
