<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class picture extends Model
{
    use HasFactory;

    protected   $table      =   'Pictures';
    
    protected   $fillable   =   [
                                    'apartment_id',
                                    'picture_url'
                                ]; 

    public  function    apartment()
    {
        return $this->belogsTo(Apartment::class);
    }  
}
