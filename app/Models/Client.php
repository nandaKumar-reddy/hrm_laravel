<?php

namespace App\Models;

use App\Traits\GeneratesId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'industry_type',
        'client_number',
        'client_address',
        'pan',
        'gst',
        'tan_number',
        'cin_number',
        'pf_num',
        'esi_num',
        'pt_num',
        'lwf_num',
        'poc_name',
        'poc_designation',
        'poc_email',
        'poc_number',
        'status',
    ];

    // protected static function boot()
    // {
    //     parent::boot();
        
    //     static::creating(function ($client) {
    //         $client->client_id = self::generateClientId();
    //     });
    // }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
