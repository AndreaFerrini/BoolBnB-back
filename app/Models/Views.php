<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    use HasFactory;

    protected   $table      =   'Views';
    
    protected   $fillable   =   [
                                    'apartment_id',
                                    'data'
                                ]; 

    public  function    apartment()
    {
        return $this->belogsTo(Apartment::class);
    }  
}
