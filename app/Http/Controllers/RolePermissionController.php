<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesPermissionRequest\AssignAndRemovePermissionRequest;
use App\Http\Requests\RolesPermissionRequest\AssignAndRemoveRolesRequest;
use App\Http\Traits\RolesAndPermissionTraits\RolesAdminTraits;
use App\Http\Traits\RolesAndPermissionTraits\RolesWebTraits;
use App\Services\RolesPermission\RemovePermissionAdminServices;
use App\Services\RolesPermission\AssignPermissionAdminServices;
use App\Services\RolesPermission\RemovePermissionWebServices;
use App\Services\RolesPermission\AssignpermissionWeb;
use App\Services\RolesPermission\AssignRoleAdminServices;
use App\Services\RolesPermission\AssignRoleWebServices;
use App\Services\RolesPermission\InsertRolePermission;

use App\Services\RolesPermission\RemoveRoleAdmin;
use App\Services\RolesPermission\RemoveRoleWeb;

class RolePermissionController extends BaseController
{
    use RolesAdminTraits,RolesWebTraits;

    /*
      untuk initiate permission dan role
    */
    public function createRolePermissionAdmin() {

        $insertPermisson =  new InsertRolePermission;
        $getRoles        = $this->RolesAdmin();

        $initiateRolePermissionAdmin =    $insertPermisson->insertRolePermission($getRoles['rolePermissionAdmin']);

        return $this->handleResponse($initiateRolePermissionAdmin, 'initiate Roles and permission Admin guard success');

    }
    /**
     * @lrd:start
     * # endpoint ini adalah untuk menginitiasi fungsi role dan permission, dijalankan hanya ketika pertamakali aplikasi di jalankan
     * # atau ketika ingin merubah struktur permission
     * # perhatikan ketika ini di lakukan key dari table ini akan di gunakan oleh kontroller lain sebagai foreignkey
     * @lrd:end
     */
    public function createRolePermissionWeb() {

      $insertPermisson =  new InsertRolePermission;
      $getRoles = $this->RolesWeb();

      $initiateRolePermissionWeb =   $insertPermisson->insertRolePermission($getRoles['rolePermissionWeb']);

       return $this->handleResponse($initiateRolePermissionWeb, 'initiate Roles and permission webGuard successfuly');
   }
    /*
      akhir untuk initiate permission dan role
    */

     //== untuk admin

    public function assignRoleAdmin(AssignAndRemoveRolesRequest $request,AssignRoleAdminServices $assignRoleAdminServices ) {

        $assginRoleAdmin = $assignRoleAdminServices->assignRoleAdmin($request);

        if($assginRoleAdmin['status']) {
            return $this->handleResponse($assginRoleAdmin, 'Roles admin insert successfuly');
        }
        else {
           return $this->handleError( $assginRoleAdmin,'there is no roles Admin exist with that name',403);
        }
    }
     public function removeRoleAdmin(AssignAndRemoveRolesRequest $request,RemoveRoleAdmin $removeRoleAdmin) {
        $removeRoleAdminProses = $removeRoleAdmin->removeAdmin($request);
        if($removeRoleAdminProses['status']) {
            return $this->handleResponse($removeRoleAdminProses, 'remove Roles admin insert successfuly');
        } else {

            return $this->handleError($removeRoleAdminProses, 'admin id not found');
        }
     }

     public function assignPermissionAdmin(AssignAndRemovePermissionRequest $request,AssignPermissionAdminServices $assignPermissionAdminServices) {
       $assignPermissionAdminProcess =   $assignPermissionAdminServices->AssignPermissionAdmin($request);

         if($assignPermissionAdminProcess['status']) {
             return $this->handleResponse($assignPermissionAdminProcess, $assignPermissionAdminProcess['message']);
         } else {
             return $this->handleError($assignPermissionAdminProcess, $assignPermissionAdminProcess['message']);
         }
     }

     public function removePermissionAdmin(AssignAndRemovePermissionRequest $request,RemovePermissionAdminServices $removePermissionAdminServices) {
      $removePermissionadminServicesProcess =  $removePermissionAdminServices->RemovePermissionAdmin($request);

         if($removePermissionadminServicesProcess['status']) {
             return $this->handleResponse($removePermissionadminServicesProcess, $removePermissionadminServicesProcess['message']);
         } else {
             return $this->handleError($removePermissionadminServicesProcess, $removePermissionadminServicesProcess['message']);
         }
    }


     //== untuk web

     public function assignRoleWeb(AssignAndRemoveRolesRequest $request,AssignRoleWebServices $assignRoleWebServices ) {
         $assignRoleWebServicesProcess = $assignRoleWebServices->assignRoleWeb($request);

         if($assignRoleWebServicesProcess['status']) {
             return $this->handleResponse($assignRoleWebServicesProcess, $assignRoleWebServicesProcess['message']);
         } else {
             return $this->handleError($assignRoleWebServicesProcess, $assignRoleWebServicesProcess['message']);
         }
     }
     public function removeRoleWeb(AssignAndRemoveRolesRequest $request,RemoveRoleWeb $removeRoleWeb) {
        $RemoveRoleWebProcess =  $removeRoleWeb->removeWeb($request);

         if($RemoveRoleWebProcess['status']) {
             return $this->handleResponse($RemoveRoleWebProcess, $RemoveRoleWebProcess['message']);
         } else {
             return $this->handleError($RemoveRoleWebProcess, $RemoveRoleWebProcess['message']);
         }

     }
     public function assignPermissionWeb(AssignAndRemovePermissionRequest $request,AssignpermissionWeb $assignpermissionWeb) {
         $assignpermissionWebProcess =  $assignpermissionWeb->assignPermissionWeb($request);

         if($assignpermissionWebProcess['status']) {
             return $this->handleResponse($assignpermissionWebProcess, $assignpermissionWebProcess['message']);
         } else {
             return $this->handleError($assignpermissionWebProcess, $assignpermissionWebProcess['message']);
         }
     }
     public function removePermissionWeb(AssignAndRemovePermissionRequest $request,RemovePermissionWebServices $removePermissionWebServices) {
         $removePermissionWebServicesProcess =  $removePermissionWebServices->RemovePermissionWeb($request);

         if($removePermissionWebServicesProcess['status']) {
             return $this->handleResponse($removePermissionWebServicesProcess, $removePermissionWebServicesProcess['message']);
         } else {
             return $this->handleError($removePermissionWebServicesProcess, $removePermissionWebServicesProcess['message']);
         }
   }











}
