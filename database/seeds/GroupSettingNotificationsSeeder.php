<?php

use Illuminate\Database\Seeder;

class GroupSettingNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = \App\GroupSetting::create([
            'group_name' => 'Notificações'
        ]);

        $group->settings()->createMany([
            [
                'description' => 'Notificação de produtos Vencidos - Dias',
                'key' => 'notification_product_days',
                'data_type' => 'integer',
                'value' => 30
            ],
            [
                'description' => 'Notificação de produtos Vencidos - Km',
                'key' => 'notification_product_km',
                'data_type' => 'double',
                'value' => 100
            ],
            [
                'description' => 'Notificação de produtos Vencidos - Horas',
                'key' => 'notification_product_hours',
                'data_type' => 'double',
                'value' => 30
            ]
        ]);
    }
}
