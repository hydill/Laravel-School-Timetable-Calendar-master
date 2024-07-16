<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'students';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'named',
        'nis', 
        'gender', 
        'address', 
        'phone_number',
        'class_id', 
        'created_at', 
        'updated_at',
    ];

    public function class()
    {
       return $this->belongsTo(SchoolClass::class, 'çlass_id');
    }
}
