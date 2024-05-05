<?php

namespace App\Http\Services\Admin;

use App\Events\leaveNotificationEvent;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveService
{
    public function index(Request $request)
    {
        $leave = Leave::with('leaveCategory', 'leaveComment', 'user');

        if ($request->has('sortBy') && $request->has('sortDesc'))
        {
            $sortBy = $request->query('sortBy');
            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';
            $leave = $leave->orderBy($sortBy, $sortDesc);
        }else{
            $leave = $leave->latest();
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $leave->where(function ($query) use ($searchValue) {
                $query->where('title', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $leave->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $leave->paginate($itemsPerPage);
        }

        return $leave->paginate($defaultItemsPerPage);
    }

    public function getAllLeave()
    {
        $leaves = Leave::with('leaveCategory', 'leaveComment');

        return $leaves;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // storing leave

            $leave = new Leave();

            $leave->user_id = Auth::id();
            $leave->leave_category_id = $request->leave_category_id;
            $leave->title = $request->title;
            $leave->start_date = $request->start_date;
            $leave->end_date = $request->end_date;

            /*finding total days from start date and end date*/
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);

            $total_days = abs($end_date->diffInDays($start_date));

            $leave->total_days = $total_days;

            /*finding total days from start date and end date*/

            $leave->description = $request->description;

            if ($request->status != null)
            {
                $leave->status = 1;
            }else{
                $leave->status = 0;
            }

            $leave->save();

            DB::commit();

            return $leave;

        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }

    public function edit($id)
    {
        $leave = Leave::with('leaveCategory', 'leaveComment')->where('id', $id)->first();

        return $leave;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            // storing leave

            $leave = Leave::findOrFail($id);

            $leave->user_id = Auth::id();
            $leave->leave_category_id = $request->leave_category_id ?? $leave->leave_category_id;
            $leave->title = $request->title ?? $leave->title;
            $leave->start_date = $request->start_date ?? $leave->start_date;
            $leave->end_date = $request->end_date ?? $leave->end_date;

            /*finding total days from start date and end date*/
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);

            $total_days = $end_date->diffInDays($start_date);

            $leave->total_days = $total_days ?? $leave->total_days;
            /*finding total days from start date and end date*/

            $leave->description = $request->description ?? $leave->description;

            if ($request->status != null)
            {
                $leave->status = 1;
            }else{
                $leave->status = 0;
            }

            $leave->save();

            DB::commit();

            return $leave;

        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }

    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);

        $leave->delete();

        return $leave;
    }

    public function leaveStatus(Request $request, $id)
    {
        $leave = Leave::where('id',$id)->update(['status' => $request->status]);
    }
}
