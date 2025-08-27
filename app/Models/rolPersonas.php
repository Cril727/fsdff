<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolPersona extends Model
{
    protected $table = 'rol_personas';

    protected $fillable = ['persona_id', 'rol_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}