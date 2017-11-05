<?php

namespace App\Magazines;

use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class editeplc extends Magazine
{
    public function editeplcinfo()
    {
        $this->meet["editplc"]=1;
        //>this meet for  declear that refrenced from here 
        if (empty($this->update->message->chat->id))
        {
            $user_id=$this->update->callback_query->message->chat->id;
        }
        else
        {
            $user_id=$this->update->message->chat->id;
        }
        $fake=\Faker\Factory::create('fa_IR');
        $serch=\App\places::where("user_id", $user_id)->get()->first();
        $location=\App\locations::where("id", $serch->locations_id)->get()->first();
        $categori=\App\categories::where("id", $serch->parentID)->get()->first();
        $text="<a href=\"$fake->imageurl\">&#8205;</a>\n ".
        "مکان ثبت شده شما به شرح زیر است :"."\n".
        "🏢مکان:".$serch->place."\n".
        "☎️تلفن:".$serch->phone."\n".
        "📝آدرس:".$serch->adress."\n".
        "🌐صفحه وب:".$serch->webpage."\n".
        "🔸دسته:".$categori->Category."\n".
        "🔹محله:".$location->local."\n";
        if (empty($this->update->message->chat->id))
        {
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>$text,
                'parse_mode'=>'html',
                'reply_markup'=>view('editplacekey')->render()
            ]);
            $send();
        } 
        else
        {
            $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=>$text,
                'parse_mode'=>'html',
                'reply_markup'=>view('editplacekey')->render()
            ] );
            $send(); 
        }
    }

    public function editeplace()
    {
    
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"نام مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        ] );
        $send();
        $this->meet["fndcart"]=1;
        //>this meet decleare next step has whitch  carteige .in the routs this Issue clear.
    }

    public function editephone()
    {
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"شماره تلفن مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        
        ]);
        $send();
        $this->meet["fndcart"]=2;
    }

    public function editeadress()
    {
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"آدرس مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        ] );
        $send();
        $this->meet["fndcart"]=3;
    }

    public function editeweb()
    {
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"صفحه وب یا کانال تلگرام مکان مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        
        ] );
        $send();
        $this->meet["fndcart"]=4;
    }
    public function editepic()
    {
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,    
            'message_id'=>$this->update->callback_query->message->message_id,   
            'text'=>"لطفا عکس مورد نظر خود را وارد کنید ",
            'parse_mode'=>'html',
        ] );
        $send();
        $this->meet["fndcart"]=5;
    }
//>top cartrige has for show message to user and The following cartridges are for the information that the user has entered 
    public function todbplc()
    {
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $plc=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['place'=>"$plc"]);
         $this->editeplcinfo();
    }

    public function todbphone()
    {
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $phone=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['phone'=>"$phone"]);
         $this->editeplcinfo();
    }

    public function todbadress()
    {
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $adress=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['adress'=>"$adress"]);
         $this->editeplcinfo();
    }
    public function todbweb()
    {
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $webpage=$this->update->message->text;
         \App\places::
         where('user_id',$user_id)
         ->update(['webpage'=>"$webpage"]);
         $this->editeplcinfo();
    }

    public function todbpic()
    {
        $user_id=$this->update->message->chat->id;
         unset($this->meet["fndcart"]);
         $pic=$this->update->message->photo[1]->file_id;
         \App\places::
         where('user_id',$user_id)
         ->update(['pic'=>"$pic"]);
         $this->editeplcinfo();
    }
 
   
}