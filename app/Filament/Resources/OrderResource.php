<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        Select::make('customer_id')
                            ->relationship('customer', 'Customer_Name')
                            ->required()
                            ->label('Customer'),
                        Repeater::make('Product Name and Price')
                            ->label('Product Name and Price')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make("Product_name")
                                            ->label('Product Name')
                                            ->required(),
                                        TextInput::make("qty")
                                            ->label('qty')
                                            ->required()
                                    ])
                            ])
                            ->defaultItems(1)
                            ->maxItems(6)
                            ->addActionLabel('Add Product')
                            ->addable(true)
                            ->collapsible(),
                        Repeater::make('Treatment Name and Price')
                            ->label('Treatment Name and Price')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make("Treatment_Name")
                                            ->label('Treatment Name')
                                            ->required(),
                                        TextInput::make("qty")
                                            ->label('qty')
                                            ->required()
                                    ])
                            ])
                            ->defaultItems(1)
                            ->maxItems(6)
                            ->addActionLabel('Add Treatment')
                            ->addable(true)
                            ->collapsible(),
                    ]),
                    Section::make('Order Details')
                        ->schema([
                            TextInput::make('Order_id')
                                ->label('Order ID')
                                ->disabled()
                        ])
                        ->hidden(fn($record) => $record === null)
                ])



                // Textarea::make('order_list')
                //     ->required()
                //     ->maxLength(100),
                // TextInput::make('quantity')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('total_price')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\DatePicker::make('order_date')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id'),
                TextColumn::make('customer.Customer_Name')->label('Customer Name'),
                TextColumn::make('order_list'),
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
