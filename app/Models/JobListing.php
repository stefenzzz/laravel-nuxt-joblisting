<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobListing extends Model
{
    use HasFactory;


    protected $fillable = ['title','status','description','company_name','email','created_by','number_views','number_applies','number_impression'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
