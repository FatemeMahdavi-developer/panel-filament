<?php

namespace App\Filament\Resources;

use App\Enums\AnimalTypeEnum;
use App\Enums\PatientStatusEnum;
use App\Enums\PatientTypeEnum;
use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Owner;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TextFilter;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getPluralModelLabel(): string
    {
        return __('modules.list.patients');
    }

    public static function getModelLabel(): string
    {
        return __('modules.name.patient');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    TextInput::make('name')
                        ->label(__('patients.fields.name'))
                        ->required()
                        ->maxLength(255),
                    Select::make('type')
                        ->required()
                        ->label(__('patients.fields.type'))
                        ->enum(PatientTypeEnum::class)
                        ->options(
                            collect(PatientTypeEnum::cases())
                                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                                ->toArray()
                        ),
                    Select::make('status')
                        ->required()
                        ->label(__('patients.fields.status'))
                        ->enum(PatientStatusEnum::class)
                        ->options(
                            collect(PatientStatusEnum::cases())
                                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                                ->toArray()
                        ),
                ]),
                Group::make([
                      RichEditor::make('note')
                    ->label(__('patients.fields.note'))
                    ->columnSpan('full')
                ]),
                SpatieMediaLibraryFileUpload::make('image')
                    ->label(__('patients.fields.image'))
                    ->collection('image')
                    ->getUploadedFileNameForStorageUsing(function (\Illuminate\Http\UploadedFile $file) {
                        return 'patient/' . $file->getClientOriginalName();
                    })
                    ->image()
                    ->visibility('public')
                    ->columnSpan('full')
                    ->imageEditor(),
                DatePicker::make('date_of_birth')
                    ->required()
                    ->label(__('patients.fields.date_of_birth'))
                    ->jalali()
                    ->maxDate(now()),
                Select::make('owner_id')
                    ->required()
                    ->label(__('patients.fields.owner_id'))
                    ->searchable()
                    ->relationship('owner','name')
                    ->createOptionForm(Owner::getForm()),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('patients.fields.name'))
                    ->searchable(),
                ImageColumn::make('image')
                    ->label(__('patients.fields.image'))
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('image', 'thumb'))
                    ->circular()
                    // ->defaultImageUrl('')
                    ->size(50),
                SelectColumn::make('type')
                    ->label(__('patients.fields.type'))
                    ->options(
                        collect(PatientTypeEnum::cases())
                            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->searchable(),
                TextColumn::make('owner.name')
                    ->label(__('patients.fields.owner_id'))
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label(__('patients.fields.status'))
                    ->formatStateUsing(fn ($state) => PatientStatusEnum::tryFrom($state)?->label())
                    ->color(fn ($state) => PatientStatusEnum::tryFrom($state)?->color()),

                TextColumn::make('created_at')
                    ->label(__('patients.fields.created_at'))
                    ->sortable()
                    ->jalaliDate()

            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(
                        collect(PatientTypeEnum::cases())
                            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeSave(array $data, $record)
    {
        if (isset($data['image']) && $data['image'] !== null) {
            $record->clearMediaCollection('image'); //name collection
        }
        return $data;
    }
}
