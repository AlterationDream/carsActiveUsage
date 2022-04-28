<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\ParametersValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    private ParametersValidationService $validator;

    public function __construct() {
        $this->validator = new ParametersValidationService('car');
    }


    public function list(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('list', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $limit = -1;
        if ($request->exists('limit')) $limit = $request->limit;
        $cars = Car::limit($limit)->get();

        return response()->json($cars, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function create(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('create', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $car = new Car;
        $car->name = trim($request->name);
        $car->save();

        return response()->json($car, 201, [], JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('update', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $car = Car::find($request->id);
        $car->name = trim($request->name);
        $car->save();

        return response()->json($car, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function delete(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('delete', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);


        $car = Car::find($request->id);
        $car->delete();

        return response()->json($car, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
