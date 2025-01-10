<?php


namespace Hashcode\Larainstaller\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PDO;

class AdminSetupController extends Controller
{

    public function adminSetup()
    {
        $file = storage_path('app/databaseSetuped');
        touch($file);

        return view('larainstaller::admin_setup');
    }

    public function adminSetupStore(Request $request)
    {
        $validatedData =   $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'demo_data' => 'required|boolean',
        ]);

        $migrated = $this->migrate();

        if (!$migrated){
            return redirect()->back()->with('error', 'Something went wrong with your migration');
        }

        try {
            // Hash the password
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Check if a user exists in the 'users' table
            $user = DB::table('users')->first();

            $request->session()->forget('email');
            $request->session()->forget('password');

            session(['email' => $request->email]);
            session(['password' => $request->password]);

            if ($user) {
                // Update the user's email and password
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                    ]);
            } else {
                // Insert a new user record
                DB::table('users')->insert([
                    'name' => 'admin',
                    'email' => $validatedData['email'],
                    'password' => $validatedData['password'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($validatedData['demo_data']) {
                Artisan::call('db:seed', ['--force' => true]);
            }
            return redirect()->route('install.completed')->with('success', 'Admin user updated or created successfully');
        }  catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating or creating the admin user.');
        }
    }


    private function migrate()
    {
        try {
            $db_host = env('DB_HOST', '127.0.0.1');
            $db_name = env('DB_DATABASE');
            $db_user = env('DB_USERNAME');
            $db_pass = env('DB_PASSWORD');
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $database = database_path('database.sql');
            $query = file_get_contents($database);
            $stmt = $conn->prepare($query);
            $stmt->execute();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
}
