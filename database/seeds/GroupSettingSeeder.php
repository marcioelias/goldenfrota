<?php

use Illuminate\Database\Seeder;

class GroupSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Limpando tabela de Configurações');
        $this->truncateSttingsTables();

        $this->command->info('Criando configurações');

        DB::table('group_settings')->insert([
            [
                'id' => 1,
                'group_name' => 'Conta FTP'
            ]
        ]);

        DB::table('settings')->insert([
            [
                'description' => 'Servidor FTP',
                'key' => 'ftp_server',
                'value' => 'localhost',
                'data_type' => 'string',
                'group_setting_id' => 1
            ],
            [
                'description' => 'Usuário FTP',
                'key' => 'ftp_user',
                'value' => 'annonymous',
                'data_type' => 'string',
                'group_setting_id' => 1
            ],
            [
                'description' => 'Senha FTP',
                'key' => 'ftp_pass',
                'value' => 'secret',
                'data_type' => 'string',
                'group_setting_id' => 1
            ],
            [
                'description' => 'Porta',
                'key' => 'ftp_port',
                'value' => '21',
                'data_type' => 'integer',
                'group_setting_id' => 1
            ],
            [
                'description' => 'Diretório Raíz',
                'key' => 'ftp_root',
                'value' => '',
                'data_type' => 'string',
                'group_setting_id' => 1
            ],
            [
                'description' => 'Modo Passivo',
                'key' => 'ftp_passive',
                'value' => 1,
                'data_type' => 'boolean',
                'group_setting_id' => 1
            ],
            [
                'description' => 'SSL',
                'key' => 'ftp_ssl',
                'value' => 0,
                'data_type' => 'boolean',
                'group_setting_id' => 1
            ],
            [
                'description' => 'Tempo limite',
                'key' => 'ftp_timeout',
                'value' => '30',
                'data_type' => 'integer',
                'group_setting_id' => 1
            ]
        ]);
    }

    public function truncateSttingsTables() {
        Schema::disableForeignKeyConstraints();
        DB::table('settings')->truncate();
        DB::table('group_settings')->truncate();
        \App\Setting::truncate();
        \App\GroupSetting::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
