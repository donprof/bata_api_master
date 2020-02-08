<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\Utilities;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Events\Users\PasswordChanged;
use App\Http\Requests\Auth\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class ForgotCredentialsController extends Controller
{
    public function reset(ResetPasswordRequest $request) {
        $newPassword = Utilities::generatePassword();
        $user = User::where('email',$request->email)->first();
        $user->password = bcrypt($newPassword);
        $user->save();
        event(new PasswordChanged($user, $newPassword));
        return new PrivateUserResource($user);
    }

    public function passwordreset(PasswordRequest $request, $id) {
        $user = User::findOrFail(intval($id));

        if (Hash::check($request->oldPassword, $user->password)) {
            $user->update([
                'password'  => bcrypt($request->password)
            ]);
        }else{
            return new JsonResponse(['errors' => [ 'oldPassword' => ["The old password is incorrect."] ]], 422);
        }
    }
}
