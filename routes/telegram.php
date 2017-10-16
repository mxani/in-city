<?php
use XB\theory\Shoot;
use XB\telegramMethods\sendMessage;


$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='/start';
},'start@showMenu');
$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='درباره ربات';
},'start@aboutUs');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='جستجو مکان';
},'makanyab@makanemoredenazar');
$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='ثبت مکان';
},'start@registerplace');

$this->trigger(function(&$u){
return !empty($u->message->text) && $u->message->text=='ثبت مکان جدید';
},'sabtemakan@regplace');

if (!empty($this->detect->data->path)){
    $this->trigger(function($u){ return true ;},$this->detect->data->path);

}
// $this->trigger(function(&$u){
//     return !empty($u->message->text) ;
// },'makanyab@searchplace');
//