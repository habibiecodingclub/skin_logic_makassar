<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make([
                'default' => 3, // 1 kolom di layar kecil
                'md' => 3,      // 2 kolom di layar medium (tablet)
                'lg' => 3,      // 3 kolom di layar besar (desktop)
            ])
        
            ->schema([
                Select::make('customer_id')
                    ->relationship('customer', 'Customer_Name')
                    ->required()
                    ->columnSpan(2) // Mengambil 2 kolom dari 3
                    ->label('Customer'),
                Placeholder::make('') // Kosongkan 1 kolom
                    ->columnSpan(1),
                TextInput::make('product_name')
                    ->required()
                    ->columnSpan(2) // Mengambil 2 kolom dari 3
                    ->maxLength(100),
                Placeholder::make('') // Kosongkan 1 kolom
                    ->columnSpan(1),
                TextInput::make('quantity')
                    ->required()
                    ->columnSpan(1) // Mengambil 2 kolom dari 3
                    ->numeric(),
                Placeholder::make('') // Kosongkan 1 kolom
                    ->columnSpan(1),
                TextInput::make('total_price')
                    ->required()
                    ->columnSpan(2) // Mengambil 2 kolom dari 3
                    ->numeric(),
                Placeholder::make('') // Kosongkan 1 kolom
                    ->columnSpan(1),
                Forms\Components\DatePicker::make('order_date')
                    ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id'),
                TextColumn::make('customer.Customer_Name')->label('Customer Name'),
                TextColumn::make('product_name'),
                TextColumn::make('quantity'),
                TextColumn::make('total_price'),
                TextColumn::make('order_date')->date(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
