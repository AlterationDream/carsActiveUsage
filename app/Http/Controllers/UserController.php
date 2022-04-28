<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ParametersValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private ParametersValidationService $validator;

    public function __construct() {
        $this->validator = new ParametersValidationService('user');
    }


    public function list(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('list', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $limit = -1;
        if ($request->exists('limit')) $limit = $request->limit;
        $users = User::limit($limit)->get();

        return response()->json($users, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function create(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('create', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $user = new User;
        $user->name = trim($request->name);
        $user->save();

        return response()->json($user, 201, [], JSON_UNESCAPED_UNICODE);
    }

    public function update(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('update', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $user = User::find($request->id);
        $user->name = trim($request->name);
        $user->save();

        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function delete(Request $request) : JsonResponse
    {
        $validator = $this->validator->validateCase('delete', $request);
        if ($validator->fails()) return response()
            ->json($validator->messages(), Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);

        $user = User::find($request->id);
        $user->delete();

        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
