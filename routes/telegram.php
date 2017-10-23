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
    return !empty($u->message->text) && $u->message->text=='مکان من';
},'start@registerplace');

$this->trigger(function(&$u){	
    return !empty($u->message->text) && $u->message->text=='ثبت مکان من' ;
},'sabtemakan@local');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='بازگشت';
},'start@showMenu');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='ندارد';
},'sabtemakan@webpagereg');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text==' برگشت به مرحله اول ';
},'start@showMenu');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='ویرایش مکان من';
},'editeplc@editeplcinfo');



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

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["placename"]) && $this->meet["placename"]==5;
   },'sabtemakan@Confirmation');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["fndcart"]) && $this->meet["fndcart"]==1;
   },'editeplc@todbplc');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["fndcart"]) && $this->meet["fndcart"]==2;
   },'editeplc@todbphone');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["fndcart"]) && $this->meet["fndcart"]==3;
   },'editeplc@todbadress');

   $this->trigger(function(&$u){
    return !empty($u->message->text) && !empty($this->meet["fndcart"]) && $this->meet["fndcart"]==4;
   },'editeplc@todbweb');

if (!empty($this->detect->data->path)){
    $this->trigger(function($u){ return true ;},$this->detect->data->path);}

