{
    "inline_keyboard":[
     @for($i=0;$i<count($data);$i++)
       
         @if($parentID[$i]==$j)
         
           [
             {
                "text":"{{$data[$i]->Category}}",
                "callback_data":"{!! interlink(["id"=>$data[$i]->id,"path"=>"sabtemakan@regplace"])!!}"                
             }
             ],
             
        @endif
               
        @endfor
    ]
    }