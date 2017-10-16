<?php

namespace App\Magazines;
use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class makanyab extends Magazine{

    public function makanemoredenazar(){
      
        if (empty($this->update->message->chat->id))
        { 
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>" دنبال چی  می گردی",
                'parse_mode'=>'html',
                'reply_markup'=> $this->kaygnt(),
                ]);
            $send();
        }
        else{ 
        $send=new sendMessage([
            'chat_id'=>$this->update->message->chat->id,
            'text'=>" دنبال چی  می گردی",
            'parse_mode'=>'html',
            'reply_markup'=> $this->kaygnt(),
            ]);
        $send();
         }
    }
    

    public function searchplace($u){
    $count=$this->detect->data->count;
        $id=$this->detect->data->id;
        $text=\App\categories::find($id)->Category; 
        for($j=0;$j<=$count;$j++) {
            if ($this->detect->data->id==$j)
            { 
                $send=new editMessageText([
                    'chat_id'=>$this->update->callback_query->message->chat->id,
                    'message_id'=>$u->callback_query->message->message_id,
                    'text'=> "$text",
                    'parse_mode'=>'html',
                    'reply_markup'=> $this->kaygntone(),
                    ]);
                $send();
              
            }
        }

    }
    public function local($u){ 
     
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$u->callback_query->message->message_id,
            'text'=> "کجا می خوای بگردی ",
            'parse_mode'=>'html',
            'reply_markup'=> $this->kaygntthree(),
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
            'reply_markup'=> $this->kaygntfour(),
            ]);
        $send();
    }

    public function placeinfo($u){
       $id=$this->detect->data->id;
       $data=\App\places::where("id", $id=$this->detect->data->id)->get()->first();
       $text="<a href=\"$data->pic\">&#8205;</a>\n ".
            "place:". $data->place."\n".
            "phone:".$data->phone."\n".
            "adress:".$data->adress."\n".
            "webpage:".$data->webpage;
       $send=new editMessageText([
        'chat_id'=>$this->update->callback_query->message->chat->id,
        'message_id'=>$u->callback_query->message->message_id,
        'text'=>$text ,
        'parse_mode'=>'html',
        'reply_markup'=> $this->kaygntfive(),
        
        ]);
    $send();

    }
    public function kaygnt(){
        $keys=[];
        $data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        $a=[];
        for($i=0;$i<11;$i++){
            if ($parentID[$i]==0)
            {
                $keys[]=[
                    [
                        "text"=>$data[$i]->Category,
                        "callback_data"=>interlink([
                            "id"=>$data[$i]->id,
                            "path"=>"makanyab@searchplace",
                            "count"=>\App\categories::where("parentID",0)->count()
                        ])
                    ]
                ];
            }
        }
     
        return json_encode(["inline_keyboard"=> $keys ]);
        
    }
    
    public function kaygntone(){
        $data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        $keys=[];
        $a=[];
        $maxzan=[];$y=1;
        $j=$this->detect->data->id;
         for($i=0;$i<count($data);$i++){
             if ($parentID[$i]==$j)
           { 
               $maxzan[$y]=$data[$i]->id;
                $y+=1;
             }
              
        }
        $count=count($maxzan); 
         if($count%2==0){ 
            for($r=1;$r<=count($maxzan)-1;$r+=2){
              //echo($data[$maxzan[$r]-1]->Category); 
                $keys[]=[
                        [
                            "text"=>$data[$maxzan[$r]-1]->Category,
                            "callback_data"=>interlink([
                                "id"=>$data[$maxzan[$r]-1]->id,
                                "path"=>"makanyab@local"
                                
                        ])
                        ],
                        [
                                
                            "text"=>$data[$maxzan[$r+1]-1]->Category,
                            "callback_data"=>interlink([
                                "id"=>$data[$maxzan[$r+1]-1]->id,
                                "path"=>"makanyab@local"
                                    
                        ])
                        ]
                    ]; //-1 is for that $data id alweys lower [$maxzan[$R]]and when -1 is match  
                }
                $keys[]=[
                    [
                  
                  "text"=>"back",
                  "callback_data"=>interlink([
                      "text"=>"back",
                      "path"=>"makanyab@makanemoredenazar", 
                  ])
                  ]
                  ];
            }
            if($count%2==1){ 
                 
                for($r=1;$r<=count($maxzan)-2;$r+=2){
                  //  dd($data[$maxzan[$r]-1]->Category);
                        $keys[]=[
                                [
                                    
                                    "text"=>$data[$maxzan[$r]-1]->Category,
                                    "callback_data"=>interlink([
                                        "id"=>$data[$maxzan[$r]-1]->id,
                                        "path"=>"makanyab@local"
                                        
                                    ])
                                ],
                                    [
                                        
                                    "text"=>$data[$maxzan[$r+1]-1]->Category,
                                    "callback_data"=>interlink([
                                        "id"=>$data[$maxzan[$r+1]-1]->id,
                                        "path"=>"makanyab@local"
                                            
                                     ])
                                    ]
                            ]; 
                }
                            $keys[]=[
                                [
                                "text"=>$data[$maxzan[count($maxzan)]-1]->Category,
                                "callback_data"=>interlink([
                                    "id"=>$data[$maxzan[count($maxzan)]-1]->id,
                                    "path"=>"makanyab@local"
                                        
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
                              ]
                            ];
            }
        return json_encode(["inline_keyboard"=> $keys ]);
        
    }

    public function kaygntthree(){
        
                $data=\App\locations::get();
                $keys=[];
                $local=\App\locations::pluck('local')->toArray();
                $id=$this->detect->data->id;
                $parentID=\App\categories::find($id)->parentID;
                $a=[];
                if(count($data)%2==0){   
                 for($i=0;$i<count($data)-1;$i+=2){
                        $keys[]=[
                            [
                                "text"=>$local[$i],
                                "callback_data"=>interlink([
                                    "id"=>$data[$i]->id,
                                    "path"=>"makanyab@lastplace",
                                    "lastid"=>$this->detect->data->id
                                ])
                                ],
                            [
                                "text"=>$local[$i+1],
                                "callback_data"=>interlink([
                                    "id"=>$data[$i+1]->id,
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
                            ])
                            ]
                            ];
                        } 
                if(count($data)%2==1){ 
                  
                    for($i=1;$i<=count($data)-2;$i+=2){
                            $keys[]=[
                                [
                                    "text"=>$local[$i],
                                    "callback_data"=>interlink([
                                        "id"=>$data[$i]->id,
                                        "path"=>"makanyab@lastplace",
                                        "lastid"=>$this->detect->data->id,
                                    ])
                                    ],
                                [
                                    "text"=>$local[$i+1],
                                    "callback_data"=>interlink([
                                        "id"=>$data[$i+1]->id,
                                        "path"=>"makanyab@lastplace",
                                        "lastid"=>$this->detect->data->id,
                                    ])
                                ]
                            ];  
                    } 

                            $keys[]=[
                                [
                                    "text"=>$local[count($data)-1],
                                    "callback_data"=>interlink([
                                        "id"=>$data[count($data)-1]->id,
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
                                        "path"=>"makanyab@searchplace",
                                        "count"=>\App\categories::where("parentID",0)->count(),
                                        "id"=>$parentID,
                                    ])
                                    ],
                                ];
                            }
   
        
                return json_encode(["inline_keyboard"=> $keys ]);
                
            }
    public function kaygntfour(){   
    $data=\App\places::get();        
    $parentID=\App\places::pluck('parentID')->toArray();
    $idplace=$this->meet["lastid"];
    $dataplc=\App\places::find($idplace);
   if (empty($this->detect->data->loc)){
    $idlocation=$this->detect->data->id;}
    else{$idlocation=$this->detect->data->loc;}
    $y=0;$maxzan=[];$a=0;$finalplace=[];$keys=[];
    for($i=0;$i<count($data);$i++){
        if ($parentID[$i]==$idplace)
        { 
            $maxzan[$y]=$data[$i]->id;
            
            if($data[$maxzan[$y]-1]->locations_id==$idlocation)
            {
                $finalplace[$a]=$data[$maxzan[$y]-1]->place;
                $finalplaceid[$a]=$data[$maxzan[$y]-1]->id;
                $a+=1;
            }
            $y+=1;
        }
            
        }
    if(count($finalplace)%2==1){   
        for($r=0;$r<count($finalplace)-2;$r+=2){
            
                    $keys[]=[
                        [
                "text"=>$finalplace[$r],
                "callback_data"=>interlink([
                    "id"=>$finalplaceid[$r],
                    "path"=>"makanyab@placeinfo",
                    
                ])
                ],
                [
                    "text"=>$finalplace[$r+1],
                    "callback_data"=>interlink([
                        "id"=>$finalplaceid[$r+1],
                        "path"=>"makanyab@placeinfo",
                        
                    ])
                    ]
                        ];  
                } 

                $keys[]=[
                [
                "text"=>$finalplace[count($finalplace)-1],
                "callback_data"=>interlink([
                    "id"=>$finalplaceid[count($finalplace)-1],
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
                ])
                ],
                [
                    
                    "text"=>"back one step",
                    "callback_data"=>interlink([
                        "path"=>"makanyab@local",
                        "id"=>$data->find($maxzan[0])->parentID,
                    ])
                    ],   
                ];
            }
    if(count($finalplace)%2==0){
        for($r=0;$r<count($finalplace)-1;$r+=2){
            
                  $keys[]=[
                      [
                     "text"=>$finalplace[$r],
                     "callback_data"=>interlink([
                         "id"=>$finalplaceid[$r],
                         "path"=>"makanyab@placeinfo",
                      
                     ])
                     ],
                     [
                         "text"=>$finalplace[$r+1],
                         "callback_data"=>interlink([
                             "id"=>$finalplaceid[$r+1],
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
                  ])
                  ],
                  [
                      
                      "text"=>"back one step",
                      "callback_data"=>interlink([
                          "path"=>"makanyab@local",
                          "id"=>$data->find($maxzan[0])->parentID,
                      ])
                      ],   
                ];

           }
return json_encode(["inline_keyboard"=> $keys ]);}
                          
  


public function kaygntfive(){
    $id=$this->detect->data->id;
    $locationID=\App\places::where("id", $id=$this->detect->data->id)->get()->first()->locations_id;
    $keys[]=[
        [
      
      "text"=>"back to first menue",
      "callback_data"=>interlink([
          "text"=>"back",
          "path"=>"makanyab@makanemoredenazar", 
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
    return json_encode(["inline_keyboard"=> $keys ]);
}

                      
} 