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
        //this variabels send to view
        unset($this->meet["placename"]);
        //this meet decleare next step has whitch  carteige .in the routs this Issue clear.
        if (empty($this->update->message->chat->id))
        { 
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=> "⭕️مکانی که می خوای ثبت کنی کجاهاست؟❗️",
                'parse_mode'=>'html',
                'reply_markup'=>view('locationkey',['data'=>$data,'local'=>$local])->render(),
                ]);
            $send();
        }
        else
        {
            $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                   'text'=> "⭕️مکانی که می خوای ثبت کنی کجاهاست؟❗️ ",
                   'parse_mode'=>'html',
                   'reply_markup'=>view('locationkey',['data'=>$data,'local'=>$local])->render(),
                   ]);
            $send(); 
            
        }
    }

    public function regplace($u)
    {
        if (!empty($this->detect->data->from))
        {
            $this->meet["recorde[6]"]=$this->detect->data->id;
            //the meet["recorde[]"] keeps vleue that user entered at the last this values insert to db 
            $j=0;
            //$j=0 for first time we want show category that parentid's is 0
        }
        else
        {
            $j=$this->detect->data->id;
            //$j has parentid value
        }
        
        $catserch=\App\categories::where("parentID",$j)->get()->toArray();
        $count=count($catserch);
        $id=$this->detect->data->id;
        if (!empty($catserch)||!empty($this->detect->data->from))
        {
           //this if cleare that There are still categories
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"💢مکان مورد نظر شما در کدام دسته جای دارد❗️",
                'parse_mode'=>'html',
                'reply_markup'=>view('categorykey',['catserch'=>$catserch,'count'=>$count])->render(),
            ]);
            $send();
        }
        else
        {
             //from this cartrige used in editplc magazin this part cleare regplace cartrige called on editplce magazin(whene click on editcat this key path is regplace and show categori and local at last in this part data send to db  ) 
            if (!empty($this->meet["editplc"])&&$this->meet["editplc"]==1)
            {
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
                'text'=>"🖊نام مکان مورد نظر خود را وارد کنید ",
                'parse_mode'=>'html',
                ]);
            $send();
            $this->meet["placename"]=1; 
            //difine meet["placename"] in here becuse regplace's work finished here and i want to gi next cartrige
        }
    
    }
    
    public function namereg($u)
    {
        if ($this->meet["placename"]==1) 
        {
            $this->meet["recorde[1]"]=$u->message->text;
            $send=new sendMessage([
            'chat_id'=>$this->update->message->chat->id,
            'text'=>  "☎️شماره تلفن  {$this->meet["recorde[1]"]}   را وارد کنید  ",
            'parse_mode'=>'html',
             ]);
            $send();
            $this->meet["placename"]=2;
        }
    }

    public function phonereg($u)
    {
        if ($this->meet["placename"]==2)
         {
            $this->meet["recorde[2]"]=$u->message->text;
             $send=new sendMessage([
              'chat_id'=>$this->update->message->chat->id,
              'text'=> "📝آدرس  {$this->meet["recorde[1]"]}  واردکنید",
              'parse_mode'=>'html',
               ]);
            $send();
            $this->meet["placename"]=3;
        }
    }

    public function adressreg($u)
    {
        if ($this->meet["placename"]==3)
        {
            $this->meet["recorde[3]"]=$u->message->text;
                $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> "🤖درصورتی  {$this->meet["recorde[1]"]}  آدرس سایت یا کانال تلگرام دارد. وارد کنید  ",
                'parse_mode'=>'html',
                'reply_markup' => json_encode( [
                    'keyboard'  => [
                         [ '❌ندارد' ],
                    
                    ],
                    'resize_keyboard'   => true,
                    'one_time_keyboard' => true,
                ] ),
            ] );
            $send();
           
            $this->meet["placename"]=4;
        }
    }

    public function webpagereg($u)
    {
        if($this->meet["placename"]==4)
        {
            $this->meet["recorde[4]"]=$u->message->text;     
            $text="اطلاعات وارد شده شما به شرح زیر است :"."\n"."\n".
            "🏢نام مکان:".$this->meet["recorde[1]"]."\n"."\n".
            "☎️شماره تلفن:".$this->meet["recorde[2]"]."\n"."\n".
            "📝آدرس:".$this->meet["recorde[3]"]."\n"."\n".
            "🌐صفحه وب:".$this->meet["recorde[4]"]."\n";
            $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> $text,
                'parse_mode'=>'html',
                'reply_markup' => json_encode( [
                    'keyboard'  => [
                         [ '✅تایید اطلاعات' ],
                         [ '⏩برگشت به مرحله اول' ],
                    ],
                    'resize_keyboard'   => true,
                    'one_time_keyboard' => true,
                ] ),
            ] );
            $send();
            $this->meet["placename"]=5; 
        } 
    }
                
    public function Confirmation($u)
    {
        $user_id=$this->update->message->chat->id;
        if ($u->message->text=='✅تایید اطلاعات')
        {
            $send=new sendMessage([
                'chat_id'=>$this->update->message->chat->id,
                'text'=> "مکان شما با موفقیت ثبت شد✅با تشکر از همکاری شما🌸🌼",
                'parse_mode'=>'html',
                'reply_markup' =>  json_encode( [
                    'keyboard'          => [
                            [ '🔎جستجو مکان' ],
                            [ '📍مکان من'],
                            [ '🤖درباره ربات' ],
                    ],
                    'resize_keyboard'   => true,
                    'one_time_keyboard' => true,
                ]),
            ]);
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

}

