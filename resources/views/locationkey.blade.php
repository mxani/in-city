{
    "inline_keyboard":[

       @if(count($data)%3==0)
        @for($i=0;$i<count($data)-1;$i+=3)
         @if($i)
        ,
        @endif
        [
             {
                "text":"{{$local[$i]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i]->id,"path"=>"sabtemakan@regplace","from"=>"local"])!!}"                
            },
            {
                "text":"{{$local[$i+1]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i+1]->id,"path"=>"sabtemakan@regplace", "from"=>"local"])!!}"                
            },
            {
                "text":"{{$local[$i+2]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i+2]->id,"path"=>"sabtemakan@regplace", "from"=>"local"])!!}"                
            }
        ]
        @endfor
        @endif
        @if(count($data)%3==1)
        @for($i=1;$i<count($data)-3;$i+=3)
          [
             {
                "text":"{{$local[$i]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i]->id,"path"=>"sabtemakan@regplace","from"=>"local"])!!}"
                                 
            },
            {
                "text":"{{$local[$i+1]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i+1]->id,"path"=>"sabtemakan@regplace", "from"=>"local"])!!}"
                               
            },
            {
                "text":"{{$local[$i+2]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i+2]->id,"path"=>"sabtemakan@regplace", "from"=>"local"])!!}"
                               
            }
        ],
        @endfor
          [
             {
                "text":"{{$local[count($data)-1]}}",
                "callback_data":"{!! interlink(["id"=>$data[count($data)-1]->id,"path"=>"sabtemakan@regplace","from"=>"local"])!!}"                    
            }
        ]
        @endif
        @if(count($data)%3==2)
        @for($i=1;$i<count($data)-4;$i+=3)
          [
             {
                "text":"{{$local[$i]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i]->id,"path"=>"sabtemakan@regplace","from"=>"local"])!!}"
                                 
            },
            {
                "text":"{{$local[$i+1]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i+1]->id,"path"=>"sabtemakan@regplace", "from"=>"local"])!!}"
                               
            },
            {
                "text":"{{$local[$i+2]}}",
                "callback_data":"{!! interlink(["id"=>$data[$i+2]->id,"path"=>"sabtemakan@regplace", "from"=>"local"])!!}"
                               
            }
        ],
        @endfor
          [
             {
                "text":"{{$local[count($data)-1]}}",
                "callback_data":"{!! interlink(["id"=>$data[count($data)-1]->id,"path"=>"sabtemakan@regplace","from"=>"local"])!!}"                    
            },
            {
                "text":"{{$local[count($data)-2]}}",
                "callback_data":"{!! interlink(["id"=>$data[count($data)-2]->id,"path"=>"sabtemakan@regplace","from"=>"local"])!!}"                    
            }
        ]
        @endif
    ]
}