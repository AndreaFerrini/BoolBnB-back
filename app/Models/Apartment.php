<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected   $table      =   'Apartments';

    protected   $fillable   =   [
                                    'user_id',
                                    'longitude',
                                    'latitude',
                                    'title',
                                    'slug',
                                    'address',
                                    'city',
                                    'cover_img',
                                    'description',
                                    'number_of_rooms',
                                    'number_of_bathrooms',
                                    'square_meters',
                                    'price',
                                    'visibility'
                                ];

    public  function user()
    {
        return $this->belogsTo(User::class);
    }

    public  function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public  function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }

    public  function messages()
    {
        return $this->hasMany(Message::class);
    }

    public  function pictures()
    {
        return $this->hasMany(Picture::class);
    } 

    public function getCap()
    {
        $addressArray = explode(' ', $this->address);
        return end($addressArray);
    }

    public function getCivico()
    {
        $addressArray = explode(' ', $this->address);
        return $addressArray[count($addressArray) - 2];
    }

    public function getIndirizzo()
    {
        $addressArray = explode(' ', $this->address);
        $addressArray = array_map(function ($item) {
            return str_replace(',', '', $item);
        }, $addressArray);
        return implode(' ', array_slice($addressArray, 0, -2));
    }
}
