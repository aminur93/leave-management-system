<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Events\leaveNotificationEvent;
use App\Helper\GlobalMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaveRequest;
use App\Http\Services\Admin\LeaveService;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LeaveController extends Controller implements HasMiddleware
{
    private $leaveService;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:leave-list|leave-create|leave-edit|leave-destroy', only: ['index', 'store']),
            new Middleware('permission:leave-create', only: ['create','store']),
            new Middleware('permission:leave-edit', only: ['edit', 'update']),
            new Middleware('permission:leave-destroy', only: ['destroy'])
        ];
    }

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', true);

        if ($pagination === true)
        {
            $leave = $this->leaveService->index($request);

            return GlobalMessage::success($leave, "All leave fetch successful", Response::HTTP_OK);
        }

        if ($pagination === 'false')
        {
            $leave = $this->leaveService->getAllLeave();

            return GlobalMessage::success($leave, "All leave fetch successful", Response::HTTP_OK);
        }
    }

    public function store(LeaveRequest $request)
    {
        try {

            $leave = $this->leaveService->store($request);

            $user = User::findOrFail($leave->user_id);

            event(new LeaveNotificationEvent($user, $leave));

            return GlobalMessage::success($leave, "Store successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalMessage::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit($id)
    {
        try {

            $leave = $this->leaveService->edit($id);

            return GlobalMessage::success($leave, "Leave fetch successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());
        }
    }

    public function update(LeaveRequest $request, $id)
    {
        try {

            $leave = $this->leaveService->update($request, $id);

            $user = User::findOrFail($leave->user_id);

            event(new LeaveNotificationEvent($user, $leave));

            return GlobalMessage::success($leave, "Update successful", Response::HTTP_OK);

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

            $leave = $this->leaveService->destroy($id);

            return GlobalMessage::success($leave, "Delete successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), $exception->getCode());
        }
    }

    public function leaveStatus(Request $request, $id)
    {
        try {

            $this->leaveService->leaveStatus($request,$id);

            $leave = Leave::findOrFail($id);

            $user = User::findOrFail($leave->user_id);

            event(new LeaveNotificationEvent($user, $leave));

            return GlobalMessage::success($leave, "Leave status updated successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalMessage::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
