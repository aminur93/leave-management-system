<?php

namespace App\Http\Services\Admin;

use App\Models\LeaveComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveCommentService
{
    public function index(Request $request)
    {
        $leave_comment = LeaveComment::with('leave', 'user');

        if ($request->has('sortBy') && $request->has('sortDesc'))
        {
            $sortBy = $request->query('sortBy');
            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';
            $leave_comment = $leave_comment->orderBy($sortBy, $sortDesc);
        }else{
            $leave_comment = $leave_comment->latest();
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $leave_comment->where(function ($query) use ($searchValue) {
                $query->where('comment', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $leave_comment->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $leave_comment->paginate($itemsPerPage);
        }

        return $leave_comment->paginate($defaultItemsPerPage);
    }

    public function getAllLeaveComment()
    {
        $leave_comment = LeaveComment::with('leave', 'user')->latest()->get();

        return $leave_comment;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            //storing leave comment

            $leave_comment = new LeaveComment();

            $leave_comment->user_id = Auth::id();
            $leave_comment->leave_id = $request->leave_id;
            $leave_comment->comment = $request->comment;

            $leave_comment->save();

            DB::commit();

            return $leave_comment;

        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }

    public function destroy($id)
    {
        $leave_comment = LeaveComment::findOrFail($id);

        $leave_comment->delete();

        return $leave_comment;
    }
}
