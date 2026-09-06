<?php

namespace Database\Seeders;

use App\Models\Support\ContactMessage\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        ContactMessage::factory()->count(50)->create();
    }
}
