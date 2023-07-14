<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
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
}
