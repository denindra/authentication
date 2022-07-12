<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UsersAdminInterface {

    public function show(Request $request,$getOnlyColumn);
    public function store(array $request);
    public function destroy(int $requestId);
    public function update(array $request);
    public function updatePasswordAdmin(array $request);
}
