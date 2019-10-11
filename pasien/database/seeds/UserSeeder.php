<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->idUser = $user->getIDUser();
        $user->namaUser = 'Administrator';
        $user->email = "it@puribunda.com";
        $user->password = Hash::make('superuser');
        $user->username = 'superuser';
        $user->canAdmin = true;
        $user->canInsert = true;
        $user->canUpdate = true;
        $user->canDelete = true;
        $user->canEkspor = true;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();

        $user = new User;
        $user->idUser = 'SYSTEM';
        $user->namaUser = 'SYSTEM';
        $user->email = "system@puribunda.com";
        $user->password = Hash::make('SYSTEM');
        $user->username = 'SYSTEM';
        $user->canAdmin = true;
        $user->canInsert = true;
        $user->canUpdate = true;
        $user->canDelete = true;
        $user->canEkspor = true;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
    }
}
