<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        return view('content.pages.setting.index');
    }

    public function theme()
    {
        // default theme load (from session or db)
        $currentTheme = session('theme', 'light');
        return view('content.pages.setting.theme', compact('currentTheme'));
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark,system',
        ]);

        // save to session (or db if per-user settings needed)
        session(['theme' => $request->theme]);

        return redirect()->route('settings.theme')->with('success', 'Theme updated successfully!');
    }

    public function logs(Request $request)
    {
        $filter = $request->get('filter', 'week'); // default last week
        $logPath = storage_path('logs');
        $errorLogs = [];

        if (File::exists($logPath)) {
            // Get all laravel log files (including rotated ones)
            $logFiles = File::files($logPath);

            foreach ($logFiles as $file) {
                if (preg_match('/laravel(-\d{4}-\d{2}-\d{2})?\.log$/', $file->getFilename())) {
                    $lines = file($file->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    $now = Carbon::now();

                    foreach ($lines as $line) {
                        // Match lines like: [2025-09-16 12:45:23] local.ERROR: message
                        if (preg_match('/^\[(.*?)\]\s+(.*?)\:\s(.*)$/', $line, $matches)) {
                            $dateString = $matches[1];
                            $message = $matches[3];

                            try {
                                $date = Carbon::createFromFormat('Y-m-d H:i:s', substr($dateString, 0, 19));
                            } catch (\Exception $e) {
                                continue; // skip malformed dates
                            }

                            // Apply filter
                            $include = false;
                            switch ($filter) {
                                case '3days':
                                    if ($date->greaterThanOrEqualTo($now->copy()->subDays(3))) $include = true;
                                    break;
                                case 'week':
                                    if ($date->greaterThanOrEqualTo($now->copy()->subWeek())) $include = true;
                                    break;
                                case 'month':
                                    if ($date->greaterThanOrEqualTo($now->copy()->subMonth())) $include = true;
                                    break;
                                default:
                                    $include = true;
                            }

                            if ($include) {
                                $errorLogs[] = [
                                    'date' => $date->format('Y-m-d H:i:s'),
                                    'file' => $file->getFilename(),
                                    'message' => $message,
                                ];
                            }
                        }
                    }
                }
            }

            // Sort newest first across all files
            usort($errorLogs, fn($a, $b) => strcmp($b['date'], $a['date']));
        }

        return view('content.pages.setting.logs', compact('errorLogs', 'filter'));
    }
    // Delete selected logs
    public function deleteLogs(Request $request)
    {
        $datesToDelete = $request->get('dates', []);

        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return redirect()->back()->with('error', 'Log file not found');
        }

        $lines = File::lines($logFile);
        $newLines = [];

        foreach ($lines as $line) {
            $keep = true;

            foreach ($datesToDelete as $date) {
                if (str_contains($line, $date)) {
                    $keep = false;
                    break;
                }
            }

            if ($keep) $newLines[] = $line;
        }

        File::put($logFile, implode("\n", $newLines));

        return redirect()->back()->with('success', 'Selected logs deleted');
    }

    public function database()
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = [];

        foreach ($tables as $table) {
            $props = get_object_vars($table);
            $tableNames[] = reset($props);
        }

        return view('content.pages.setting.database', ['tables' => $tableNames]);
    }

    /**
     * Full Database Download
     */
    public function downloadDatabase()
    {
        $dbName = env('DB_DATABASE');
        $user   = env('DB_USERNAME');
        $pass   = env('DB_PASSWORD');
        $host   = env('DB_HOST', '127.0.0.1');
        $port   = env('DB_PORT', 3306);

        $fileName = "backup_{$dbName}_" . now()->format('Y-m-d_H-i-s') . ".sql";
        $filePath = storage_path("app/{$fileName}");

        // Full path to mysqldump in Laragon
        $mysqldump = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe";

        // Build command (without extra wrapping quotes)
        $cmd = "\"{$mysqldump}\" --host={$host} --port={$port} -u{$user}";
        if (!empty($pass)) {
            $cmd .= " -p\"{$pass}\"";
        }
        $cmd .= " {$dbName} > \"{$filePath}\"";

        // Run through cmd
        $cmd = "cmd /c {$cmd}";

        // Log command before running
        Log::info("Database Backup Command: {$cmd}");

        exec($cmd, $output, $result);

        // Log the result
        Log::info("Backup Result Code: {$result}");
        Log::info("Backup Output: ", $output);
        Log::info("Backup File Path: {$filePath}");
        if (file_exists($filePath)) {
            Log::info("Backup File Size: " . filesize($filePath));
        } else {
            Log::warning("Backup File not created at: {$filePath}");
        }

        if ($result === 0 && file_exists($filePath) && filesize($filePath) > 0) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Backup failed. Check logs for details.');
    }

    public function downloadTable(Request $request)
    {
        $request->validate([
            'table' => 'required|string'
        ]);

        $table  = $request->table;
        $dbName = env('DB_DATABASE');
        $user   = env('DB_USERNAME');
        $pass   = env('DB_PASSWORD');
        $host   = env('DB_HOST', '127.0.0.1');
        $port   = env('DB_PORT', 3306);

        $fileName = "backup_table_{$table}_" . now()->format('Y-m-d_H-i-s') . ".sql";
        $filePath = storage_path("app/{$fileName}");

        $mysqldump = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe";

        $cmd = "\"{$mysqldump}\" --host={$host} --port={$port} -u{$user}";
        if (!empty($pass)) {
            $cmd .= " -p\"{$pass}\"";
        }
        $cmd .= " {$dbName} {$table} > \"{$filePath}\"";

        $cmd = "cmd /c {$cmd}";

        // Log command before running
        Log::info("Table Backup Command: {$cmd}");

        exec($cmd, $output, $result);

        // Log the result
        Log::info("Table Backup Result Code: {$result}");
        Log::info("Table Backup Output: ", $output);
        Log::info("Table Backup File Path: {$filePath}");
        if (file_exists($filePath)) {
            Log::info("Table Backup File Size: " . filesize($filePath));
        } else {
            Log::warning("Table Backup File not created at: {$filePath}");
        }

        if ($result === 0 && file_exists($filePath) && filesize($filePath) > 0) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Table backup failed. Check logs for details.');
    }
    // Show Language Page
    public function language()
    {
        // Supported languages list
        $languages = [
            'en' => 'English',
            'bn' => 'Bangla',
            'es' => 'Spanish',
            'fr' => 'French',
        ];

        $currentLang = Session::get('locale', config('app.locale'));

        return view('content.pages.setting.language', compact('languages', 'currentLang'));
    }

    // Update Language
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,bn,es,fr',
        ]);

        $lang = $request->language;

        // Store in session
        Session::put('locale', $lang);
        App::setLocale($lang);

        // Supported languages
        $languages = [
            'en' => 'English',
            'bn' => 'Bangla',
            'es' => 'Spanish',
            'fr' => 'French',
        ];

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Language updated to ' . ($languages[$lang] ?? strtoupper($lang))
            ]);
        }

        // Fallback for normal form submission
        return redirect()->route('settings.language')
            ->with('success', 'Language updated to ' . ($languages[$lang] ?? strtoupper($lang)));
    }
}
