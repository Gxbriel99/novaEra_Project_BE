<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    // Nome della tabella nel database
    protected $table = 'user';
    protected $primaryKey = 'idUser';

    // Campi assegnabili in massa
    protected $fillable = [
        'name',
        'surname',
        'email',
        'created_at',
        'deleted_at'
    ];


    //Questa Relazione ritorna tutti i tickets relativi all' utente
    public function tickets()
    {
        return $this->hasMany(AssistentChat::class, 'idUser');
    }

}
