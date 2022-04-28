<?php
namespace App\Services;

/**
 * Сервис управляющий выдачей локализованных сообщений валидации параметров.
 * */
class ValidationMessageService
{

    public function integer($gender) : string
    {
        $gender = $this->hasTo($gender);
        return ' долж' . $gender . ' быть целочисленным значением';
    }

    public function string($gender) : string
    {
        $gender = $this->hasTo($gender);
        return ' долж' . $gender . ' быть строковым значением';
    }

    public function empty($gender) : string
    {
        switch ($gender) {
            case 'n' | 'm':
                $gender = 'ым';
                break;
            case 'f':
                $gender = 'ой';
                break;
        }
        return ' не может быть пуст' . $gender . '.';
    }

    public function unique() : string
    {
        return ' уже присутствует в базе данных.';
    }

    public function exists($gender) : string
    {
        $gender = $this->found($gender);
        return ' не найден' . $gender . ' в базе данных.';
    }

    public function lessThan($value) : string
    {
        return ' не может быть меньше ' . $value;
    }

    public function used($gender) : string
    {
        return ' не может быть удален' . $this->found($gender) . ', пока участвует в активном использовании.';
    }

    private function hasTo($gender) : string
    {
        switch ($gender) {
            case 'n':
                $gender = 'но';
                break;
            case 'm':
                $gender = 'ен';
                break;
            case 'f':
                $gender = 'на';
                break;
        }
        return $gender;
    }

    private function for($action) : string
    {
        switch ($action) {
            case 'e':
                $action = ' для редактирования.';
                break;
            case 'd':
                $action = ' для удаления.';
                break;
        }
        return $action;
    }

    private function found($gender) : string
    {
        switch ($gender) {
            case 'm':
                return '';
                break;
            case 'f':
                return 'а';
                break;
            case 'n':
                return 'о';
                break;
        }
    }
}
