<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'Member', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'user_id' )->unique();
			$table->string( 'first_name');
			$table->string( 'last_name' )->nullable();
			$table->string( 'username' )->nullable();
			$table->timestamps();
			$table->softDeletes();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'Member' );
	}
}