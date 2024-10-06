<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table = "holidays"; //table name
    protected $fillable = [
        "title",                   //field names
        "date"             
    ]; 
}
