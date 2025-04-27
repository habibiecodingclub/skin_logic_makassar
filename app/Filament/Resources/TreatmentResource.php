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
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("Treatment_Name")
                ->required()
                ->label("Treatment Name"),
                Select::make("Treatment_Category")
                ->options(Treatment::getTreatmentCategoryOptions())
                ->required()
                ->label("Treatment Category"),
                TextInput::make("Treatment_Price")
                ->numeric()
                ->required()
                ->label("Treatment Price"),
                TextInput::make("SKU-Number")
                ->required()
                ->label("SKU Number"),
                Textarea::make("Description")
                ->required()
                ->label("Description")




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("Treatment_Name")->label("Treatment Name")->searchable(),
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
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->withFilename(fn () => "TreatmentsList-" . date("d-m-Y"))
                ])->label("Download")
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
