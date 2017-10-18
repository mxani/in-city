<?php
use XB\theory\Shoot;
use XB\telegramMethods\sendMessage;

//echo($this->meet["placename"]);
$this->trigger(function(&$u){
    // if ($u->message->text=='/start'){
    // unset($this->meet["placename"]);}
    return !empty($u->message->text) && $u->message->text=='/start';
},'start@showMenu');

$this->trigger(function(&$u){	
    // if ($u->message->text=='درباره ربات'){
    // unset($this->meet["placename"]);}
    return !empty($u->message->text) && $u->message->text=='درباره ربات';
},'start@aboutUs');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='جستجو مکان';
},'makanyab@makanemoredenazar');

$this->trigger(function(&$u){	
    // if ($u->message->text=='ثبت مکان'){
    // unset($this->meet["placename"]);}
    return !empty($u->message->text) && $u->message->text=='ثبت مکان';
},'start@registerplace');

$this->trigger(function(&$u){	
    // if ($u->message->text=='ثبت مکان جدید'){
    // unset($this->meet["placename"]);}
    return !empty($u->message->text) && $u->message->text=='ثبت مکان جدید';
},'sabtemakan@local');

$this->trigger(function(&$u){
    // if ($u->message->text=='بازگشت'){
    // unset($this->meet["placename"]);}
    return !empty($u->message->text) && $u->message->text=='بازگشت';
},'start@showMenu');

$this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["placename"]) && $this->meet["placename"]==1;
   },'sabtemakan@namereg');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["placename"]) && $this->meet["placename"]==2;
   },'sabtemakan@phonereg');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["placename"]) && $this->meet["placename"]==3;
   },'sabtemakan@adressreg');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["placename"]) && $this->meet["placename"]==4;
   },'sabtemakan@webpagereg');

if (!empty($this->detect->data->path)){
    $this->trigger(function($u){ return true ;},$this->detect->data->path);}

