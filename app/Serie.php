<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';
    
    protected $fillable=[
        'resolucion',
        'serie',     
        'fecha_resolucion',
        'fecha_vencimiento',
        'inicio',
        'fin',
        'estado_serie_id',
        'user_id',
        'documento_id'
    ];

    public function estados(){
        return $this->belongsTo(EstadoSerie::class);
    }

    public function documentos(){
        return $this->belongsTo(Documento::class);
    }
    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
