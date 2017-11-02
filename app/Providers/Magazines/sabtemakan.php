<?php

namespace App\Magazines;

use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class sabtemakan extends Magazine
{


    public function local($u)
    {
        $data=\App\locations::get();
        $local=\App\locations::pluck('local')->toArray();
        unset($this->meet["placename"]);
        if (empty($this->update->message->chat->id))
        { 
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$this->update->callback_query->message->message_id,
               'text'=> "مکانی که می خوای ثبت کنی کجاهاست؟ ",
               'parse_mode'=>'html',
               'reply_markup'=>view('locationkey',['data'=>$data,'local'=>$local])->render(),
               ]);
           $send();
         }
         else{
            $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                   'text'=> "مکانی که می خوای ثبت کنی کجاهاست؟ ",
                   'parse_mode'=>'html',
                   'reply_markup'=>view('locationkey',['data'=>$data,'local'=>$local])->render(),
                   ]);
               $send(); 
            
         }
    }

    public function regplace($u)
    {
        if (!empty($this->detect->data->from)) {
            $this->meet["recorde[6]"]=$this->detect->data->id;
                $j=0;
        }
         else {
            $j=$this->detect->data->id;
        }
        
        $catserch=\App\categories::where("parentID",$j)->get()->toArray();//dd($catserch[1]['Category']);
        $count=count($catserch);
   //     $data=\App\categories::get();
    //    $parentID=\App\categories::pluck('parentID')->toArray();
        $id=$this->detect->data->id;
        if (!empty($catserch)||!empty($this->detect->data->from)) {
           
            $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$this->update->callback_query->message->message_id,
            'text'=>"مکان مورد نظر شما در کدام دسته جای دارد ",
            'parse_mode'=>'html',
            'reply_markup'=>view('categorykey',['catserch'=>$catserch,'count'=>$count])->render(),
            ]);
            $send();
        }
        else { 
            if (!empty($this->meet["editplc"])&&$this->meet["editplc"]==1){
                $this->meet["recorde[5]"]=$this->detect->data->id ;
                $user_id=$this->update->callback_query->message->chat->id;
                unset($this->meet["editplc"]);
                \App\places::
                where('user_id',$user_id)
                ->update(['locations_id'=> $this->meet["recorde[6]"],'parentID'=>$this->meet["recorde[5]"]]);
                $this->caller(editeplc::class)->editeplcinfo();
                return; 
            }
            $this->meet["recorde[5]"]=$this->detect->data->id ;
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"نام مکان مورد نظر خود را وارد کنید ",
                'parse_mode'=>'html',
                
                ]);
            $send();
            $this->meet["placename"]=1; 
        }
    
   }
    
    public function namereg($u)
    {
 
        if ($this->meet["placename"]==1) {
            $this->meet["recorde[1]"]=$u->message->text;
            $send=new sendMessage([
            'chat_id'=>$this->update->message->chat->id,
            'text'=>  "شماره تلفن  {$this->meet["recorde[1]"]}   را وارد کنید  ",
            'parse_mode'=>'html',
       
            ]);
            $send();
            $this->meet["placename"]=2;
        }
    }

    public function phonereg($u)
    {

        if ($this->meet["placename"]==2) {
            $this->meet["recorde[2]"]=$u->message->text;
             $send=new sendMessage([
              'chat_id'=>$this->update->message->chat->id,
              'text'=> "آدرس  {$this->meet["recorde[1]"]}  واردکنید",
              'parse_mode'=>'html',
             
              ]);
            $send();
            $this->meet["placename"]=3;
        }
    }
    public function adressreg($u)
    {
        
        if ($this->meet["placename"]==3) {
            $this->meet["recorde[3]"]=$u->message->text;
                $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> "درصورتی  {$this->meet["recorde[1]"]}  آدرس سایت یا کانال تلگرام دارد. وارد کنید  ",
                'parse_mode'=>'html',
                'reply_markup' => json_encode( [
                    'keyboard'  => [
                         [ 'ندارد' ],
                    
                    ],
                    'resize_keyboard'   => true,
                    'one_time_keyboard' => true,
                ] ),
            ] );
            $send();
           // if (!$u->message->text=="ندارد"){
            $this->meet["placename"]=4;//}
        }
    }
    public function webpagereg($u)
    {

        if($this->meet["placename"]==4){
            $this->meet["recorde[4]"]=$u->message->text;     
            $text="اطلاعات وارد شده شما به شرح زیر است :"."\n".
            "place:".$this->meet["recorde[1]"]."\n".
            "phone:".$this->meet["recorde[2]"]."\n".
            "adress:".$this->meet["recorde[3]"]."\n".
            "webpage:".$this->meet["recorde[4]"];
            $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> $text,
                'parse_mode'=>'html',
                'reply_markup' => json_encode( [
                    'keyboard'  => [
                         [ 'تایید اطلاعات' ],
                         [ 'برگشت به مرحله اول' ],
                    ],
                    'resize_keyboard'   => true,
                    'one_time_keyboard' => true,
                ] ),
            ] );
            $send();
            $this->meet["placename"]=5; }  }
                
    public function Confirmation($u)
            {
                $user_id=$this->update->message->chat->id;
                if ($u->message->text=='تایید اطلاعات'){
                $send=new sendMessage([
                    'chat_id'=>$this->update->message->chat->id,
                    'text'=> "مکان شما با موفقیت ثبت شد .با تشکر از همکاری شما عزییییییزم",
                    'parse_mode'=>'html',
                    'reply_markup' =>  json_encode( [
                        'keyboard'          => [
                             [ 'جستجو مکان' ],
                             [ 'مکان من'],
                            [ 'درباره ربات' ],
                        ],
                        'resize_keyboard'   => true,
                        'one_time_keyboard' => true,
                    ] ),
                ] );
                    $send();
                
                \App\places::insert(
                ['user_id'=>$this->update->message->chat->id,'locations_id'=> $this->meet["recorde[6]"],'parentID'=>$this->meet["recorde[5]"],'place' =>$this->meet["recorde[1]"] , 'phone' =>$this->meet["recorde[2]"],'adress'=>$this->meet["recorde[3]"] ,'webpage'=>$this->meet["recorde[4]"] ,'pic'=>'hugu','tag'=>'jhg','sign'=>'gygy']
                );
                \App\regplaceUser::insert(
                    ['user_id'=>$user_id]
                    ); 
                unset($this->meet["placename"]);
            }
            }


    public function catkey()
    {
        $keys=[];
        $data=\App\categories::get();
        $parentID=\App\categories::pluck('parentID')->toArray();
        if (!empty($this->detect->data->from)) {
            $j=0;
        } else {
            $j=$this->detect->data->id;
        }
        for ($i=0; $i<count($data); $i++) {
            if ($parentID[$i]==$j) {
                $keys[]=[
                    [
                        "text"=>$data[$i]->Category,
                        "callback_data"=>interlink([
                            "id"=>$data[$i]->id,
                            "path"=>"sabtemakan@regplace",
                        ])
                    ]
                ];
            }
        }
       
        return json_encode(["inline_keyboard"=> $keys ]);
    }


}

