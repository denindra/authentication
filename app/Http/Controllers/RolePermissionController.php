<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesPermissionRequest\AssignAndRemovePermissionRequest;
use App\Models\Admin;
use App\Http\Requests\RolesPermissionRequest\AssignAndRemoveRolesRequest;
use App\Http\Traits\RolesAndPermissionTraits\RolesAdminTraits;
use App\Http\Traits\RolesAndPermissionTraits\RolesWebTraits;
use App\Services\RolesPermission\AssignPermissionAdminServices;
use App\Services\RolesPermission\RemovePermissionWebServices;
use App\Services\RolesPermission\AssignpermissionWeb;
use App\Services\RolesPermission\AssignRoleAdminServices;
use App\Services\RolesPermission\AssignRoleWebServices;
use App\Services\RolesPermission\InsertRolePermission;
use App\Services\RolesPermission\RemovePermissionAdminServices;
use App\Services\RolesPermission\RemoveRoleAdmin;
use App\Services\RolesPermission\RemoveRoleWeb;

class RolePermissionController extends Controller
{
    
    use RolesAdminTraits,RolesWebTraits;

    /*
      untuk initiate permission dan role
    */
    public function createRolePermissionAdmin() {
       
        $insertPermisson =  new InsertRolePermission;
        $getRoles = $this->RolesAdmin();
        
        return   $insertPermisson->insertRolePermission($getRoles['rolePermissionAdmin']);
        
    }
    public function createRolePermissionWeb() {

      $insertPermisson =  new InsertRolePermission;
      $getRoles = $this->RolesWeb();
      
      return  $insertPermisson->insertRolePermission($getRoles['rolePermissionWeb']);
   }
    /*
      akhir untuk initiate permission dan role
    */

     //== untuk admin

    public function assignRoleAdmin(AssignAndRemoveRolesRequest $request,AssignRoleAdminServices $assignRoleAdminServices ) {

        return $assignRoleAdminServices->assignRoleAdmin($request);
         
     }
     public function removeRoleAdmin(AssignAndRemoveRolesRequest $request,RemoveRoleAdmin $removeRoleAdmin) {
        return $removeRoleAdmin->removeAdmin($request);
 
     }
     
     public function assignPermissionAdmin(AssignAndRemovePermissionRequest $request,AssignPermissionAdminServices $assignPermissionAdminServices)
     {
       return   $assignPermissionAdminServices->AssignPermissionAdmin($request);
     }

     public function removePermissionAdmin(AssignAndRemovePermissionRequest $request,RemovePermissionAdminServices $removePermissionAdminServices) {

        
      return $removePermissionAdminServices->RemovePermissionAdmin($request);
    }
    

     //== untuk web

     public function assignRoleWeb(AssignAndRemoveRolesRequest $request,AssignRoleWebServices $assignRoleWebServices ) {

        return $assignRoleWebServices->assignRoleWeb($request);
         
     }
     public function removeRoleWeb(AssignAndRemoveRolesRequest $request,RemoveRoleWeb $removeRoleWeb) {

        return $removeRoleWeb->removeWeb($request);
 
     }
     public function assignPermissionWeb(AssignAndRemovePermissionRequest $request,AssignpermissionWeb $assignpermissionWeb) {

        
        return $assignpermissionWeb->assignPermissionWeb($request);
     }
     public function removePermissionWeb(AssignAndRemovePermissionRequest $request,RemovePermissionWebServices $removePermissionWebServices) {

        
      return $removePermissionWebServices->RemovePermissionWeb($request);
   }

   
   
   
    




   
   
}
