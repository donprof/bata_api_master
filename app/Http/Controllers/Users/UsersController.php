<?php

namespace App\Http\Controllers\Users;

use App\Events\Users\UserPesaswapAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use File;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get();
        return response($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function totalusers()
    {
        $count = User::count();
        $order = Order::count();
        $revenue = Order::where('status', 'completed')->sum('subtotal');

        return response()->json(['count'=>$count, 'order'=>$order, 'revenue'=>$revenue], 200);
    }

    public function notinpesaswap()
    {
        $users = User::whereNull('external_id')->get();
        if ($users != null) {
            foreach ($users as $user) {
                event(new UserPesaswapAccount($user));
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail(intval($id));
        $user->update([
            'firstname' => $request->firstName,
            'lastname'  => $request->lastName,
            'email'     => $request->email,
            'phone'     => $request->phoneNumber,
        ]);
        return response()->json(['data'=>$user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
