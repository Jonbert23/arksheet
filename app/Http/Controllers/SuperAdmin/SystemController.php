<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Super Admin System Controller
 * 
 * Handles system-wide settings, maintenance, and administrative tasks
 */
class SystemController extends Controller
{
    /**
     * Display system settings
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // Get system information
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_type' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'timezone' => config('app.timezone'),
            'environment' => app()->environment(),
        ];

        // Get disk usage
        $diskInfo = [
            'total_space' => disk_total_space(base_path()),
            'free_space' => disk_free_space(base_path()),
            'used_space' => disk_total_space(base_path()) - disk_free_space(base_path()),
        ];

        // Get database size
        $databaseSize = $this->getDatabaseSize();

        // Get cache size
        $cacheSize = $this->getCacheSize();

        return view('super-admin.system.settings', compact(
            'systemInfo',
            'diskInfo',
            'databaseSize',
            'cacheSize'
        ));
    }

    /**
     * Display system logs
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function logs(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logFile)) {
            // Read last 100 lines of log file
            $lines = $request->get('lines', 100);
            $content = File::get($logFile);
            $logLines = array_slice(explode("\n", $content), -$lines);
            
            // Parse log entries
            foreach ($logLines as $line) {
                if (!empty(trim($line))) {
                    $logs[] = $line;
                }
            }
            
            $logs = array_reverse($logs);
        }

        return view('super-admin.system.logs', compact('logs'));
    }

    /**
     * Clear application cache
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            Log::info('Super Admin cleared application cache', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
            ]);

            return back()->with('success', 'All caches cleared successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to clear cache: ' . $e->getMessage());
            return back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function optimize()
    {
        try {
            Artisan::call('optimize');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            Log::info('Super Admin optimized application', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
            ]);

            return back()->with('success', 'Application optimized successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to optimize application: ' . $e->getMessage());
            return back()->with('error', 'Failed to optimize: ' . $e->getMessage());
        }
    }

    /**
     * Run database migrations
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            Log::info('Super Admin ran database migrations', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
            ]);

            return back()->with('success', 'Database migrations completed successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to run migrations: ' . $e->getMessage());
            return back()->with('error', 'Failed to run migrations: ' . $e->getMessage());
        }
    }

    /**
     * Clear log files
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearLogs()
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            
            if (File::exists($logFile)) {
                File::put($logFile, '');
            }

            Log::info('Super Admin cleared log files', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
            ]);

            return back()->with('success', 'Log files cleared successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to clear logs: ' . $e->getMessage());
            return back()->with('error', 'Failed to clear logs: ' . $e->getMessage());
        }
    }

    /**
     * Get database size
     *
     * @return float Size in MB
     */
    private function getDatabaseSize(): float
    {
        try {
            $databaseType = config('database.default');
            
            if ($databaseType === 'sqlite') {
                $databasePath = database_path('database.sqlite');
                if (File::exists($databasePath)) {
                    return File::size($databasePath) / 1024 / 1024; // Convert to MB
                }
            } elseif ($databaseType === 'mysql') {
                $databaseName = config('database.connections.mysql.database');
                $result = DB::select("
                    SELECT 
                        SUM(data_length + index_length) / 1024 / 1024 AS size
                    FROM information_schema.TABLES
                    WHERE table_schema = ?
                ", [$databaseName]);
                
                return $result[0]->size ?? 0;
            }

            return 0;
        } catch (\Exception $e) {
            Log::error('Failed to get database size: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get cache size (approximate)
     *
     * @return float Size in MB
     */
    private function getCacheSize(): float
    {
        try {
            $cachePath = storage_path('framework/cache');
            
            if (!File::exists($cachePath)) {
                return 0;
            }

            $size = 0;
            $files = File::allFiles($cachePath);
            
            foreach ($files as $file) {
                $size += $file->getSize();
            }

            return $size / 1024 / 1024; // Convert to MB
        } catch (\Exception $e) {
            Log::error('Failed to get cache size: ' . $e->getMessage());
            return 0;
        }
    }
}

