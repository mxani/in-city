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
           $data=\App\categories::get();
           $parentID=\App\categories::pluck('parentID')->toArray();
           $id=$this->detect->data->id;
           if(!empty(array_search($id,$parentID))){
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"مکان مورد نظر شما در کدام دسته جای دارد ",
                'parse_mode'=>'html',
                'reply_markup'=> $this->kaygnt(),
                ]);
            $send();
            }
            else{
                $send=new editMessageText([
                    'chat_id'=>$this->update->callback_query->message->chat->id,
                    'message_id'=>$this->update->callback_query->message->message_id,
                    'text'=>"نام مکان مورد نظر خود را وارد کنید ",
                    'parse_mode'=>'html',
                    
                    ]);
                $send();
                $this->meet["placename"]=1;
            }

        }
    
        if(!empty($this->update->message->chat->id)){ 
        $send=new sendMessage([
            'chat_id'=>$this->update->message->chat->id,
            'text'=> "xarrr"." مکان مورد نظر شما در کدام دسته جای دارد  ",
            'parse_mode'=>'html',
            'reply_markup'=> $this->kaygnt(),
            ]);
        $send();
         }
        
    }
    
    public function namereg($u){
      if ($this->meet["placename"]==1){ 
       $recorde[1]=$u->message->text;
       $send=new sendMessage([
        'chat_id'=>$this->update->message->chat->id,
        'text'=> "شماره تلفن".$recorde[1]." را وارد کنید  ",
        'parse_mode'=>'html',
       
        ]);
    $send();
    $this->meet["placename"]=2;
      }
    }
    public function kaygnt(){
        $keys=[];
        $data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        if (empty($this->detect->data->id)){
            $j=0;}
        else{$j=$this->detect->data->id;}
        for($i=0;$i<count($data);$i++){
            if ($parentID[$i]==$j)
            {
               
                $keys[]=[
                    [
                        "text"=>$data[$i]->Category,
                        "callback_data"=>interlink([
                            "id"=>$data[$i]->id,
                            "path"=>"sabtemakan@regplace",
                        ])
                    ]
                ];
               
            } 
           
        }
       
        return json_encode(["inline_keyboard"=> $keys ]);
        
    }

}
