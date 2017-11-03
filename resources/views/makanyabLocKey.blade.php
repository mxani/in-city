{
    "inline_keyboard":[
  @for($i=0;$i<$count;$i+=3)
  @if(($i<$count-2&&$leftover==2)||($i<$count-1&&$leftover==1)||($leftover==0))
        [
                {
                    "text":"{{\App\locations::find($i+3)->local]}}",
                    "callback_data":"{{ interlink(["id"=>\App\locations::find($i+3)->id,"path"=>"makanyab@lastplace", "lastid"=>$this->detect->data->id])}}"
                },
                {
                    "text":"{{\App\locations::find($i+2)->local}}",
                    "callback_data":"{{ interlink(["id"=\App\locations::find($i+2)->id,"path"=>"makanyab@lastplace", "lastid"=>$this->detect->data->id])}}"
                }, 
                {
                    "text":"{{\App\locations::find($i+1)->local}}",
                    "callback_data":"{{ interlink(["id"=\App\locations::find($i+1)->id,"path"=>"makanyab@lastplace", "lastid"=>$this->detect->data->id])}}"
                }
            ],
  @endif
  @if($leftover==1&&$i==$count-1)
      ,[
                {
                    "text":"{{\App\locations::find($i+1)->local]}}",
                    "callback_data":"{{ interlink(["id"=>\App\locations::find($i+1)->id,"path"=>"makanyab@lastplace", "lastid"=>$this->detect->data->id])}}"
                }
        ]
  @endif
  @if($leftover==21&&$i==$count-2)
      ,[
                {
                    "text":"{{\App\locations::find($i+1)->local]}}",
                    "callback_data":"{{ interlink(["id"=>\App\locations::find($i+1)->id,"path"=>"makanyab@lastplace", "lastid"=>$this->detect->data->id])}}"
                },
                 {
                    "text":"{{\App\locations::find($i+2)->local]}}",
                    "callback_data":"{{ interlink(["id"=>\App\locations::find($i+2)->id,"path"=>"makanyab@lastplace", "lastid"=>$this->detect->data->id])}}"
                }
        ]
  @endif
  @endfor
   ,[ 
        {
                "text":"بازگشت به منواصلی",
                "callback_data":"{!! interlink(["text"=>"back","path"=>"makanyab@makanemoredenazar","id"=>0])!!}"
            },
            {
                "text":"بازگشت به قبلی ",
                "callback_data":"{!! interlink(["text"=>"b","path"=>"makanyab@makanemoredenazar","id"=>$parentID])!!}"
            }
        ]
    ]
    }