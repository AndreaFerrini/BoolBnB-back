<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected   $table      = "Sponsors";

    protected   $fillable   = ['name', 'period', 'price']; 

    public  function apartments() 
    {
        return $this->belongsToMany(Apartment::class);
    }
}
