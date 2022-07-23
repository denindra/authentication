<?php

namespace App\Repositories;


use App\Interfaces\UsersAdminInterface;
use App\Models\Admin;
use App\Http\Resources\UsersResources\UserAdminListWebResource;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\PipelineFilters\UsersPipeline\UseSort;
use App\PipelineFilters\UsersPipeline\GetByKey;
use App\PipelineFilters\UsersPipeline\GetByWord;
use App\Http\Resources\UsersResources\UserAdminListSummaryResource;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;


class UsersAdminRepository implements UsersAdminInterface
{
    public function show(Request $request,$getOnlyColumn) {

       $getData =  app(Pipeline::class)
                                ->send(Admin::query())
                                ->through([
                                    GetByWord::class,
                                    GetByKey::class,
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

                                                                if(request()->get('CollectionType') == 'usersSummaryAdmin') {

                                                                    return new UserAdminListSummaryResource([
                                                                        'data' => $item,
                                                                        'status' => true
                                                                    ]);
                                                                }
                                                                else {

                                                                    return new UserAdminListWebResource([
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

                                   $message =   'paginate users admin success';

                                }
                               else if(request()->get('getFirst') == 'true' && !request()->has('paginate') || request()->has('paginate') == 'false')
                                {

                                    $getDataFirst  =   $getData->first();

                                     if(request()->get('CollectionType') == 'usersSummaryAdmin') {

                                        $outputData = new UserAdminListSummaryResource([
                                            'data' => $getDataFirst,
                                            'status' => true
                                        ]);
                                    }
                                     else {

                                         $outputData = new UserAdminListWebResource([
                                             'data' => $getDataFirst,
                                             'status' => true
                                         ]);
                                     }

                                    $message =   'getFirst users admin success';
                                }
                                else
                                {

                                    $outputData  =   $getData->limit(250)->get();
                                    $message     =   'get users admin success : max output 250 data';
                                }


        return $response = array(
            'queryStatus'       => true,
            'requestCollection' => request()->get('CollectionType'),
            'queryMessage'      => $message,
            'response'          => $outputData

        );
    }
    public function store($request) {

        $users                 = new Admin();
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

        $remove =  Admin::where('id',$requestId->byId)->delete();

        if($remove == true)
        {
            return array(
                'queryStatus'       => true,
                'queryMessage'      => 'delete success',
                'response'          => $remove
            );
        }
        else
        {
            return array(
                'queryStatus'       => false,
                'queryMessage'      => 'delete fail',
                'response'          => $remove
            );
        }
    }
    public function update($request) {


        $users                      =  Admin::find($request->id);

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
    public function updatePasswordAdmin($request) {

        $users                      =  Admin::find($request->id);

         if($users) {

            $users->password           = Hash::make($request->password);
            $users->save();

             return array(
                 'queryStatus'       => true,
                 'queryMessage'      => 'update password success',
                 'response'          => $users
             );

        } else {

             return array(
                 'queryStatus'       => false,
                 'queryMessage'      => 'update password fail',
                 'response'          => $users
             );

        }
    }
}
