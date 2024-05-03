<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\Auth\RegisterService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(UserRequest $request)
    {
        try {

            $user = $this->registerService->register($request);

            return GlobalMessage::success($user, "Register successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
