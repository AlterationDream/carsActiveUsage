<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParametersValidationService
{
    private const ACTIVE_USE_ID = 'ID активного использования';
    private const USER_ID = 'ID водителя';
    private const CAR_ID = 'ID машины';
    private const PAR_LIMIT = 'Параметр limit';

    private string $case;
    private string $unitSingular;
    private string $unitGender;
    private string $unitName;
    private string $unitID;
    private ValidationMessageService $message;

    public function __construct($case = '')
    {
        $this->message = new ValidationMessageService();
        $this->case = $case;
    }

    public function validateCase($action, $request) : \Illuminate\Contracts\Validation\Validator
    {
        switch ($this->case) {
            case 'car':
                $this->unitName = 'Название машины';
                $this->unitID = 'ID машины';
                $this->unitSingular = 'Машина';
                $this->unitGender = 'f';
                return $this->unitValidation($action, $request);
            case 'user':
                $this->unitName = 'Название водителя';
                $this->unitID = 'ID водителя';
                $this->unitSingular = 'Водитель';
                $this->unitGender = 'm';
                return $this->unitValidation($action, $request);
            default:
                return $this->linkValidation($action, $request);
        }
    }

    private function linkValidation(string $action, Request $request): \Illuminate\Contracts\Validation\Validator
    {
        switch ($action) {
            case 'list':
                return Validator::make($request->all(), [
                    'limit' => 'integer|min:-1'
                ], [
                    'limit.integer' => self::PAR_LIMIT . $this->message->integer('m'),
                    'limit.min' => self::PAR_LIMIT . $this->message->lessThan(-1)
                ]);

            case 'create':
                return Validator::make($request->all(), [
                    'user_id' => 'required|integer|unique:active_uses,user_id|exists:users,id',
                    'car_id' => 'required|integer|unique:active_uses,car_id|exists:cars,id'
                ], [
                    'user_id.integer' => self::USER_ID . $this->message->integer('m'),
                    'user_id.unique' => self::USER_ID . $this->message->unique(),
                    'user_id.exists' => self::USER_ID . $this->message->exists('m'),
                    'car_id.integer' => self::CAR_ID . $this->message->integer('m'),
                    'car_id.unique' => self::CAR_ID . $this->message->unique(),
                    'car_id.exists' => self::CAR_ID . $this->message->exists('m')
                ]);

            case 'update':
                return Validator::make($request->all(), [
                    'id' => 'required|integer|exists:active_uses,id',
                    'user_id' => 'required|integer|exists:users,id|unique:active_uses,user_id,' . $request->id,
                    'car_id' => 'required|integer|exists:cars,id|unique:active_uses,car_id,' . $request->id
                ], [
                    'id.integer' => self::ACTIVE_USE_ID . $this->message->integer('m'),
                    'id.exists' => self::ACTIVE_USE_ID . $this->message->exists('m'),
                    'user_id.integer' => self::USER_ID . $this->message->integer('m'),
                    'user_id.exists' => self::USER_ID . $this->message->exists('m'),
                    'user_id.unique' => self::USER_ID . $this->message->unique(),
                    'car_id.integer' => self::CAR_ID . $this->message->integer('m'),
                    'car_id.exists' => self::CAR_ID . $this->message->exists('m'),
                    'car_id.unique' => self::CAR_ID . $this->message->unique()
                ]);

            case 'delete':
                return Validator::make($request->all(), [
                    'id' => 'integer|required'
                ], [
                    'id.integer' => self::ACTIVE_USE_ID . $this->message->integer('m'),
                    'id.exists' => self::ACTIVE_USE_ID . $this->message->exists('m')
                ]);
        }
    }

    private function unitValidation(string $action, Request $request) : \Illuminate\Contracts\Validation\Validator
    {
        switch ($action){
            case 'list':
                return Validator::make($request->all(), [
                    'limit' => 'integer|min:-1'
                ],[
                    'limit.integer' => self::PAR_LIMIT . $this->message->integer('m'),
                    'limit.min' => self::PAR_LIMIT . $this->message->lessThan(-1)
                ]);
            case 'create':
                return Validator::make($request->all(), [
                    'name' => 'required|string|min:1|unique:' . $this->case . 's,name'
                ],[
                    'name.string' => $this->unitName . $this->message->string('n'),
                    'name.min' => $this->unitName . $this->message->empty('n'),
                    'name.unique' => $this->unitName . $this->message->unique()
                ]);
            case 'update':
                return Validator::make($request->all(), [
                    'id' => 'required|integer|exists:' . $this->case . 's,id',
                    'name' => 'required|string|min:1|unique:' . $this->case .'s,name,' . $request->id
                ],[
                    'id.integer' => $this->unitID . $this->message->integer('m'),
                    'id.exists' => $this->unitID . $this->message->exists('m'),
                    'name.string' => $this->unitName . $this->message->string('m'),
                    'name.min' => $this->unitName . $this->message->empty('m'),
                    'name.unique' => $this->unitName . $this->message->unique()
                ]);
            case 'delete':
                return Validator::make($request->all(), [
                    'id' => 'required|integer|exists:' . $this->case. 's,id|unique:active_uses,' . $this->case . '_id'
                ],[
                    'id.integer' => $this->unitID . $this->message->integer('m'),
                    'id.exists' => $this->unitID . $this->message->exists('m'),
                    'id.unique' => $this->unitSingular . $this->message->used($this->unitGender)
                ]);
        }
    }
}
