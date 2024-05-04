<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    public function leaveCategory()
    {
        return $this->belongsTo(LeaveCategory::class);
    }

    public function leaveComment()
    {
        return $this->hasMany(LeaveComment::class);
    }
}
