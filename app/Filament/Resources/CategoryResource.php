<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->schema([
                    Section::make('Nueva Categoria')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre'),
                        TextInput::make('description')
                            ->label('Descripcion')
                        ])->columns(2)->columnSpan(3),
                    Section::make('Activo / Inactivo')
                        ->schema([
                            Toggle::make('status')
                                ->onIcon('heroicon-s-check')
                                   ->default(1)
                                   ->label('Estado')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->columns(2)->columnSpan(2)
                            ->columns(4)->columnSpan(4)
                        ])->columns(4)->columnSpan(1)
                ])->columns(4)->columnSpan(3),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()
                ->label('Nombre'),
                TextColumn::make('description')->limit(50)
                ->label('Descripcion'),
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    '1' => 'success',
                    '0' => 'warning',
                })
                ->formatStateUsing(function($state){
                    return $state ? "Activo" : "Inactivo";
                })
                ->label('Estado'),
                TextColumn::make('created_at')
                ->label('Creado')
                ->dateTime('d/m/Y')
            ])
            ->filters([
                //
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Categoria';
    }
}
