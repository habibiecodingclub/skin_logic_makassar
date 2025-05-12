<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    // Left Column - Form Inputs
                    Card::make([
                        Select::make('customer_id')
                            ->relationship('customer', 'customer_name')
                            ->label('Customer Name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),

                        Select::make('product_id')
                            ->relationship('product', 'Product_Name')
                            ->label('Product Name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $product = Product::find($state);
                                $set('product_price', $product->Product_Price ?? 0);
                            }),

                        Grid::make(2)->schema([
                            TextInput::make('Qty')
                                ->label('Quantity')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required()
                                ->live(),

                            TextInput::make('product_price')
                                ->label('Unit Price')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(),
                        ]),

                        TextInput::make('Order_Name')
                            ->required()
                            ->live(),
                    ])->columnSpan(1),

                    // Right Column - Preview
                    Card::make([
                        Placeholder::make('preview')
                            ->label('Order Details Preview')
                            ->content(function ($get) {
                                $customer = $get('customer_id') ? Customer::find($get('customer_id'))->Customer_Name : 'Not selected';
                                $product = $get('product_id') ? Product::find($get('product_id'))->Product_Name : 'Not selected';
                                $quantity = (int)($get('Qty') ?? 1);
                                $unitPrice = $get('product_id') ? Product::find($get('product_id'))->Product_Price : 0;
                                $totalPrice = $unitPrice * $quantity;

                                // Format to currency
                                $formattedUnitPrice = 'Rp ' . number_format($unitPrice, 0, ',', '.');
                                $formattedTotalPrice = 'Rp ' . number_format($totalPrice, 0, ',', '.');

                                return "
                            Customer: {$customer}\n
                            Product: {$product}\n
                            Harga: {$unitPrice} \n
                            Quantity: {$quantity}\n
                            brr: {$totalPrice}\n
                            Order Name: {$get('Order_Name')}
                            ";
                            })
                            ->extraAttributes(['style' => 'white-space: pre-line;']),
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('product.Product_Name')
                    ->label('Product')
                    ->searchable(),

                TextColumn::make('Qty')
                    ->label('Quantity')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('product.Product_Price')
                    ->label('Unit Price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('IDR')
                    ->sortable()
                    ->state(function ($record) {
                        return $record->product->Product_Price * $record->Qty;
                    }),

                TextColumn::make('Order_Name')
                    ->label('Order Name')
                    ->searchable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                ExportAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn() => 'orders-' . now()->format('Y-m-d'))
                    ])
                    ->label('Export Excel')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
