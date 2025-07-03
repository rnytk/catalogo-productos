<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms\Components\Wizard;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
    Wizard\Step::make('Empresa')
        ->schema([
            TextInput::make('name')
                                    ->required()
                                    ->maxLength(100)
                                    ->label('Nombre')

        ]),
    Wizard\Step::make('Cateagoria')
        ->schema([
            Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->label('Categoría')
        ]),
    Wizard\Step::make('Billing')
        ->schema([
            // ...
        ]),
])
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->columns([
                TextColumn::make('sort')
                    ->label('Orden')
                    ->badge()
                    ->color(fn($state) => $state == '1' ? 'success' : 'warning'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre'),
                /*BadgeColumn::make('price')
                    ->money('GTQ')
                    ->label('Precio'),*/
                TextColumn::make('category.name')
                    ->label('Categoria'),
                TextColumn::make('brand.name')
                    ->label('Marca'),
                ImageColumn::make('imagen')
                ->url(fn (?Model $record) => Storage::url($record->imagen))
                    ->label('Imagen')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('price')
                    ->prefix('Q')
                    ->label('Precio'),
                ToggleColumn::make('status')
                    ->label('Estado')
                    ->onColor('success')
                    ->offColor('danger'),
                /*TextColumn::make('portada')
                    ->label('Portada'),*/
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
            ])
            ->defaultSort('sort', 'asc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
