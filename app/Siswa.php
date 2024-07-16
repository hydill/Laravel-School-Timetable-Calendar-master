<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'siswas';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'named',
        // 'nis', 
        'gender', 
        'address', 
        'phone_number',
        'class_id', 
        'created_at', 
        'updated_at',
    ];
    
    public function manageSiswa()
    {
        return $this->hasMany(ManageSiswa::class, 'siswa_id', 'id'); //hasMany //hasOne
    }
    public function class()
    {
       return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
    }

    public function siswaMessage()
    {
        return $this->belongsToMany(Message::class, 'message_siswa'); //hasMany
    }

    // analisis relasi di atas
}
