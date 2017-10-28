public function catkey(){
        $keys=[];
        //$data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        \App\categories::where("parentID",0)->count()
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

  