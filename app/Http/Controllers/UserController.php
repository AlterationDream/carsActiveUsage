<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ValidationMessageService;

class UserController extends Controller
{
    private const USER_NAME = 'Имя водителя';
    private const USER_ID = 'ID водителя';

    private $message;

    public function __construct() {
        $this->message = new ValidationMessageService();
    }

    public function index() {
        $users = User::all();
        return view('users', ['users' => $users]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'string|min:1|unique:users,name'
        ],[
            'name.string' => self::USER_NAME . $this->message->string('m'),
            'name.min' => self::USER_NAME . $this->message->empty('m'),
            'name.unique' => self::USER_NAME . $this->message->unique()
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->save();

        return back();
    }

    public function update(Request $request) {
        $this->validate($request, [
            'id' => 'integer|exists:users,id',
            'name' => 'string|min:1|unique:users,name'
        ],[
            'id.integer' => self::USER_ID . $this->message->integer('m'),
            'name.string' => self::USER_NAME . $this->message->string('m'),
            'name.min' => self::USER_NAME . $this->message->empty('m'),
            'name.unique' => self::USER_NAME . $this->message->unique()
        ]);

        $user = User::find($request->id);
        $user->name = trim($request->name);
        $user->save();

        return back();
    }

    public function remove(Request $request) {
        $this->validate($request, [
            'id' => 'integer'
        ],[
            'id.integer' => self::USER_ID . $this->message->integer('m')
        ]);

        $user = User::find($request->id);
        $user->delete();

        return back();
    }
}
