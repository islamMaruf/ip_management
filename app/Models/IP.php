<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    use HasFactory;

    protected $table = 'ips';

    protected $fillable = [
      'ip',
      'comment'
    ];
}
