<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    use HasFactory;

    protected  $fillable=[
        'name',
        'phone',
        'email',
        'invitation_time',
        'invitation_expiry',
        'password',
        'status'
    ];


}
