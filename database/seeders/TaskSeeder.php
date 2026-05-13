<?php
namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{

    public function run(): void
    {

        Task::truncate();

        $tasks = [
            [
                'title'        => 'Set up Laravel project',
                'description'  => 'Install Laravel 10 via Composer, configure the .env file with database credentials, and run the initial migrations.',
                'is_completed' => true,
                'priority'     => 'high',
            ],
            [
                'title'        => 'Create Task model and migration',
                'description'  => 'Generate the Task Eloquent model with its migration file. Define columns: title, description, is_completed, priority.',
                'is_completed' => true,
                'priority'     => 'high',
            ],
            [
                'title'        => 'Build TaskController with CRUD methods',
                'description'  => 'Implement the 7 resource methods: index, create, store, show, edit, update, destroy.',
                'is_completed' => true,
                'priority'     => 'high',
            ],
            [
                'title'        => 'Design Blade views for tasks',
                'description'  => 'Create the layout template and four child views: index, create, edit, show. Add Bootstrap styling.',
                'is_completed' => false,
                'priority'     => 'medium',
            ],
            [
                'title'        => 'Add form validation rules',
                'description'  => 'Use $request->validate() in the store() and update() methods. Show error messages in views using @error directives.',
                'is_completed' => false,
                'priority'     => 'medium',
            ],
            [
                'title'        => 'Write feature tests for CRUD',
                'description'  => 'Write PHPUnit/Pest feature tests that test creating, reading, updating, and deleting tasks via HTTP.',
                'is_completed' => false,
                'priority'     => 'low',
            ],
            [
                'title'        => 'Add user authentication with Laravel Breeze',
                'description'  => 'Run: composer require laravel/breeze && php artisan breeze:install. This adds login, register, and password reset.',
                'is_completed' => false,
                'priority'     => 'medium',
            ],
            [
                'title'        => 'Deploy to production server',
                'description'  => 'Configure .env for production, run migrations, set up queue worker, configure web server (Nginx/Apache).',
                'is_completed' => false,
                'priority'     => 'low',
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }

        $this->command->info('✅  ' . count($tasks) . ' demo tasks seeded successfully!');
    }
}
