<?php

namespace App\Http\Controllers\Data\Accounts;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function index(User $user = null)
    {
        if ($user === null) {
            return response()->json(['user' => Auth::user()]);
        }
    }
}
