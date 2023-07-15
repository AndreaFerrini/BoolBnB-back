<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected   $table      =   'Messages';
    
    protected   $fillable   =   [
                                    'apartment_id',
                                    'name',
                                    'surname',
                                    'email',
                                    'email_body'
                                ];

    public  function apartment()
    {
        return $this->belogsTo(Apartment::class);
    } 
}
