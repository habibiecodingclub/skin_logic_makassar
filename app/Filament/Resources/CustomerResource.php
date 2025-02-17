<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Livewire\before;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("Customer_Name")
                ->required()
                ->minLength(3)
                ->maxLength(100)
                ->rules(['regex:/^[a-zA-Z\s]+$/']) # hanya menerima angka dan huruf
                ->validationMessages([
                    "minLength" => "Customer name must be at least 3 characters.",
                    "regex"=>"Customer name should contain alphabets characters and space."
                ]),
                TextInput::make("Phone Number")
                ->required()
                ->minLength(10)
                ->maxLength(15)
                ->rules('regex:/^[0-9]+$/')
                ->validationMessages([
                    "regex" => "Customer phone number should only contain numbers"
                ]),
                TextInput::make("Email")->required()->email(),
                DatePicker::make("Date of Birth")
                ->required()
                ->label("Date of Birth")
                ->displayFormat("d-m-Y")
                ->format('Y-m-d')
                ->rules(['before:today'])
                ->validationMessages(["before" => "tanggal tidak valid"]),
                TextInput::make("Occupation")
                ->required()
                ->minLength(5)
                ->maxLength(100)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('customer_id'),
                TextColumn::make('Customer_Name'),
                TextColumn::make('Phone Number'),
                TextColumn::make('Email'),
                TextColumn::make('Date of Birth'),
                TextColumn::make('Occupation'),
                TextColumn::make('created_at')->formatStateUsing(fn($state)=>$state->format('d-m-Y'))->label("bergabung sejak")
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
