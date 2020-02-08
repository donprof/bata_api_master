<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Http\Requests\User\AvatarFormRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use File;
use Intervention\Image\ImageManager;

class MeController extends Controller
{
    protected $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->middleware('auth:api', ['except' => ['logout']]);
        $this->imageManager = $imageManager;
    }

    public function action(Request $request)
    {
        return new PrivateUserResource($request->user());
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $root = public_path('storage/');
        File::delete($root.$request->oldAvatar);
        if ($request->gendarname == 'Male') {
            $userstate = 1;
        }elseif ($request->gendarname == 'Female') {
            $userstate = 2;
        }else{
            $userstate = 3;
        }

        $user = User::findOrFail(intval($id));
        $user->update([
            'name'          => $request->username,
            'phone'         => $request->phone,
            'gendar'        => $userstate,
            'email'         => $request->email,
            'dateofbirth'   => $request->dateofbirth,
            // 'avatar'        => $request->avatar,
        ]);
        return response()->json(['data'=>$user], 200);
    }

    public function store(AvatarFormRequest $request)
    {
        $paththum = public_path('storage/users/');
        
        if(!File::isDirectory($paththum)){
            File::makeDirectory($paththum, 0777, true, true);
        }

        $user = User::findOrFail(intval(request()->user()->id));

        File::delete($paththum.$user->avatar);

        $this->imageManager->make($request->file('image')->getPathName())
            ->fit(180, 180, function ($c) {
                $c->aspectRatio();
            })
            ->encode('jpg')
            ->save(public_path('storage/users/') . $path = uniqid(true) . '.jpg');
        
        
        $user->update([
            'avatar' => $path,
        ]);
        
        return response([
            'data' => $path
        ], 200);
    }
}
