<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Flight extends Model
{
    use HasFactory,softDeletes;
    protected $primaryKey = 'flight_id';
    protected $table ='flights';
    protected $fillable=[
        'flight_name',
        'arrival',
        'destination',
    ];
}
