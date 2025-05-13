<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regente extends Model
{
    protected $table = 'regente';
    protected $primaryKey = 'Id_Regente';
    public $timestamps = true;

    protected $fillable = [
        'Nombre',
        'Apellido',
        'DNI',
        'Fecha_Contratacion',
        'Licencia',
        'Correo',
        'Telefono',
        'Contraseña_Encriptada',
        'Id_Turno',
        'token_recuperacion',
        'token_expiracion',
    ];

    public function turno()
    {
        return $this->belongsTo(TurnoRegente::class, 'Id_Turno');
    }

    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class, 'Id_Regente');
    }
}
