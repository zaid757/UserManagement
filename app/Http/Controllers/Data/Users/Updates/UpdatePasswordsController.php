<?php

namespace App\Http\Controllers\Data\Users\Updates;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPasswordRequest;

class UpdatePasswordsController extends Controller
{
    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        $user->update(['password' => Hash::make($request->password)]);

        return response()->json(['user' => $user->only('id', 'name', 'email', 'role')]);
    }

    public function sendResetLink(Request $request, User $user)
    {
        $user->sendPasswordResetNotification(Str::random(60));

        return response()->json(['user' => $user->only('id', 'name', 'email', 'role')]);
    }
}
