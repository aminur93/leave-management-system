<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaveCategoryRequest;
use App\Http\Services\Admin\LeaveCategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\ValidationException;

class LeaveCategoryController extends Controller implements HasMiddleware
{
    private $leaveCategoryService;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:leaveCategory-list|leaveCategory-create|leaveCategory-edit|leaveCategory-destroy', only: ['index', 'store']),
            new Middleware('permission:leaveCategory-create', only: ['create','store']),
            new Middleware('permission:leaveCategory-edit', only: ['edit', 'update']),
            new Middleware('permission:leaveCategory-destroy', only: ['destroy'])
        ];
    }

    public function __construct(LeaveCategoryService $leaveCategoryService)
    {
        $this->leaveCategoryService = $leaveCategoryService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', true);

        if ($pagination === true)
        {
            $leaveCategory = $this->leaveCategoryService->index($request);

            return GlobalMessage::success($leaveCategory, "All leave category fetch successful", Response::HTTP_OK);
        }

        if ($pagination === 'false')
        {
            $leaveCategory = $this->leaveCategoryService->getAllLeaveCategory();

            return GlobalMessage::success($leaveCategory, "All leave category fetch successful", Response::HTTP_OK);
        }
    }

    public function store(LeaveCategoryRequest $request)
    {
        try {

            $leaveCategory = $this->leaveCategoryService->store($request);

            return GlobalMessage::success($leaveCategory, "Store successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit($id)
    {
        try {

            $leaveCategory = $this->leaveCategoryService->edit($id);

            return GlobalMessage::success($leaveCategory, "Fetch successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(LeaveCategoryRequest $request, $id)
    {
        try {

            $leaveCategory = $this->leaveCategoryService->update($request, $id);

            return GlobalMessage::success($leaveCategory, "Update successful", Response::HTTP_OK);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());
        }
    }

    public function destroy($id)
    {
        try {

            $leaveCategory = $this->leaveCategoryService->destroy($id);

            return GlobalMessage::success($leaveCategory, "Delete successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());
        }
    }

    public function changeStatus($id)
    {
        try {

            $this->leaveCategoryService->changeStatus($id);

            return GlobalMessage::success("", "Status change successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
