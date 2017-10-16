<?php

namespace App\Magazines;
use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class sabtemakan extends Magazine{

    public function regplace($u){
        if (empty($this->update->message->chat->id))
        { 
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>" مکان مورد نظر شما در کدام دسته جای دارد ",
                'parse_mode'=>'html',
                'reply_markup'=> $this->kaygnt(),
                ]);
            $send();
        }
        else{ 
        $send=new sendMessage([
            'chat_id'=>$this->update->message->chat->id,
            'text'=> "مکان مورد نظر شما در کدام دسته جای دارد ",
            'parse_mode'=>'html',
            'reply_markup'=> $this->kaygnt(),
            ]);
        $send();
         }
    }
    public function finishmsg(){
        echo("echteba mizani dadach");
    }
    public function kaygnt(){
        $keys=[]; $a=[];
        $data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        if (empty($path)){ $path="sabtemakan@regplace";}
        
        if(!empty($xar)&&$xar==1){
            $path="sabtemakan@regplace";}
            else{$path="sabtemakan@finishmsg";}  
       
        if (empty($this->detect->data->id)){
            $j=0;
        }
        else{$j=$this->detect->data->id;}
        for($i=0;$i<count($data);$i++){
            if ($parentID[$i]==$j)
            { $xar=1;
                $keys[]=[
                    [
                        "text"=>$data[$i]->Category,
                        "callback_data"=>interlink([
                            "id"=>$data[$i]->id,
                            "path"=>$path,
                        ])
                    ]
                ];
            } 
            
       
        }
        
        return json_encode(["inline_keyboard"=> $keys ]);
        
    }

}
