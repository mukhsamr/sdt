<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FlushSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:flush {--driver=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all user sessions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $driver = $this->option('driver') ?: config('session.driver');

        switch ($driver) {
            case 'database':
                $this->flushDB();
                break;
            case 'file':
                $this->flushFile();
                break;
            case 'all':
                $this->flushDB();
                $this->flushFile();
                break;
        }
    }

    private function flushDB()
    {
        $table = config('session.table');
        if (Schema::hasTable($table)) {
            DB::table($table)->truncate();
            Log::info($table . ' was truncated');
        } else {
            Log::error($table . ' table does not exist');
        }
        return;
    }

    private function flushFile()
    {
        $path = config('session.files');

        if (File::exists($path)) {
            $files =   File::allFiles($path);
            File::delete($files);
            Log::info(count($files) . ' sessions flushed');
        } else {
            Log::error('check your session path exists');
        }
    }
}
