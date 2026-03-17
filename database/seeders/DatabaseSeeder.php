<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with different roles
        User::factory()->count(2)->create(['role' => 'admin']);
        User::factory()->count(3)->create(['role' => 'organizer']);
        User::factory()->count(10)->create(['role' => 'customer']);

        // Create events, tickets, and bookings
        Event::factory()->count(5)->create();
        Ticket::factory()->count(15)->create();
        Booking::factory()->count(20)->create();
    }
}