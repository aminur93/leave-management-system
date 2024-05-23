<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaveCommentrequest;
use App\Http\Services\Admin\LeaveCommentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\ValidationException;

class LeaveCommentController extends Controller implements HasMiddleware
{
    private $leaveCommentService;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:leaveComment-list|leaveComment-create|leaveComment-edit|leaveComment-destroy', only: ['index', 'store']),
            new Middleware('permission:leaveComment-create', only: ['create','store']),
            new Middleware('permission:leaveComment-edit', only: ['edit', 'update']),
            new Middleware('permission:leaveComment-destroy', only: ['destroy'])
        ];
    }

    public function __construct(LeaveCommentService $leaveCommentService)
    {
        $this->leaveCommentService = $leaveCommentService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', true);

        if ($pagination === true)
        {
            $leave_comment = $this->leaveCommentService->index($request);

            return GlobalMessage::success($leave_comment, "All leave comment fetch successful", Response::HTTP_OK);

        }

        if ($pagination === "false")
        {
            $leave_comment = $this->leaveCommentService->getAllLeaveComment();

            return GlobalMessage::success($leave_comment, "All leave comment fetch successful", Response::HTTP_OK);
        }
    }

    public function store(LeaveCommentrequest $request)
    {
        try {

            $leave_comment = $this->leaveCommentService->store($request);

            return GlobalMessage::success($leave_comment, "Store successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {

            $leave_comment = $this->leaveCommentService->destroy($id);

            return GlobalMessage::success($leave_comment, "Delete successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
