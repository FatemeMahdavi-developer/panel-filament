<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 0;

    public static function getPluralModelLabel(): string
    {
        return __('modules.list.users');
    }

    public static function getModelLabel(): string
    {
        return __('modules.name.user');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('users.fields.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('users.fields.email'))
                    ->required()
                    ->maxLength(255),
                Select::make('roles')
                ->label('نقش‌ها')
                ->multiple()
                ->relationship('roles', 'name')
                ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('users.fields.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('users.fields.name'))
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('change_password')
                    ->label('تغییر پسورد')
                    ->modalHeading(fn (User $record) => 'تغییر رمز عبور کاربر ' . $record->name)
                    ->modalSubmitActionLabel('ذخیره رمز جدید')
                    ->modalWidth('sm')
                    ->form([
                        TextInput::make('password')
                        ->label(__('users.fields.password'))
                        ->password()
                        ->required()
                        ->minLength(6)
                        ->maxLength(12),
                    ])
                    ->action(function(array $data,User $record){
                        $record->update(['password' => $data['password']]);

                        Notification::make()
                        ->title('رمز عبور با موفقیت تغییر کرد')
                        ->success()
                        ->send();
                    })

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
