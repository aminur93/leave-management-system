<?php

namespace App\Http\Services\Admin;

use App\Models\LeaveCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveCategoryService
{
    public function index(Request $request)
    {
        $leaveCategory = new LeaveCategory;

        if ($request->has('sortBy') && $request->has('sortDesc'))
        {
            $sortBy = $request->query('sortBy');
            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';
            $leaveCategory = $leaveCategory->orderBy($sortBy, $sortDesc);
        }else{
            $leaveCategory = $leaveCategory->latest();
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $leaveCategory->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $leaveCategory->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $leaveCategory->paginate($itemsPerPage);
        }

        return $leaveCategory->paginate($defaultItemsPerPage);
    }

    public function getAllLeaveCategory()
    {
        $leaveCategory = LeaveCategory::latest()->get();

        return $leaveCategory;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // storing leave category

            $leave_category = new LeaveCategory();

            $leave_category->name = $request->name;

            $leave_category->leave_total = $request->leave_total;

            if ($request->status != null)
            {
                $leave_category->status = 1;
            }else{
                $leave_category->status = 0;
            }

            $leave_category->save();

            DB::commit();

            return $leave_category;

        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }

    public function edit($id)
    {
        $leave_category = LeaveCategory::findOrFail($id);

        return $leave_category;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            // update leave category

            $leave_category = LeaveCategory::findOrFail($id);

            $leave_category->name = $request->name ?? $leave_category->name;
            $leave_category->leave_total = $request->leave_total ?? $leave_category->leave_total;

            if ($request->status != null)
            {
                $leave_category->status = 1;
            }else{
                $leave_category->status = 0;
            }

            $leave_category->save();

            DB::commit();

            return $leave_category;

        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }

    public function destroy($id)
    {
        $leave_category = LeaveCategory::findOrFail($id);

        $leave_category->delete();

        return $leave_category;
    }
}
