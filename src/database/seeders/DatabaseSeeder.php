<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Auth;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Genre::factory(10)->create();
        Author::factory(10)->create();
        Book::factory(100)->create();
    }
}
