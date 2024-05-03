<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Services\Admin\RoleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller implements HasMiddleware
{
    private $roleService;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:role-list|user-create|role-edit|role-destroy', only: ['index', 'store']),
            new Middleware('permission:role-create', only: ['create','store']),
            new Middleware('permission:role-edit', only: ['edit', 'update']),
            new Middleware('permission:role-destroy', only: ['destroy'])
        ];
    }

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get("pagination", true);

        if ($pagination === true)
        {
            $roles = $this->roleService->index($request);

            return GlobalMessage::success($roles, "All roles fetch successfyl", Response::HTTP_OK);
        }

        if ($request->get("pagination") === "false")
        {
            $roles = $this->roleService->getAllRole();

            return GlobalMessage::success($roles, "All roles fetch successfyl", Response::HTTP_OK);
        }
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleService->store($request);

            return GlobalMessage::success($role, "store successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->status);
        }
    }

    public function edit($id)
    {
        try {

            $role = $this->roleService->edit($id);

            return GlobalMessage::success($role, "role fetch successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_NOT_FOUND);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {

            $role = $this->roleService->update($request, $id);

            return GlobalMessage::success($role, "update successful", Response::HTTP_OK);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_NOT_FOUND);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function destroy($id)
    {
        try {

            $role = $this->roleService->destroy($id);

            return GlobalMessage::success($role, "destroy successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_NOT_FOUND);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
