<?php

namespace App\Magazines;
use App\Member;
use XB\theory\Magazine;
use XB\theory\telegramCollection;
use XB\telegramMethods\sendMessage;
use XB\telegramObjects\ReplyKeyboardMarkup;
use XB\telegramObjects\KeyboardButton;


class start extends Magazine {

	public function showMenu( $u ) {
		
		unset($this->meet["placename"]);
		if (empty($this->update->message->chat->id))
        { 
	        $send = new sendMessage( [
			'chat_id'=>$this->update->callback_query->message->chat->id,
            'message_id'=>$this->update->callback_query->message->message_id,
			'text'         => "کاربر گرامی خوش آمدید",
			'parse_mode'   => 'html',
			'reply_markup' => json_encode( [
				'keyboard'          => [
					 [ 'جستجو مکان' ],
					 [ 'مکان من'],
					[ 'درباره ربات' ],
				],
				'resize_keyboard'   => true,
				'one_time_keyboard' => true,
			] ),
		] );
	
			if ( ! $send() ) {
			\Storage::append( 'updates/last.json', "error: " . $send->getError() );
			}
	   }

	   else{ 

		if(Member::where('user_id',$u->message->from->id)->count()==0){           
			Member::create( [
				'user_id'    => $u->message->from->id,
				'first_name' => $u->message->from->first_name,
				'username'   => empty($u->message->from->username)?'':$u->message->from->username,
				'last_name'   => empty($u->message->from->last_name)?'':$u->message->from->last_name,
			] );
		}

		$send = new sendMessage( [
			'chat_id'      => $u->message->chat->id,
			'text'         => "کاربر گرامی " . $u->message->from->first_name . " عزیز خوش آمدید.",
			'parse_mode'   => 'html',
			'reply_markup' => json_encode( [
				'keyboard'          => [
					 [ 'جستجو مکان' ],
					 [ 'مکان من'],
					[ 'درباره ربات' ],
				],
				'resize_keyboard'   => true,
				'one_time_keyboard' => true,
			] ),
		] );
	
			if ( ! $send() ) {
				\Storage::append( 'updates/last.json', "error: " . $send->getError() );
			}
	   }
	}
	public function registerplace( $u ){
		unset($this->meet["editplc"]);
		unset($this->meet["placename"]);
		$user_id=$this->update->message->chat->id;
		$dbuser=\App\regplaceUser::pluck('user_id')->toArray();
		$serch=array_search($user_id,$dbuser);
		
		if ($serch===false&&$serch!==0){
		$data=\App\regplaceUser::get();
		$dbuser=\App\regplaceUser::pluck('user_id')->toArray();
		$send = new sendMessage( [
			'chat_id'      => $u->message->chat->id,
			'text'         => "یکی رو انتخاب کن",
			'parse_mode'   => 'html',
			'reply_markup' => json_encode( [
				'keyboard'          => [
					
					 [ 'ثبت مکان من' ],
					[ 'بازگشت' ],
				],
				'resize_keyboard'   => true,
				'one_time_keyboard' => true,
			] ),
		] );
	
		if ( ! $send() ) {
			\Storage::append( 'updates/last.json', "error: " . $send->getError() );
		}
	}
	else{
		$send = new sendMessage( [
			'chat_id'      => $u->message->chat->id,
			'text'         => "یکی رو انتخاب کن",
			'parse_mode'   => 'html',
			'reply_markup' => json_encode( [
				'keyboard'          => [
					
					 [ 'ویرایش مکان من' ],
					[ 'بازگشت' ],
				],
				'resize_keyboard'   => true,
				'one_time_keyboard' => true,
			] ),
		] );
	
		if ( ! $send() ) {
			\Storage::append( 'updates/last.json', "error: " . $send->getError() );
		}
	}
	}

	public function aboutUs( $u ) {
		unset($this->meet["placename"]);
		$send = new sendMessage( [
			'chat_id'    => $u->message->chat->id,
			'text'       => " ربات مکان یاب تو قم " .
			                "\n نسخه 1.0.0" . "\n\n ارتباط با پشتیبانی : " ."@MasumeAhmadi\n@moctabaxani",
			'parse_mode' => 'html',
		] );
		if ( ! $send() ) {
			\Storage::append( 'updates/last.json', "error: " . $send->getError() );
		}

	}

}
