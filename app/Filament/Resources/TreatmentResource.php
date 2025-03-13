<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentResource\Pages;
use App\Filament\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4) ->schema([
                TextInput::make("Treatment_Name")
                ->required()
                ->columnSpan(2) // Mengambil 2 kolom dari 4
                ->label("Treatment Name"),
                Placeholder::make('') // Kosongkan 1 kolom
                ->columnSpan(2),
                Select::make("Treatment_Category")
                ->options(Treatment::getTreatmentCategoryOptions())
                ->required()
                ->columnSpan(2) // Mengambil 2 kolom dari 4
                ->label("Treatment Category"),
                Placeholder::make('') // Kosongkan 1 kolom
                ->columnSpan(2),
                TextInput::make("Treatment_Price")
                ->numeric()
                ->required()
                ->columnSpan(2) // Mengambil 2 kolom dari 4
                ->label("Treatment Price"),
                Placeholder::make('') // Kosongkan 1 kolom
                ->columnSpan(2),
                TextInput::make("SKU-Number")
                ->required()
                ->columnSpan(2) // Mengambil 2 kolom dari 4
                ->label("SKU Number"),
                Placeholder::make('') // Kosongkan 1 kolom
                ->columnSpan(2),
                Textarea::make("Description")
                ->required()
                ->columnSpan(2) // Mengambil 2 kolom dari 4
                ->label("Description")



                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("Treatment_Name")->label("Treatment Name"),
                TextColumn::make("Treatment_Category")->label("Treatment Category"),
                TextColumn::make("Treatment_Price")->label("Treatment Price")->formatStateUsing(function ($state){
                    return "Rp. " . number_format($state, 2, ',', '.');
                }),
                TextColumn::make("SKU-Number")->label("SKU Number"),
                TextColumn::make("Description")->label("Description")

            ])
            ->filters([
                //
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
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
