<?php

namespace App\Magazines;
use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class makanyab extends Magazine{

    public function makanemoredenazar(){
      
        $send=sendMessage::class;
        $message=[
            'chat_id'=>$this->detect->from->id,
            'text'=>" دنبال چی  می گردی",
            'parse_mode'=>'html',
            'reply_markup'=> $this->catkey(), 
         ];

       if($this->detect->type=='callback_query'){
            $id=$this->detect->data->id;
            $message['message_id']=$this->update->callback_query->message->message_id;
            if (!empty(\App\categories::where("parentID",$id)->first())) {
                $send=editMessageText::class;
                $send= new $send($message);
                $send();
            }
            else{
               $this->local();
            }
         }
         else{
            $send= new $send($message);
            $send();
         }

    }

    public function local(){ 
     
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$this->update->callback_query->message->message_id,
            'text'=> "کجا می خوای بگردی ",
            'parse_mode'=>'html',
            'reply_markup'=> $this->localkey(),
            ]);
        $send();
         
    }

    public function lastplace($u){  
      
       if (empty($this->detect->data->cor)){
       $this->meet["lastid"]=$this->detect->data->lastid;}
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$u->callback_query->message->message_id,
            'text'=> "مکان های مورد نظر شما",
            'parse_mode'=>'html',
            'reply_markup'=> $this->lastplckey(),
            ]);
        $send();
    }

    public function placeinfo($u){
       $id=$this->detect->data->id;
       $data=\App\places::where("id", $id)->get()->first();
       $text="<a href=\"$data->pic\">&#8205;</a>\n ".
             "place:". $data->place."\n";
          
       $send=new editMessageText([
        'chat_id'=>$this->update->callback_query->message->chat->id,
        'message_id'=>$u->callback_query->message->message_id,
        'text'=>$text ,
        'parse_mode'=>'html',
        'reply_markup'=> $this->plcinfokey(),
        
        ]);
    $send();

    }
    public function contactinfo ($u){
        $this->meet["correction"]="yes";
        $id=$this->detect->data->id;
        $this->timesUse($id); 
        if (!empty($this->meet["limite"])&&$this->meet["limite"]=="yes"){
            
        }
        else{
        $data=\App\places::where("id", $id)->get()->first();
        $text= "مکان:". $data->place."\n".
               "تلفن تماس:".$data->phone."\n".
               "ادرس:".$data->adress."\n".
               "صفحه وب".$data->webpage."\n";    
        $send=new editMessageText([
         'chat_id'=>$this->update->callback_query->message->chat->id,
         'message_id'=>$u->callback_query->message->message_id,
         'text'=>$text ,
         'parse_mode'=>'html',
         'reply_markup'=> $this->kaygnsix(),
         
         ]);
         $send();
         
     }
      unset($this->meet["limite"]);
    }
     public function timesUse ($id){

         $user_id=$this->update->callback_query->message->chat->id;
         $count=\App\timesUse::count();
         $data=\App\timesUse::get();
         $time=date('Y-m-d H:i:s');
         $y=0;$x=0;$maxzan=[];$i=0;
         $dbuser=\App\timesUse::pluck('user_id')->toArray();
         \App\timesUse::insert(
            ['user_id'=>$user_id,'placeID'=>$id,"created_at"=>$time]
            );  
            $maxzan=\App\timesUse::where('user_id', $user_id)->get();
            $arraymaxzan=$maxzan->pluck('created_at');
            foreach ($arraymaxzan as $value) {
                $arraymaxzan[$i]=$value->timestamp;
                $i+=1;
            }
              
            // for($i=0;$i<count($data);$i++)
            // {
               
            //     if( $dbuser[$i]==$user_id){
            //          $y+=1; 
            //          $maxzan[$y]=$i;
            //          $timestamp[$y]=$data[$maxzan[$y]]->created_at->timestamp;
                    
            //     }
            // } 
        //    if(count($maxzan)!==0){
        //     $lastid=count($maxzan);
            $today=$maxzan->last()->created_at->timestamp;
           // $today=$data[$lastid-1]->created_at->timestamp;dd($today);
            $yeste=$maxzan->last()->subDay()->timestamp;
          //  $yeste=$data[$lastid-1]->created_at->subDay()->timestamp;
            for($j=0;$j<count($arraymaxzan);$j++){
            if($arraymaxzan[$j]>$yeste&&$arraymaxzan[$j]<$today){
                //$timeuse[$x]=$arraymaxzan[$j];
                $x+=1;
            }
      }dd($x);
  // }
          if ($x>5){
        
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"شما بیش از 20 بار از این قابلیت استفاده کرده اید " ,
                'parse_mode'=>'html',
                'reply_markup'=> $this->kaygnsix(),
                ] );
                $send();
               $this->meet["limite"]="yes";
            }
        
     }
    public function catkey(){
        $keys=[];
        if (!empty($this->update->message->chat->id)) {
            $j=0;
        }
        else {
           
            $j=$this->detect->data->id;
           
        }
        $catserch=\App\categories::where("parentID",$j)->get();
        for($i=0;$i<count($catserch);$i++){ 
           $this->meet["i"]=$i;
                $keys[]=[
                    [
                        "text"=>$catserch[$i]->Category,
                        "callback_data"=>interlink([
                            "id"=>$catserch[$i]->id,
                            "path"=>"makanyab@makanemoredenazar",
                            
                        ])
                    ]
                ];       
        }
        $parentID=\App\categories::find($j)->parentID??0;
       if($j!==0&&$parentID!==0){
        $keys[]=[
             [
                "text"=>"بازگشت",
                "callback_data"=>interlink([
                   "id"=>$parentID,
                   "path"=>"makanyab@makanemoredenazar",
                  
                ])
            ]
        ];
      } 
        return json_encode(["inline_keyboard"=> $keys ]);
        
    }
    
    public function localkey(){

        $count=\App\locations::count();
        $keys=[];
        $id=$this->detect->data->id;
        $parentID=\App\categories::find($id)->parentID;
        $a=[];
        if($count%2==0){   
            for($i=0;$i<$count-1;$i+=2){
    
                $keys[]=[
                    [
                        "text"=>\App\locations::find($i+2)->local,
                        "callback_data"=>interlink([
                            "id"=>\App\locations::find($i+2)->id,
                            "path"=>"makanyab@lastplace",
                            "lastid"=>$this->detect->data->id
                        ])
                        ],
                    [
                        "text"=>\App\locations::find($i+1)->local,
                        "callback_data"=>interlink([
                            "id"=>\App\locations::find($i+1)->id,
                            "path"=>"makanyab@lastplace",
                            "lastid"=>$this->detect->data->id
                        ])
                    ]
                ];  
        } 
                    $keys[]=[
                        [
                    
                    "text"=>"back",
                    "callback_data"=>interlink([
                        "text"=>"back",
                        "path"=>"makanyab@makanemoredenazar", 
                        "id"=>0,

                    ])
                    ],
                    [
                        
                        "text"=>"back one step",
                        "callback_data"=>interlink([
                            "path"=>"makanyab@makanemoredenazar",
                            "id"=>$parentID,
                        ])
                        ],
                    ];
                } 
        if($count%2==1){ 
            
            for($i=1;$i<=$count-2;$i+=2){
                    $keys[]=[
                        [
                            "text"=>\App\locations::find($i+1)->local,
                            "callback_data"=>interlink([
                                "id"=>\App\locations::find($i+1)->id,
                                "path"=>"makanyab@lastplace",
                                "lastid"=>$this->detect->data->id,
                            ])
                            ],
                        [
                            "text"=>\App\locations::find($i+2)->local,
                            "callback_data"=>interlink([
                                "id"=>\App\locations::find($i+2)->id,
                                "path"=>"makanyab@lastplace",
                                "lastid"=>$this->detect->data->id,
                            ])
                        ]
                    ];  
            } 

                    $keys[]=[
                        [
                            "text"=>\App\locations::find($count)->local,
                            "callback_data"=>interlink([
                                "id"=>\App\locations::find($count)->id,
                                "path"=>"makanyab@lastplace",
                                "lastid"=>$this->detect->data->id,
                    ])
                    ]
                    ];
                        $keys[]=[
                            [
                        
                        "text"=>"back",
                        "callback_data"=>interlink([
                            "text"=>"back",
                            "path"=>"makanyab@makanemoredenazar", 
                        ])
                        ],
                        [
                            
                            "text"=>"back one step",
                            "callback_data"=>interlink([
                                "path"=>"makanyab@makanemoredenazar",
                                "id"=>$parentID,
                            ])
                            ],
                        ];
                    }

        return json_encode(["inline_keyboard"=> $keys ]);
        
            }

    public function lastplckey(){

        $count=\App\places::count();        
        $idplace=$this->meet["lastid"]; 
        $dataplc=\App\places::find($idplace);
        if (empty($this->detect->data->loc)){
        $idlocation=$this->detect->data->id;}
        else{$idlocation=$this->detect->data->loc;}
        $maxzan=[];$finalplace=[];$keys=[];
        $maxzan= \App\places::where('parentID',$idplace)->where('locations_id',$idlocation)->get()->toArray();
    
        if(empty($maxzan)){

            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"چنین موردی وجود ندارد " ,
                'parse_mode'=>'html',
                'reply_markup'=>$this->kaygnsix(),
                ] );
                $send();
        }
        
        if(count($maxzan)%2==1){   
            for($r=0;$r<count($maxzan)-2;$r+=2){
                
                        $keys[]=[
                            [
                    "text"=>$maxzan[$r]['place'],
                    "callback_data"=>interlink([
                        "id"=>$maxzan[$r]['id'],
                        "path"=>"makanyab@placeinfo",
                        
                    ])
                    ],
                    [
                        "text"=>$maxzan[$r+1]['place'],
                        "callback_data"=>interlink([
                            "id"=>$maxzan[$r+1]['id'],
                            "path"=>"makanyab@placeinfo",
                            
                        ])
                        ]
                            ];  
                    } 

                    $keys[]=[
                    [
                    "text"=>end($maxzan)['place'],
                    "callback_data"=>interlink([
                        "id"=>end($maxzan)['id'],
                        "path"=>"makanyab@placeinfo",
                    
                    ])
                    ]
                ]; 
                    $keys[]=[
                        [
                    
                    "text"=>"back to first menue",
                    "callback_data"=>interlink([
                        "text"=>"back",
                        "path"=>"makanyab@makanemoredenazar", 
                        "id"=>0,
                    ])
                    ],
                    [
                        
                        "text"=>"back one step",
                        "callback_data"=>interlink([
                            "path"=>"makanyab@local",
                            "id"=>$maxzan[0]['parentID'],
                        ])
                        ],   
                    ];
                }
        if(count($maxzan)%2==0){
            for($r=0;$r<count($maxzan)-1;$r+=2){
                
                    $keys[]=[
                        [
                        "text"=>$maxzan[$r]['place'],
                        "callback_data"=>interlink([
                            "id"=>$maxzan[$r]['id'],
                            "path"=>"makanyab@placeinfo",
                        
                        ])
                        ],
                        [
                            "text"=>$maxzan[$r+1]['place'],
                            "callback_data"=>interlink([
                                "id"=>$maxzan[$r+1]['id'],
                                "path"=>"makanyab@placeinfo",
                            
                            ])
                            ]
                            ];  
                    } 
                    $keys[]=[
                        [
                    
                    "text"=>"back to first menue",
                    "callback_data"=>interlink([
                        "text"=>"back",
                        "path"=>"makanyab@makanemoredenazar",
                        "id"=>0, 
                    ])
                    ],
                    [
                        
                        "text"=>"back one step",
                        "callback_data"=>interlink([
                            "path"=>"makanyab@local",
                            "id"=>$maxzan[0]['parentID'],
                        ])
                        ],   
                    ];

            }
    return json_encode(["inline_keyboard"=> $keys ]);
}

public function plcinfokey(){
    $id=$this->detect->data->id;
    $locationID=\App\places::where("id", $id)->get()->first()->locations_id;
    $keys[]=[
     
        [
      
      "text"=>"back to first menue",
      "callback_data"=>interlink([
          "text"=>"back",
          "path"=>"makanyab@makanemoredenazar", 
          "id"=>0,
      ])
      ],
    
      [
          
          "text"=>"back one step",
          "callback_data"=>interlink([
              "path"=>"makanyab@lastplace",
              "loc"=>$locationID,
              "cor"=>"1",
          ])
          ],   
    ];
 
        $keys[]=[
            [
                "text"=>"contact info",
                "callback_data"=>interlink([
                    "id"=>$id,
                    "path"=>"makanyab@contactinfo", 
            
            ])
            ]
        ];
       
  
    return json_encode(["inline_keyboard"=> $keys ]);
}

public function kaygnsix(){
   
    $id=$this->detect->data->id;
    $locationID=\App\places::where("id", $id=$this->detect->data->id)->get()->first()->locations_id;
    $keys[]=[
     
        [
      
      "text"=>"back to first menue",
      "callback_data"=>interlink([
          "text"=>"back",
          "path"=>"makanyab@makanemoredenazar", 
          "id"=>0,
      ])
      ],
    ];
    if (!empty($this->detect->data->lastid)){
    $keys[]=[
      [
          
          "text"=>"back one step",
          "callback_data"=>interlink([
            "path"=>"makanyab@local",
            "id"=>$this->meet["lastid"],
            
          ])
          ],   
    ];
}
    else{
        $keys[]=[
            [
                
                "text"=>"back ystep",
                "callback_data"=>interlink([
                    "path"=>"makanyab@lastplace",
                    "loc"=>$locationID,
                    "cor"=>"1",
                ])
            ],   
        ];
    
}    
    
    return json_encode(["inline_keyboard"=> $keys ]);
}
                    
} 