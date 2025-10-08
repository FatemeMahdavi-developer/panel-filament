<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

    const UPDATED_AT=null;

    protected $fillable=[
        'name',
        'email',
        'phone'
    ];

    public function  patient() : HasMany {
        return $this->hasMany(Patient::class,'owner_id');
    }

    public static function getForm() :array
    {
        return [
            TextInput::make('name')
                ->label(__('owners.fields.name'))
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label(__('owners.fields.email'))
                ->required()
                ->email()
                ->maxLength(255)
                ->placeholder('test@gmail.com')
                ->unique(ignoreRecord:true),
            TextInput::make('phone')
                ->label(__('owners.fields.phone'))
                ->required()
                ->tel()
                ->rule('regex:/^09\d{9}$/')
                ->placeholder('0912XXXXXXX')
        ];
    }
}
