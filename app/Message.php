<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;

    public $table = 'messages';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'lesson_id',
        'created_at',
        'updated_at',
    ];
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'message_siswa'); //belongsToMany //belongsTo
    }
    public function lesson()
    {
        return $this->belongsToMany(Lesson::class);
    }
    public function catatan()
    {
        return $this->belongsToMany(ManageSiswa::class);
    }

    // analisis relasi di atas
}
