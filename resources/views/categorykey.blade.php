{
    "inline_keyboard":[
    
    @if($count%2==0)
     
        @for($i=0;$i<$count;$i+=2)
            [
                {
                    "text":"{{$catserch[$i]['Category']}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$i]['id'],"path"=>"sabtemakan@regplace"])}}"
                },
                {
                    "text":"{{$catserch[$i+1]['Category']}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$i+1]['id'],"path"=>"sabtemakan@regplace"])}}"
                }  
            ]
              @if($i<$count-2)
                ,
                @endif 
        @endfor 
                 
    @else
        @for($i=0;$i<$count-1;$i+=2)
            [
                {
                    "text":"{{$catserch[$i]['Category']}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$i]['id'],"path"=>"sabtemakan@regplace"])}}"
                },
                {
                    "text":"{{$catserch[$i+1]['Category']}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$i+1]['id'],"path"=>"sabtemakan@regplace"])}}"
                }
            ],   
        @endfor 
           [
                {
                    "text":"{{$catserch[$count-1]['Category']}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$count-1]['id'],"path"=>"sabtemakan@regplace"])}}"
                }
            ]
    @endif
        
    ]
}