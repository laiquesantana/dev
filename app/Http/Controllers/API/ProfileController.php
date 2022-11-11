<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getUserProfile()
    {
        $user = auth('api')->user();

        return $user->makeHidden('tipo', 'orgao_id');
    }

    public function hasPermission()
    {
        $user = auth('api')->user();
        return $user->getAllPermissions()->pluck('name')->toArray();
    }

    public function updateUserProfile(Request $request)
    {
        $user = auth('api')->user();

        $request['cpf'] = str_replace(['.', '-'], '', $request->input('cpf'));

        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'sometimes',
            'cpf' => 'required|cpf|unique:users,cpf,' . $user->id
        ]);

        $currentPhoto = $user->photo;

        if ($request->photo != $currentPhoto) {
            $extension = explode('/', mime_content_type($request->photo))[1];
            $name = time() . '.' . $extension;

            \Image::make($request->photo)->save(public_path('img/profile/') . $name);
            $data['photo'] = $name;

            $userPhoto = public_path('img/profile/') . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        $user->update($data);
        return ['message' => "Success"];
    }
}
