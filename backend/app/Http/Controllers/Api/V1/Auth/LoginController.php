<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Auth\LoginService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request)
    {
        try {

            $login = $this->loginService->login($request);

            return GlobalMessage::success($login, "Login successful", Response::HTTP_OK);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {
        $this->loginService->logout($request);

        return GlobalMessage::success("", "Logout successful", Response::HTTP_OK);
    }

    public function checkToken()
    {
        return response()->json(['success' => true], Response::HTTP_OK);
    }
}
