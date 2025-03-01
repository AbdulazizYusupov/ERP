<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use ActionTrait;
    protected $fillable = ['phone', 'address', 'section_id', 'user_id', 'salary', 'salary_type_id', 'month_time', 'start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function salary_type()
    {
        return $this->belongsTo(Salary_type::class, 'salary_type_id');
    }
}
