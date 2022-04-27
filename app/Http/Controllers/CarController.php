<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\ValidationMessageService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private const CAR_NAME = 'Название машины';
    private const CAR_ID = 'ID машины';

    private $message;

    public function __construct() {
        $this->message = new ValidationMessageService();
    }

    public function index() {
        $cars = Car::all();
        return view('cars', ['cars' => $cars]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'string|min:1|unique:cars,name'
        ],[
            'name.string' => self::CAR_NAME . $this->message->string('n'),
            'name.min' => self::CAR_NAME . $this->message->empty('n'),
            'name.unique' => self::CAR_NAME . $this->message->unique()
        ]);

        $car = new Car;
        $car->name = $request->name;
        $car->save();

        return back();
    }

    public function update(Request $request) {

        $this->validate($request, [
            'id' => 'integer|exists:cars,id',
            'name' => 'string|min:1|unique:cars,name'
        ],[
            'id.integer' => self::CAR_ID . $this->message->integer('m'),
            'name.string' => self::CAR_NAME . $this->message->string('m'),
            'name.min' => self::CAR_NAME . $this->message->empty('m'),
            'name.unique' => self::CAR_NAME . $this->message->unique()
        ]);

        $car = Car::find($request->id);
        $car->name = trim($request->name);
        $car->save();

        return back();
    }

    public function remove(Request $request) {
        $this->validate($request, [
            'id' => 'integer'
        ],[
            'id.integer' => self::CAR_ID . $this->message->integer('m')
        ]);

        $car = Car::find($request->id);
        $car->delete();

        return back();
    }
}
