<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class KontenClass extends Model
{
    use SoftDeletes;

    public $table = 'kontens';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'desc',
        'class_id',
        'created_at',
        'updated_at',
        
    ];

    // public function Kontens()
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
