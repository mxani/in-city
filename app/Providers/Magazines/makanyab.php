<?php
/**
* tuqom-bot.php 
* @author:m.ahmadi
* @creation date:1396.7.11
* @last modification date:1396.8.15
* @version:1.0.0
* @purpose of program:this program is a telegram bot .
* this help to find place that you want.this bot contain 3 main part:
* 1-serch place 2-register place 3- edite place
* user step by step select between keys the categori that he serchs it
* at last Is shown the place that user serched 
* there are two limitaion:1-the user can show 10 time place info 2-the user can register one place
* @change history:change word by word serch to select between category
* add register &edite place property
* optimization the program (select by where() form DB isted get())
* make keys in blade mode 
* add emogies and create better gui
* @Dependencies:mysql serveic(6DB must migrate),telegram app,bizinehrud lib

*/
namespace App\Magazines;
use App\places;
use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;

class makanyab extends Magazine{

    public function makanemoredenazar(){
    /**
     * makanemoredenazar
     * 
     * this function show frist from when click to جستجور مکان key 
     * and genrate categorys key 
     * 
     * @param (string) ($catserch) find id that Submitted by clicked key's callback_data 
     * @param (string) ($parentID) find parentID that Submitted by clicked key's callback_data 
     * @param (integer) ($j) get clicked keys id 
     * @param (meet)   (cat) contain categoris name and shown top of the send message
     */
        if ($this->detect->type=='callback_query')
        {
            /**
             * this "if" for that detect is the request(جستجو مکان) frist time run or 
             * category selected
             */
            $j=$this->detect->data->id;
        }
        else { 
            $j=0;
        }
        $catserch=\App\categories::where("parentID",$j)->get();
        $parentID=\App\categories::find($j)->parentID??0;
        $send=sendMessage::class;
        $message=[
            'chat_id'=>$this->detect->from->id,
            'text'=>"دنبال چی  می گردی❗️",
            'parse_mode'=>'html',
            'reply_markup'=>view('makanyabCatKey',['j'=>$j,'catserch'=>$catserch,'parentID'=>$parentID])->render(),
        ];

        if($this->detect->type=='callback_query')
        {
            $id=$this->detect->data->id;
            $this->meet["cat"][0]="🔆دسته ها";
            if(!empty($this->detect->data->text)&&$this->detect->data->text=="b")
            {
            
                array_pop($this->meet["cat"]);
                //>when click back botunm must be delted last item in array meet["cat"]
                $message['text']="دنبال چی  می گردی❗️"."\n".implode("<code> » </code>",$this->meet["cat"]);
            }
            else
            {
                if ($id!=0)
                {  
                    $cat=\App\categories::find($id)->Category;
                    array_push($this->meet["cat"],$cat);
                    //>add new category name to meet["cat]
                    $message['text']="دنبال چی می گردی❗️️️️"."\n".implode("<code> » </code>",$this->meet["cat"]);
                }
                else
                {
                    unset($this->meet["cat"]);
                    //>in the frist menue there isnot category then must unset "cat"
                }
            }

            $message['message_id']=$this->update->callback_query->message->message_id;
          
            if (!empty(\App\categories::where("parentID",$id)->first())) 
            {
                //>this if decleare that is this category last category ?
                $send=editMessageText::class;
                $send= new $send($message);
                $send();
            }
            else
            {
               
               $this->local();
            
            }
        }
        else
        {
            $messege['text']=  "دنبال چی می گردی❗️";
            $send= new $send($message);
            $send();
        }

    }

    public function local(){ 
       /** local
        * this function for show & generate locatin keys 
        *
        *@param (string) (lastid) save last category id and stay on callback_data mean in evry 
        *location key is last category id 
        */ 

        $count=\App\locations::count();
        //>this @param is sent to view
        $lastid=$this->detect->data->id;
        //>this @param is sent to view
        $id=$this->detect->data->id;
        $parentID=\App\categories::find($id)->parentID;
        //>this @param is sent to view
        $leftover=$count%3;
         /** @param (integer) (leftover) in here we want create 3 columns so gain lafte over 
          * this param is sent to view
          * if left over is 0 we have complet 3 columns
          *if left over is 1 we have complet 3 cloumns and one left over
          *if left over is 2 we have complet 3 cloumns and two left over
         */
        $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$this->update->callback_query->message->message_id,
            'text'=> "کجا می خوای بگردی ❗️"."\n".implode("<code> » </code>",$this->meet["cat"]),
            'parse_mode'=>'html',
            'reply_markup'=>view('makanyabLocKey',['count'=>$count,'parentID'=>$parentID,'lastid'=>$lastid,'leftover'=>$leftover])->render(),
            ]);
        $send();
        
    }

    public function lastplace($u)
    {  
        /** lastplace
         * this function for show resullt the places finded
         * 
         * 
         */
      
       if (empty($this->detect->data->cor))
       {
           ///>$this->detect->data->cor this when has value that click on back botunm 
        $this->meet["lastid"]=$this->detect->data->lastid;
       }
        $count=\App\places::count();        
        $idplace=$this->meet["lastid"]; 
        $dataplc=\App\places::find($idplace);
        if (empty($this->detect->data->loc))
        {
           ///>$this->detect->data->loc this when has value that click on back botunm 
            $idlocation=$this->detect->data->id;
        }
        else{$idlocation=$this->detect->data->loc;}
        $maxzan=[];$finalplace=[];$keys=[];
        $maxzan= \App\places::where('parentID',$idplace)->where('locations_id',$idlocation)->get()->toArray();
        ///>@param (array) ($maxzan) find items that have location_id & parentID that selected by user
        if(empty($maxzan)){
            $this->notfound();
            ///>this function for error
        }
        else{  
        if(!empty($this->detect->data->text)&&$this->detect->data->text=="b"){
            ///>this function for category and location that show top of the text message
            $id=$this->detect->data->loc;}
            ///>@param ($id) for get location name
        else{
                $id=$this->detect->data->id;
                ///>when $this->detect->data->text=="b" is empty means this step is next step and dident click on back key
                ///>so data->id is location id 
        }   
       $location=\App\locations::find($id)->local; 
        ///>@param ($location) is value show on top of text message
        $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$u->callback_query->message->message_id,
                'text'=> "مکان های مورد نظر شما"."\n".implode("<code> » </code>",$this->meet["cat"])."\n"."🔸محله:  " .$location,
                'parse_mode'=>'html',
                'reply_markup'=>view('lastplacekey',['maxzan'=>$maxzan])->render(),
                ]);
            $send();
       }
  
    }
    public function notfound(){ 
        /**
        *this function run whene no item in category is error function
        */
        $locationID=\App\places::where("id",$this->detect->data->id)->get()->first()->locations_id;//baraye blade ezafe shod
        $lastid=$this->detect->data->lastid??0;//baraye blade ezafe shod
         $send=new editMessageText([
            'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$this->update->callback_query->message->message_id,
            'text'=>"❌چنین موردی وجود ندارد❌ " ,
            'parse_mode'=>'html',
            'reply_markup'=>view('backkey',['locationID'=>$locationID,'lastid'=>$lastid])->render(),
            ] );
        $send();
      
    }

    public function placeinfo($u){
        /**
        *this function for show summary of data to user 
        *show this step just name place and pic and no limitation for this step
        */

       $id=$this->detect->data->id;
       $locationID=\App\places::where("id", $id)->get()->first()->locations_id;
       $data=\App\places::where("id", $id)->get()->first();
       $text="<a href=\"$data->pic\">&#8205;</a>\n ".
             "📍نام مکان:". $data->place."\n";
          
       $send=new editMessageText([
        'chat_id'=>$this->update->callback_query->message->chat->id,
        'message_id'=>$u->callback_query->message->message_id,
        'text'=>$text ,
        'parse_mode'=>'html',
        'reply_markup'=>view('plcinfokey',['locationID'=>$locationID,'id'=>$id])->render(),
        
        ]);
      $send();

    }

    public function contactinfo ($u){
        /**
        *this function show all of data to user &have limitition
        */
        $this->meet["correction"]="yes";
        $id=$this->detect->data->id;
        $this->timesUse($id); 
        ///>here the program to the timeuse function to calcute times use user @arguman $id
        if (!empty($this->meet["limite"])&&$this->meet["limite"]=="yes"){
            ///>this function for whene the >meet["limite"]=="yes" &we want program did not run continu
        }
        else{
        $locationID=\App\places::where("id",$this->detect->data->id)->get()->first()->locations_id;
        $lastid=$this->detect->data->lastid??0;
        $data=\App\places::where("id", $id)->get()->first();
        $location=\App\locations::where("id",  $data->locations_id)->get()->first();
        $categori=\App\categories::where("id",  $data->parentID)->get()->first();
        $text="<a href=\"$data->pic\">&#8205;</a>\n ".
              "📍"."مکان:". $data->place."\n".
              "☎️"."تلفن تماس:".$data->phone."\n".
              "📝"."ادرس:".$data->adress."\n".
              "🌐"."صفحه وب".$data->webpage."\n".   
              "📌"."دسته:".$categori->Category."\n".
              "🏙". "محله:".$location->local."\n";
        $send=new editMessageText([
         'chat_id'=>$this->update->callback_query->message->chat->id,
         'message_id'=>$u->callback_query->message->message_id,
         'text'=>$text ,
         'parse_mode'=>'html',
         'reply_markup'=>view('backkey',['locationID'=>$locationID,'lastid'=>$lastid])->render(),
         
         ]);
         $send();
         
        }
      unset($this->meet["limite"]);
    }

    public function timesUse ($id){
    /**
    *this function for cacute how many user use db data 
    *when user first time click the contact info the user_id's save in timeUse tabel in db
    *then eche time click contact info save the user_id's whene time use mor than 5 the programe give erorr
    */
         $user_id=$this->update->callback_query->message->chat->id;
         $count=\App\timesUse::count();
       //  $data=\App\timesUse::get();
         $time=date('Y-m-d H:i:s');
         ///>get time now 
         $y=0;$x=0;$maxzan=[];$i=0;
         $dbuser=\App\timesUse::pluck('user_id')->toArray();
         \App\timesUse::insert(
            ['user_id'=>$user_id,'placeID'=>$id,"created_at"=>$time]
            );  ///>insert user_id to db
            $maxzan=\App\timesUse::where('user_id', $user_id)->get(); 
            $arraymaxzan=$maxzan->pluck('created_at');
            foreach ($arraymaxzan as $value) {
                $arraymaxzan[$i]=$value->timestamp;
                $i+=1;
            }
            $today=$maxzan->last()->created_at->timestamp;
            ///>get last use timestamp
            $yeste=$today-(86400);  ///>get yeterday timestamp and count between today and yeterday  how meny time used
            for($j=0;$j<count($arraymaxzan);$j++){
            if($arraymaxzan[$j]>$yeste&&$arraymaxzan[$j]<$today){
                $x+=1;
            }
      }
          if ($x>5){
            $locationID=\App\places::where("id",$this->detect->data->id)->get()->first()->locations_id;///>added for blade
            $lastid=$this->detect->data->lastid??0;///>added for blade
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"❌شما بیش از 20 بار از این قابلیت استفاده کرده اید❌" ,
                'parse_mode'=>'html',
                'reply_markup'=>view('backkey',['locationID'=>$locationID,'lastid'=>$lastid])->render(),
                ] );
                $send();
               $this->meet["limite"]="yes";
            }
        
    }
}