<?php

namespace App\Repositories;

use App\Interfaces\UsersInterface;
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
use App\Services\AuthServices\UpdateProfileService;


class UsersRepository implements UsersInterface
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

                                    if(request()->get('CollectionType') == 'usersSummaryAdmin') {

                                        $outputData = new UserListSummaryResource([
                                            'data' => $getDataFirst,
                                            'status' => true
                                        ]);
                                    }
                                    else {

                                        $outputData = new UserListWebResource([
                                            'data' => $getDataFirst,
                                            'status' => true
                                        ]);
                                    }

                                    $message =   'getFirst users admin success';
                                }
                                else
                                {

                                    $outputData  =   $getData->limit(250)->get();
                                    $message     =   'get users success : max output 250 data';
                                }


        return $response = array(
            'queryStatus'       => true,
            'requestCollection' => request()->get('CollectionType'),
            'queryMessage'      => $message,
            'response'          => $outputData

        );
    }
    public function store($request) {

        $users                 = new User();
        $users->name           = $request->name;
        $users->email          = $request->email;
        $users->password       = Hash::make($request->password);
        $users->save();

        if($users) {

            return array(
                'queryStatus'       => true,
                'queryMessage'      => 'insert Success',
                'response'          => $users
            );

        } else {

            return array(
                'queryStatus'       => false,
                'queryMessage'      => 'insert fail',
                'response'          => $users
            );
        }
    }
    public function destroy($requestId) {

        $remove =  User::where('id',$requestId->byId)->delete();

        if($remove)
        {
            return array(
                'queryStatus'       => true,
                'queryMessage'      => 'destroy success',
                'response'          => $remove
            );
        }
        else
        {
            return array(
                'queryStatus'       => false,
                'queryMessage'      => 'destroy fail',
                'response'          => $remove
            );

        }
    }
    public function update($request) {


        $users                      =  User::find($request->id);

         if($users) {

            $users->name           = $request->name;
            $users->email          = $request->email;
            $users->save();

             return array(
                 'queryStatus'       => true,
                 'queryMessage'      => 'update success',
                 'response'          => $users
             );

        } else {
           return array(
                 'queryStatus'       => false,
                 'queryMessage'      => 'update fail',
                 'response'          => $users
             );
        }
    }
    public function updatePassword($request) {

        $users                      =  User::find($request->id);

         if($users) {

            $users->password           = Hash::make($request->password);
            $users->save();

            return array(
                 'queryStatus'       => true,
                 'queryMessage'      => 'password update success',
                 'response'          => $users
             );

        } else {

            return  array(
                 'queryStatus'       => false,
                 'queryMessage'      => 'password update fail',
                 'response'          => $users
             );

        }

    }
}
