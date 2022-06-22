<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->Increments('id')->nullable(false)->unsigned();
            $table->string('email')->unique()->nullable(false)->comment('メールアドレス');
            $table->string('password')->nullable(false)->comment('パスワード');
            $table->string('display_name')->nullable(false)->comment('表示名');
            // $table->enum('role', ['developer','system_admin','operator','readonly'])->nullable(false)->default('operator')->comment("'developer: 開発者, system_admin: 管理者, operator: 運用者, readonly: 閲覧のみ'");
            $table->integer('role')->nullable(false)->default(3)->comment("'developer: 開発者, system_admin: 管理者, operator: 運用者, readonly: 閲覧のみ'");
            // $table->enum('active', ['yes','no'])->nullable(false)->default('yes')->comment('アカウントが有効かどうか。noならログインできない。');
            $table->integer('active')->nullable(false)->default(1)->comment('アカウントが有効かどうか。0ならログインできない。');
            $table->timestamp('created_at')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}