<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;


    protected $fillable = [
    	'car_id',
        'user_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'additional_info',
        'type',
        'email_address',
        'phone_number',
        'reference_code',
        'pickuplocation',
        'dropofflocation',
    ];


}
