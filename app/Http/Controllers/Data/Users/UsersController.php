<?php

namespace App\Http\Controllers\Data\Users;


use App\User;
use Image;
use File;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            function ($request, $next) {
                if (!Auth::user()->isAdmin()) {
                    return response('Unauthorized', 403);
                }

                return $next($request);
            }
        )->only('destroy');
    }
    public function index()
    {
        return response()->json(['results' => User::latest()->paginate(20)]);
    }

    public function store(StoreUserRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
        'name' => 'required|max:255',
         'role' => 'required|max:255',
         'image' => 'required|mimes:jpeg,bmp,png,jpg',]);



         $user = new User();
         $user->name = $request['name'];
         $user->role = $request['role'];
         $user->email = $request['email'];
         $user->password = Hash::make($request['password']);


        $image = request()->file('image');
        $imageName = $image->getClientOriginalName();
        $imageName = time().'_'.$imageName;

        if ($request['image']) {
            $image = $request['image'];


            $name = time() .'_'. $image->getClientOriginalName();
            \Image::make($request->image)->save(public_path('storage/').$name);
            $user->image =$name;
        } else {
            $user->image = 'default.jpg';
        }
        $user->save();

        return response()->json(['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json(['user' => $user->only('id', 'name', 'email', 'role')]);
    }

    public function destroy(User $user)
    {
        $user->delete();


        return response()->json(['message' => 'succesfully deleted User']);
    }
}
