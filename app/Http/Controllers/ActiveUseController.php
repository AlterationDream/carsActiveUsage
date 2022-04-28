<?php

namespace App\Http\Controllers;

use App\Models\ActiveUse;
use App\Services\ParametersValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ActiveUseController extends Controller
{
    private ParametersValidationService $validator;

    public function __construct() {
        $this->validator = new ParametersValidationService();
    }


    public function list(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('list', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $limit = -1;
        if ($request->exists('limit')) $limit = $request->limit;
        $activeUses = ActiveUse::limit($limit)->get();

        return response()->json($activeUses, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function create(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('create', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $activeUse = new ActiveUse();
        $activeUse->user_id = $request->user_id;
        $activeUse->car_id = $request->car_id;
        $activeUse->save();

        return response()->json($activeUse, 201, [], JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('update', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $activeUse = ActiveUse::find($request->id);
        $activeUse->car_id = $request->car_id;
        $activeUse->user_id = $request->user_id;
        $activeUse->save();

        return response()->json($activeUse, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function delete(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('delete', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $activeUse = ActiveUse::find($request->id);
        $activeUse->delete();

        return response()->json($activeUse, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
