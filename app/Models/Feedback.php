<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'AppointNo',
        'staff',
        'FeedDescription',
        
    ];
    // protected $guarded = [];
    protected $primaryKey = 'FeedId';
    public function appointment(){
        return $this->hasOne(Appointment::class, 'AppointNo', 'AppointId');
    }
}
