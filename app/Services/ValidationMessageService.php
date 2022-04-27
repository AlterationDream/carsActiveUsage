<?php
namespace App\Services;

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
