<?php


namespace Hashcode\Larainstaller\Services;


class CheckPermissionService
{
    public function permissions()
    {
        return [
            [
                'title' => 'Folder /public is writable',
                'value' => $this->checkPermission(public_path()),
            ],
            [
                'title' => 'Folder /resource/lang is writable',
                'value' => $this->checkPermission(resource_path('lang')),
            ],
            [
                'title' => 'Folder /storage/framework/ is writable',
                'value' => $this->checkPermission(storage_path('framework')),
            ],
            [
                'title' => 'Folder /storage/logs/ is writable',
                'value' => $this->checkPermission(storage_path('logs')),
            ],
            [
                'title' => 'Folder /bootstrap/cache/ is writable',
                'value' => $this->checkPermission(base_path('bootstrap/cache')),
            ],
        ];
    }

    /**
     * Check if the file or directory is writable and has 777 permissions.
     */
    private function checkPermission($path)
    {
        if (file_exists($path)){
            $permissions = substr(sprintf('%o', fileperms($path)), -3); // Get last 3 digits of permissions
            if (is_writable($path) && $permissions === '755'){
                return true;
            }
        }

        return false;
//        return [
//            'is_writable' => is_writable($path),
//            'permissions' => $permissions,
//            'is_777' => ($permissions === '777'),
//        ];
    }
}
