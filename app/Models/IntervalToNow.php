<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervalToNow extends Model
{
    use HasFactory;

    protected $table = 'interval_to_now';
    protected $fillable = ['name'];
}
