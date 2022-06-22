<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\AdminUsers;

class CreateAdmin extends Command
{
    protected $signature = 'create:Admin';
    protected $description = '管理者ユーザを作成';

    public function handle()
    {
        $judge = true;
        while ($judge) {
            $email = $this->ask('メールアドレスを入力');
            $existsOrNot = AdminUsers::where('email', $email)->exists();

            if ($existsOrNot) {
                $this->line('このメールアドレスは既に存在します');
            } else {
                $judge = false;
            }
        }

        $password = $this->secret('パスワードを入力');
        $display_name = $this->ask('表示名');
        $role = $this->ask('役割 1:開発者, 2:管理者, 3:運用者, 4:閲覧のみ');

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        AdminUsers::create([
            'email' => $email,
            'password' => $hash_password,
            'display_name' => $display_name,
            'role' => $role,
        ]);
    }
}