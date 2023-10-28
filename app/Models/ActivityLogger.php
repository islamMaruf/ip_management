<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'payload',
        'userType',
        'userId',
        'route',
        'ipAddress',
        'userAgent',
        'referer',
        'methodType'
    ];
}
