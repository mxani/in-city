<?php

namespace App\Magazines;
use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class sabtemakan extends Magazine{


    public function local($u){ 
        
        $send=new sendMessage([
            'chat_id'=>$this->update->message->chat->id,
               'text'=> "مکانی که می خوای ثبت کنی کجاهاست؟ ",
               'parse_mode'=>'html',
               'reply_markup'=> $this->kaygntthree(),
               ]);
           $send();
            
       }

    public function regplace($u){
        if (!empty($this->detect->data->from)){
        $this->meet["recorde[6]"]=$this->detect->data->id;}
        
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
                $this->meet["recorde[5]"]=$this->detect->data->id ;
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
      
    }
    
    public function namereg($u){ 
 
      if ($this->meet["placename"]==1){ 
      $this->meet["recorde[1]"]=$u->message->text;
       $send=new sendMessage([
        'chat_id'=>$this->update->message->chat->id,
        'text'=>  "شماره تلفن  {$this->meet["recorde[1]"]}   را وارد کنید  ",
        'parse_mode'=>'html',
       
        ]);
    $send();
    $this->meet["placename"]=2;
      }
    }

    public function phonereg($u){

        if ($this->meet["placename"]==2){ 
            $this->meet["recorde[2]"]=$u->message->text;
             $send=new sendMessage([
              'chat_id'=>$this->update->message->chat->id,
              'text'=> "آدرس  {$this->meet["recorde[1]"]}  واردکنید",
              'parse_mode'=>'html',
             
              ]);
          $send();
          $this->meet["placename"]=3;
            }
            
    }
    public function adressreg($u){
        
        if ($this->meet["placename"]==3){ 
            $this->meet["recorde[3]"]=$u->message->text;
                $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> "درصورتی  {$this->meet["recorde[1]"]}  آدرس سایت یا کانال تگرام دارد وارد کنید و در غیر این صورت تایپ کنید ندارد ",
                'parse_mode'=>'html',
                
                ]);
            $send();
            $this->meet["placename"]=4;
            }
      }
      public function webpagereg($u){
        
        if ($this->meet["placename"]==4){ 
            $this->meet["recorde[4]"]=$u->message->text;
                $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> "مکان شما با موفقیت ثبت شد .با تشکر از همکاری شما عزییییییزم",
                'parse_mode'=>'html',
                
                ]);
            $send();
          
            }
            \App\places::insert(
                ['locations_id'=> $this->meet["recorde[6]"],'parentID'=>$this->meet["recorde[5]"],'place' =>$this->meet["recorde[1]"] , 'phone' =>$this->meet["recorde[2]"],'adress'=>$this->meet["recorde[3]"] ,'webpage'=>$this->meet["recorde[4]"] ,'pic'=>'hugu','tag'=>'jhg','sign'=>'gygy']
            ); 
            unset($this->meet["placename"]);
      }

      public function kaygntthree(){
        
                $data=\App\locations::get();
                $keys=[];
                $local=\App\locations::pluck('local')->toArray();
                if(count($data)%2==0){   
                 for($i=0;$i<count($data)-1;$i+=2){
                        $keys[]=[
                            [
                                "text"=>$local[$i],
                                "callback_data"=>interlink([
                                    "id"=>$data[$i]->id,
                                    "path"=>"sabtemakan@regplace",
                                    "from"=>"local"
                                ])
                                ],
                            [
                                "text"=>$local[$i+1],
                                "callback_data"=>interlink([
                                    "id"=>$data[$i+1]->id,
                                    "path"=>"sabtemakan@regplace",
                                    "from"=>"local"
                                ])
                            ]
                        ];  
                } 
                           
                        } 
                if(count($data)%2==1){ 
                  
                    for($i=1;$i<=count($data)-2;$i+=2){
                            $keys[]=[
                                [
                                    "text"=>$local[$i],
                                    "callback_data"=>interlink([
                                        "id"=>$data[$i]->id,
                                        "path"=>"sabtemakan@regplace",
                                        "from"=>"local"
                                    ])
                                    ],
                                [
                                    "text"=>$local[$i+1],
                                    "callback_data"=>interlink([
                                        "id"=>$data[$i+1]->id,
                                        "path"=>"sabtemakan@regplace",
                                        "from"=>"local"
                                    ])
                                ]
                            ];  
                    } 

                            $keys[]=[
                                [
                                    "text"=>$local[count($data)-1],
                                    "callback_data"=>interlink([
                                        "id"=>$data[count($data)-1]->id,
                                        "path"=>"sabtemakan@regplace",
                                        "from"=>"local"
                            ])
                            ]
                            ];
                            }
   
                            
      return json_encode(["inline_keyboard"=> $keys ]);
        }

    public function kaygnt(){
        $keys=[];
        $data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        if (!empty($this->detect->data->from)){
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
