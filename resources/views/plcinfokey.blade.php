{
    "inline_keyboard":[
        [
            {
                "text":"📝📍اطلاعات مکان",
                "callback_data":"{!! interlink(["id"=>$id,"path"=>"makanyab@contactinfo"])!!}"
            }
        ],
        [
            {
                "text":"▶️بازشگت به قبلی",
                "callback_data":"{!! interlink(["path"=>"makanyab@lastplace","text"=>"b","loc"=>$locationID,"cor"=>"1"])!!}"
            },

            {
                "text":"⏩بازگشت به منو اصلی",
                "callback_data":"{!! interlink(["text"=>"back","path"=>"makanyab@makanemoredenazar","id"=>0])!!}"
            }
        ] 
      

    ]
}