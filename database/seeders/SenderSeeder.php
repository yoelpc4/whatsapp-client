<?php

namespace Database\Seeders;

use App\Models\Sender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Sender::truncate();

        Schema::enableForeignKeyConstraints();

        Sender::factory()->count(20)->create();
    }
}
