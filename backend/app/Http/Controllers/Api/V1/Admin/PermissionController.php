<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Services\Admin\PermissionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller implements HasMiddleware
{
    private $permissionService;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:permision-list|permision-create|permision-edit|permision-destroy', only: ['index', 'store']),
            new Middleware('permission:permision-create', only: ['create','store']),
            new Middleware('permission:permision-edit', only: ['edit', 'update']),
            new Middleware('permission:permision-destroy', only: ['destroy'])
        ];
    }

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', true);

        if ($pagination === true) {

            $permission = $this->permissionService->index($request);

            return GlobalMessage::success($permission, "All Permissions fetch successful", \Illuminate\Http\Response::HTTP_OK);

        }

        if ($request->get('pagination') === "false")
        {
            $permissions = $this->permissionService->getAllPermissions();

            return GlobalMessage::success($permissions, "All permissions fetch successful", \Illuminate\Http\Response::HTTP_OK);
        }
    }

    public function store(PermissionRequest $request)
    {
        try {

            $permission = $this->permissionService->store($request);

            return GlobalMessage::success($permission, "Store successful", \Illuminate\Http\Response::HTTP_CREATED);

        } catch (ValidationException $exception) {

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        } catch (\Exception $exception) {

            return GlobalMessage::error("", $exception->getMessage(), $exception->status);
        }
    }

    public function edit($id)
    {
        try {
            $permission = $this->permissionService->edit($id);

            return GlobalMessage::success($permission, "permission fetch successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_NOT_FOUND);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->status);
        }
    }

    public function update(PermissionRequest $request, $id)
    {
        try {
            $permission = $this->permissionService->update($request, $id);

            return GlobalMessage::success($permission, "Update successful", Response::HTTP_OK);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_NOT_FOUND);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->status);
        }
    }

    public function destroy($id)
    {
        try {
            $this->permissionService->destroy($id);

            return GlobalMessage::success("", "Delete successful", Response::HTTP_NO_CONTENT);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_NOT_FOUND);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
