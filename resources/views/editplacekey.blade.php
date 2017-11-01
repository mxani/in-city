{
    "inline_keyboard":[
    
        [
            {
                "text":"ویرایش نام مکان",
                "callback_data":"{!! interlink(["path"=>"editeplc@editeplace"])!!}"
            },
            {
                "text":"ویرایش تلفن",
                "callback_data":"{!! interlink(["path"=>"editeplc@editephone"])!!}"
            }
        ],
        [ 
            {
                "text":"ویرایش آدرس",
                "callback_data":"{!! interlink(["path"=>"editeplc@editeadress"])!!}"
            },
            {
                "text":"ویرایش وب",
                "callback_data":"{!! interlink(["path"=>"editeplc@editeweb"])!!}"
            }
        ],
        [ 
            {
                "text":"ویرایش عکس",
                "callback_data":"{!! interlink(["path"=>"editeplc@editepic"])!!}"
            },
            {
                "text":"ویرایش محله و دسته",
                "callback_data":"{!! interlink(["path"=>"sabtemakan@local"])!!}"
            }
        ],
        [ 
            {
                "text":"بازگشت",
                "callback_data":"{!! interlink(["path"=>"sabtemakan@local"])!!}"
            }
        ]
   
  
    ]
}