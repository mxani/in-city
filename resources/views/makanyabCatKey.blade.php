{
    "inline_keyboard":[
        @for($i=0;$i<count($catserch);$i+=2) 
            @if(count($catserch)%2==0)
            @if($i!==0&&$j!==0)
            ,
            @endif
            [
                {
                    "text":"{{$catserch[$i]->Category}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$i]->id,"path"=>"makanyab@makanemoredenazar"])}}"
                },
                {
                    "text":"{{$catserch[$i+1]->Category}}",
                    "callback_data":"{{ interlink(["id"=>$catserch[$i+1]->id,"path"=>"makanyab@makanemoredenazar"])}}"
                }
            ]
            @if($i<count($catserch)-2 && $j==0)
            ,
            @endif
           
            @else
                @if($i<count($catserch)-2)
               [
                    {
                        "text":"{{$catserch[$i]->Category}}",
                        "callback_data":"{{ interlink(["id"=>$catserch[$i]->id,"path"=>"makanyab@makanemoredenazar"])}}"
                    },
                    {
                        "text":"{{$catserch[$i+1]->Category}}",
                        "callback_data":"{{ interlink(["id"=>$catserch[$i+1]->id,"path"=>"makanyab@makanemoredenazar"])}}"
                    }
                ]
                @else
                  [
                    {
                        "text":"{{$catserch[$i]->Category}}",
                        "callback_data":"{{ interlink(["id"=>$catserch[$i]->id,"path"=>"makanyab@makanemoredenazar"])}}"
                    }
                ]
                @endif
            @endif
        @endfor
        @if($j!==0&&$parentID!==0)
                [
                    {
                        "text":"بازگشت",
                        "callback_data":"{{ interlink(["id"=>$parentID,"path"=>"makanyab@makanemoredenazar","text"=>"b"])}}"
                    }
                ]
        @endif       
    ]
}