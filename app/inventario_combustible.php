<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventario_combustible extends Model
{
	protected $table='inventario_combustible';

	protected $fillable=[
	'id',
	'fecha_inventario',
	'gal_sup_entrada',
	'gal_sup_salida',
	'gal_sup_existencia',
	'precio_promedio_sup',
	'subtotal_entrada_sup',
	'subtotal_salida_sup',
	'subtotal_exis_sup',
	'gal_reg_entrada',
	'gal_reg_salida',
	'gal_reg_existencia',
	'precio_promedio_reg',
	'subtotal_entrada_reg',
	'subtotal_salida_reg',
	'subtotal_exis_reg',
	'gal_die_entrada',
	'gal_die_salida',
	'gal_die_existencia',
	'precio_promedio_die',
	'subtotal_entrada_die',
	'subtotal_salida_die',
	'subtotal_exis_die',
	'estado',
	'user_id'
	];

	public function user(){
		return $this->belongsTo('App\User');
	}
}
