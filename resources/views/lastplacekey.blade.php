{
    "inline_keyboard":[
    @if(count($maxzan)%2==1)
        @for($r=0;$r<count($maxzan)-2;$r+=2)
        [
            {
                "text":"{{$maxzan[$r]['place']}}",
                "callback_data":"{!! interlink(["path"=>"makanyab@placeinfo","id"=>$maxzan[$r]['id']])!!}"
            },
            {
                "text":"{{$maxzan[$r+1]['place']}}",
                "callback_data":"{!! interlink(["path"=>"makanyab@placeinfo","id"=>$maxzan[$r+1]['id']])!!}"
            }
        ],
        @endfor
        [ 
        {
                "text":"{{end($maxzan)['place']}}",
                "callback_data":"{!! interlink(["path"=>"makanyab@placeinfo","id"=>end($maxzan)['id']])!!}"
            }
        ],
        [ 
        {
                "text":"بازگشت به منواصلی",
                "callback_data":"{!! interlink(["text"=>"back","path"=>"makanyab@makanemoredenazar","id"=>0])!!}"
            },
            {
                "text":"بازگشت به قبلی ",
                "callback_data":"{!! interlink(["text"=>"b","path"=>"makanyab@local","id"=>$maxzan[0]['parentID']])!!}"
            }
        ]
        @endif
    @if(count($maxzan)%2==0)
        @for($r=0;$r<count($maxzan)-1;$r+=2)
          [
        
            {
                "text":"{{$maxzan[$r]['place']}}",
                "callback_data":"{!! interlink(["path"=>"makanyab@placeinfo","id"=>$maxzan[$r]['id']])!!}"
            },
            {
                "text":"{{$maxzan[$r+1]['place']}}",
                "callback_data":"{!! interlink(["path"=>"makanyab@placeinfo","id"=>$maxzan[$r+1]['id']])!!}"
            }
        ],
        @endfor
         [ 
        {
                "text":"بازگشت به منواصلی",
                "callback_data":"{!! interlink(["text"=>"back","path"=>"makanyab@makanemoredenazar","id"=>0])!!}"
            },
            {
                "text":"بازگشت به قبلی ",
                "callback_data":"{!! interlink(["text"=>"b","path"=>"makanyab@local","id"=>$maxzan[0]['parentID']])!!}"
            }
        ]
        @endif
  ]
}