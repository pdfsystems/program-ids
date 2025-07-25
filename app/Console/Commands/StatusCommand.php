<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class StatusCommand extends Command
{
    protected $signature = 'status';

    protected $description = 'Checks the status of the application';

    public function handle(): int
    {
        // Check to make sure we have database access
        try {
            DB::connection()->getPdo();
        } catch (Throwable) {
            return static::FAILURE;
        }

        // Check to make sure we can write cache data
        $data = fake()->word();

        try {
            cache()->put('cache-test', $data, 60);
            $result = cache()->get('cache-test');
            if (strcmp($data, $result) !== 0) {
                return static::FAILURE;
            }
        } catch (Throwable) {
            return static::FAILURE;
        }

        return static::SUCCESS;
    }
}
