<?php

namespace App\Models;

use App\Enums\PatientTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Patient extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    const UPDATED_AT=null;

    protected $fillable=[
        'name',
        'owner_id',
        'type',
        'date_of_birth',
        'status',
        'note'
    ];

    public function owner() : BelongsTo
    {
        return $this->belongsTo(owner::class,'owner_id');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
             ->useDisk('public')
             ->singleFile();
    }


    public function approve(){
        $this->status='pending';
        $this->save();
    }
}
