<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Product_Name')
                    ->required()
                    ->label('Product Name'),
                Forms\Components\Select::make('Product_Category')
                    ->options(Product::getProductCategoryOptions()) // Ambil opsi enum dari model
                    ->required()
                    ->label('Product Category'),
                Forms\Components\TextInput::make('Product_Price')
                    ->numeric()
                    ->required()
                    ->label('Product Price'),
                Forms\Components\TextInput::make('SKU-Number')
                    ->required()
                    ->label('SKU Number'),
                Forms\Components\Textarea::make('Description')
                    ->required()
                    ->label('Description'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Product_Name')->label('Product Name'),
                Tables\Columns\TextColumn::make('Product_Category')->label('Product Category'),
                Tables\Columns\TextColumn::make('Product_Price')->label('Product Price'),
                Tables\Columns\TextColumn::make('SKU-Number')->label('SKU Number'),
                TextColumn::make('Description')->label('Description'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
