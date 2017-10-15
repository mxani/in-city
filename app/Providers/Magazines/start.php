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

	public function aboutUs( $u ) {
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
