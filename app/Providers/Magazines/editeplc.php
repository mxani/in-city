<?php

namespace App\Magazines;

use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class editeplc extends Magazine
{
public function editeplcinfo(){
    $user_id=$this->update->message->chat->id;
    $serch=\App\places::where("user_id", $user_id)->get()->first();
    $text="مکان ثبت شده شما به شرح زیر است :"."\n".
    "مکان:".$serch->place."\n".
    "تلفن:".$serch->phone."\n".
    "آدرس:".$serch->adress."\n".
    "صفحه وب:".$serch->webpage;
    $send=new sendMessage([
        'chat_id'=>$this->update->message->chat->id,
        'text'=>$text,
        'parse_mode'=>'html',
        'reply_markup'=> $this->itemkay(),
    ] );
        $send();
    }

public function editeplace(){
  
    $send=new editMessageText([
        'chat_id'=>$this->update->callback_query->message->chat->id,    
        'message_id'=>$this->update->callback_query->message->message_id,   
        'text'=>"نام مکان مورد نظر خود را وارد کنید ",
        'parse_mode'=>'html',
    
    ] );
    $send();
    $this->meet["fndcart"]=1;
    }

    public function editephone(){
        
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"شماره تلفن مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        
        ] );
        $send();
        $this->meet["fndcart"]=2;
        }

    public function editeadress(){
    
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"آدرس مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        
        ] );
        $send();
        $this->meet["fndcart"]=3;
        }
    public function editeweb(){
    
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"صفحه وب یا کانال تلگرام مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        
        ] );
        $send();
        $this->meet["fndcart"]=4;
        }

    public function todbplc(){
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $plc=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['place'=>"$plc"]);
         $this->editeplcinfo();
    }

    public function todbphone(){
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $phone=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['phone'=>"$phone"]);
         $this->editeplcinfo();
    }

    public function todbadress(){
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $adress=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['adress'=>"$adress"]);
         $this->editeplcinfo();
    }
    public function todbweb(){
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $webpage=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['webpage'=>"$webpage"]);
         $this->editeplcinfo();
    }
 
    public function itemkay()
    {
        $keys=[];
                $keys[]=[
                  [
                        "text"=>"ویرایش مکان",
                        "callback_data"=>interlink([
                            "path"=>"editeplc@editeplace",
                        ])
                    ],
                    [
                        "text"=>"ویرایش تلفن",
                        "callback_data"=>interlink([
                            "path"=>"editeplc@editephone",
                        ])
                    ],
                    [
                        "text"=>"ویرایش آدرس",
                        "callback_data"=>interlink([
                            "path"=>"editeplc@editeadress",
                        ])
                    ],
                    [
                        "text"=>"ویرایش صفحه وب",
                        "callback_data"=>interlink([
                            "path"=>"editeplc@editeweb",
                        ])
                    ]
                ];
              
            
        return json_encode(["inline_keyboard"=> $keys ]);
  }
    
}