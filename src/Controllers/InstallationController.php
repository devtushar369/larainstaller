<?php


namespace Hashcode\Larainstaller\Controllers;


use App\Http\Controllers\Controller;
use Hashcode\Larainstaller\Services\CheckPermissionService;
use Hashcode\Larainstaller\Services\CheckRequirementService;

class InstallationController extends Controller
{

    public function welcome()
    {
        return view('larainstaller::welcome');
    }

    public function checkRequirement()
    {
        $requirements = (new CheckRequirementService)->requirement();
        return view('larainstaller::check_requirement', compact('requirements'));
    }

    public function checkPermission()
    {
        $file = storage_path('app/requirementChecked');
        touch($file);

        $requirements = (new CheckPermissionService)->permissions();
        return view('larainstaller::check_permission', compact('requirements'));
    }


    public function completed()
    {
        $file = storage_path('app/adminSetuped');
        touch($file);

        if (storage_path('app/adminSetuped') && storage_path('app/databaseSetuped') &&
            storage_path('app/licenseVerified') && storage_path('app/permissionChecked') &&
            storage_path('app/requirementChecked')){
            $fileCompleted = storage_path('app/installed');
            touch($fileCompleted);
        }

        $user['email'] = session('email');
        $user['password'] = session('password');

        return view('larainstaller::completed')->with($user);
    }
}
