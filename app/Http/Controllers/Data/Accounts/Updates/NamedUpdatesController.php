<?php

namespace App\Http\Controllers\Data\Accounts\Updates;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserNameRequest;

class NamedUpdatesController extends Controller
{
    public function update(UpdateUserNameRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json(['user' => $user->only('id', 'name', 'email', 'role')]);
    }
}
