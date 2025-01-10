<?php


namespace Hashcode\Larainstaller\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use PDO;

class DatabaseController extends Controller
{
    public function databaseSetup(Request $request)
    {
        $file = storage_path('app/licenseVerified');
        touch($file);
        return view('larainstaller::database_setup');
    }

    public function databaseSetupStore(Request $request)
    {
        $request->validate([
            'database_host' => 'required',
            'database_port' => 'required|numeric',
            'database_name' => 'required',
            'database_username' => 'required',
        ]);

        try {
            $connection  = $this->checkDatabaseConnection($request);
            if (!$connection){
                return redirect()->back()->with('error', 'Database connection configuration mismatch. Please try again.');
            }
            $data = [
                'DB_HOST' => $request->database_host,
                'DB_PORT' => $request->database_port,
                'DB_DATABASE' => $request->database_name,
                'DB_USERNAME' => $request->database_username,
                'DB_PASSWORD' => $request->database_password,
            ];
            $this->updateEnvVariables($data);
            return redirect()->route('install.admin_setup')->with('success', 'Database configuration updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the database configuration.');
        }
    }


    private function checkDatabaseConnection(Request $request)
    {
        $connection = 'mysql';

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('database_host'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    protected function updateEnvVariables(array $data)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                $envKey = strtoupper(str_replace('database_', 'DB_', $key)); // Map to DB_ keys

                // Read the .env file content
                $env = file_get_contents($path);

                // Replace the key if it exists, or add it otherwise
                if (preg_match("/^{$envKey}=.*/m", $env)) {
                    $env = preg_replace("/^{$envKey}=.*/m", "{$envKey}={$value}", $env);
                } else {
                    $env .= "\n{$envKey}={$value}";
                }

                // Write the updated content back to the .env file
                file_put_contents($path, $env);
            }
        }
    }
}
