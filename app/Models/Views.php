<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Views;

class ViewSeeder extends Seeder
{
    public  function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
