<?php

use Illuminate\Database\Seeder;
use App\User;
use App\NoticeType;
use App\Notice;
use App\Option;
use App\Item;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        NoticeType::create([
            'user_id' => 1,
            'name' => 'notice1'
        ]);

        NoticeType::create([
            'user_id' => 1,
            'name' => 'notice2'
        ]);

        NoticeType::create([
            'user_id' => 1,
            'name' => 'notice3'
        ]);

        Notice::create([
            'user_id' => 1,
            'notice_type_id' => 1,
            'title' => 'Feriado por el día del Ministerio',
            'description' => 'Se otorga feriado el día de mañana por el día conmemorativo del Ministerio',
            'document' => 'Documento'
        ]);

        Option::create([
            'user_id' => 1,
            'name' => 'Normativas'
        ]);

        Item::create([
            'user_id' => 1,
            'option_id' => 1,
            'name' => 'Ley 1178',
            'description' => 'Esta ley esta aplicada a las entidades publicas',
            'document' => 'Documento'
        ]);
    }
}
