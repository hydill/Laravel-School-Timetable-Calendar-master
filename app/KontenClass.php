<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\returnCallback;

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
        return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
    }
    public function manageSiswa()
    {
        return $this->hasOne(ManageSiswa::class, 'konten_id', 'id');
    }
}
