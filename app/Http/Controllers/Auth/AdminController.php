<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $brands = Admin::get();
        return response([
            'data' => $brands
        ], 200);
    }

    public function me(Request $request)
    {
        return new PrivateUserResource($request->user());
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        $user = Admin::findOrFail(intval($id));

        if (!empty($request->oldPassword) || !empty($request->password) || !empty($request->password_confirmation)) {
            $request->validate([
                'oldPassword' => 'required|min:6',
                'password'  => 'required|alpha_num|min:6|confirmed',
            ]);
            if (Hash::check($request->oldPassword, $user->password)) {
                $user->update([
                    'name' => $request->name,
                    'email'  => $request->email,
                    'password'  => bcrypt($request->password),
                    'accountstatus'     => $request->status,
                ]);
            }else{
                return new JsonResponse(['errors' => [ 'oldPassword' => ["The old password is incorrect."] ]], 422);
            }
        }else{
            $user->update([
                'name' => $request->name,
                'email'  => $request->email,
                'accountstatus'     => $request->status,
            ]);
        }
        return response()->json(['data'=>$user], 200);
    }

    public function store(AdminRequest $request)
    {
        $admin = Admin::create([
            'email'         => $request->email,
            'name'          => $request->name,
            'password'      => bcrypt($request->password),
            'accountstatus' => $request->status
        ]);
        return response([
            'data' => $admin
        ], 200);
    }
}
