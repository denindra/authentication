<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\Admin;
use App\Http\Controllers\BaseController;
use App\Http\Resources\UsersResources\UserListWebResource;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\PipelineFilters\UsersPipeline\UseSort;
use App\PipelineFilters\UsersPipeline\GetByKey;
use App\PipelineFilters\UsersPipeline\GetByWord;
use App\Http\Resources\UsersResources\UserListSummaryResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use \Illuminate\Support\Collection;

class UsersRepository extends BaseController
{

    
    public function show(Request $request,$getOnlyColumn) {
        
        // $user = auth()->user();
     
        //     $Role =  $user->getRoleNames();
        // $permissions = $user->getPermissionsViaRoles();
        // return $user;
       $getData =  app(Pipeline::class)
                                ->send(User::query())
                                ->through([
                                    GetByKey::class,
                                    GetByWord::class,
                                    UseSort::class,
                                ])
                                ->thenReturn()
                                ->with('roles.permissions')
                                ->select($getOnlyColumn);
                                
                                if(request()->get('paginate') == 'true')
                                {
                                  
                                    $outputData  =  $getData->paginate(request()->get('perPage') ,$getOnlyColumn,'page',request()->get('currentPage'));
                                    
                                    $itemsTransformed = $outputData
                                                            ->getCollection()
                                                            ->map(function($item) {
                                                                if(request()->get('CollectionType') == 'usersListWeb') {
                                                                      
                                                                    return new UserListWebResource([
                                                                        'data' => $item,
                                                                        'status' => true
                                                                    ]);

                                                                }
                                                                else if(request()->get('CollectionType') == 'usersSummaryWeb') {
                                                                   
                                                                    return new UserListSummaryResource([
                                                                        'data' => $item,
                                                                        'status' => true
                                                                    ]);
                                                                }
                                                             
                                                            })->toArray();


                                    $outputData = new \Illuminate\Pagination\LengthAwarePaginator(
                                        $itemsTransformed,
                                        $outputData->total(),
                                        $outputData->perPage(),
                                        $outputData->currentPage(), [
                                            'path' => \Request::url(),
                                            'query' => [
                                                'page' => $outputData->currentPage()
                                            ]
                                        ]
                                    );
                                    
                                   $message =   'paginate users success';
                               
                                }
                               else if(request()->get('getFirst') == 'true' && !request()->has('paginate') || request()->has('paginate') == 'false')
                                { 

                                    $getDataFirst  =   $getData->first();  

                                    $outputData = new UserListWebResource([
                                        'data' => $getDataFirst,
                                        'status' => true
                                    ]);
                                                                 
                                    $message =   'getFirst users success';
                                }
                                else
                                {
                                  
                                    $outputData  =   $getData->limit(250)->get();
                                   

                                   
                                    $message =   'get users success : max output 250 data';
                                }
                           
                              
        return $this->handleResponse($outputData,$message );
    }
    public function store($request) {
       
        $users                 = new User();
        $users->name           = $request->name;
        $users->email          = $request->email;
        $users->password       = Hash::make($request->password);  
        $users->save();
        // give access into web login
        $users->assignRole('userWeb');   
        $users->givePermissionTo('loginAccountWeb');

        if($users) {   
            
            return $this->handleResponse($users, 'Register users Success');
           
        } else {

            Log::warning('user;store;gagal membuat user;'.$request->email.';failed');
            return $this->handleError($users, 'get user gagal dibuat',422);
        }
    }
    public function destroy($requestId) {
    
        $remove =  User::where('id',$requestId->byId)->delete();
        
        if($remove == true)
        {
            Log::info('/user;destroy;destrory user berhasil;by:'.Auth::user()->id.';#'.$requestId.';success');
            return $this->handleResponse($remove, 'user berhasil di hapus');
        }
        else
        {
            return $this->handleResponse($remove, 'user tidak berhasil di hapus, system error');
        }
    }
    public function update($request) {

                    
        $users                      =  User::find($request->id);
        
         if($users) {   
            
            $users->name           = $request->name;
            $users->email          = $request->email;
            $users->save();

            return $this->handleResponse($users, 'Update users Success');
           
        } else {

            Log::warning('user;update;gagal update user;'.$request->email.';failed');
            return $this->handleError($users, 'user gagal diupdate/tidak di temukan',422);
        }
    }
}