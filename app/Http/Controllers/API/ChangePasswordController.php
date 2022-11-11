<?php

namespace App\Http\Controllers\API;

use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(PasswordRequest $request)
    {
        $user = auth('api')->user();

        $data['password'] = Hash::make($request->nova_senha);
        $user->update($data);
    }
}
