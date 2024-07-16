<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManageSiswa extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'manage_siswas';

    protected $date = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'about',
        'photo_path',
        'class_id',
        'siswa_id',
        'konten_id',
        'lesson_id',
    ];

    public function class() 
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function konten()
    {
        return $this->belongsTo(KontenClass::class, 'konten_id');
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
    public function manageMessage()
    {
        return $this->belongsToMany(Message::class);
    }

    // analisis relasi tabel di atas
}
