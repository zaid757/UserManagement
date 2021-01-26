<?php

namespace App\Http\Controllers\Data\Users\Logs;

use App\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsUser')->only('index');
    }
    public function index(User $user)
    {
        return response()->json(['results' => UserLog::byUser($user->id)->latest()->paginate(50)]);
    }
}
