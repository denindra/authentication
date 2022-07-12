<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UsersInterface {

    public function show(Request $request,$getOnlyColumn);
    public function store($request);
    public function destroy($requestId);
    public function update($request);
    public function updatePassword($request);
}
