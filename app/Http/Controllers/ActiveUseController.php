<?php

namespace App\Http\Controllers;

use App\Models\ActiveUse;
use App\Models\Car;
use App\Models\User;
use App\Services\ValidationMessageService;
use Illuminate\Http\Request;

class ActiveUseController extends Controller
{
    private const ACTIVE_USE_ID = 'ID активного использования';
    private const USER_ID = 'ID водителя';
    private const CAR_ID = 'ID машины';

    private $message;

    public function __construct()
    {
        $this->message = new ValidationMessageService();
    }

    public function index() {
        $activeUses = ActiveUse::all();
        $cars = Car::all();
        $users = User::all();
        return view('active-uses', [
            'activeUses' => $activeUses,
            'cars' => $cars,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'integer|unique:active_uses,user_id',
            'car_id' => 'integer|unique:active_uses,car_id'
        ],[
            'user_id.integer' => self::USER_ID . $this->message->integer('m'),
            'user_id.unique' => self::USER_ID . $this->message->unique(),
            'car_id.integer' => self::CAR_ID . $this->message->integer('m'),
            'car_id.unique' => self::CAR_ID . $this->message->unique()
        ]);

        $activeUse = new ActiveUse();
        $activeUse->user_id = $request->user_id;
        $activeUse->car_id = $request->car_id;
        $activeUse->save();

        return back();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer|exists:active_uses,id',
            'user_id' => 'integer|unique:active_uses,user_id,' . $request->id,
            'car_id' => 'integer|unique:active_uses,car_id,' . $request->id
        ],[
            'id.integer' => self::ACTIVE_USE_ID . $this->message->integer('m'),
            'id.exists' => self::ACTIVE_USE_ID . $this->message->exists('m'),
            'user_id.integer' => self::USER_ID . $this->message->integer('m'),
            'user_id.exists' => self::USER_ID . $this->message->exists('m'),
            'car_id.integer' => self::CAR_ID . $this->message->integer('m'),
            'car_id.exists' => self::CAR_ID . $this->message->exists('m')
        ]);

        $activeUse = ActiveUse::find($request->id);
        $activeUse->car_id = $request->car_id;
        $activeUse->user_id = $request->user_id;
        $activeUse->save();

        return back();
    }

    public function remove(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer'
        ],[
            'id.integer' => self::ACTIVE_USE_ID . $this->message->integer('m')
        ]);

        $activeUse = ActiveUse::find($request->id);
        $activeUse->delete();

        return back();
    }
}
