<?php

namespace Database\Seeders;

use App\Models\Contatto;
use App\Models\ContattoIndirizzi;
use App\Models\Contatto_Recapiti;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContattoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name'=>'marco','email'=>'marco.rossi@example.it']);
        User::create(['name'=>'luca','email'=>'luca.bianchi@example.it']);
    }
}
