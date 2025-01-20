<?php

namespace Utils\Helpers;

use Responses\ErrorResponse;

class RequestHelper
{

    /**
     * Returns data from POST request. If _POST is empty it tries to use file_get_contents to get data.
     * If both are empty return empty array.
     *
     * @return array
     */
    public static function getPostData(): array{
        if(count($_POST) !== 0){
            return $_POST;
        }
        $input = file_get_contents('php://input');
        if($input){
            return json_decode($input, true);
        }
        return [];
    }

    public static function getGetData(): array{
        return $_GET;
    }

    public static function validateInput(array $requiredFields, array $passedData): void{
        $isValid = true;
        foreach($requiredFields as $field){
            $isValid = $isValid && isset($passedData[$field]);
        }

        if(!$isValid){
            die(
                (new ErrorResponse(['message' => 'Some fields were not provided']))
                    ->toJson()
            );
        }
    }
}