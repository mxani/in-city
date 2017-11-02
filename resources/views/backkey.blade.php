{
    "inline_keyboard":[

[
    {
        "text":"⏩بازگشت به منواصلی",
        "callback_data":"{{ interlink(["text"=>"back","path"=>"makanyab@makanemoredenazar","id"=>0])}}"
    },
    @if($lastid!=0)
      {
        "text":"▶️بازگشت به قبلی",
        "callback_data":"{{ interlink(["path"=>"makanyab@local","id"=>$this->meet["lastid"],"text"=>"b"])}}"
    }
    @else
      {
        "text":"▶️بازگشت به قبلی",
        "callback_data":"{{ interlink(["path"=>"makanyab@lastplace","loc"=>$locationID,"text"=>"b","cor"=>"1"])}}"
    }
    @endif
 ]


    ]
}