<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogResource\Pages;
use App\Filament\Resources\CatalogResource\RelationManagers;
use App\Models\Catalog;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        // COLUMNA IZQUIERDA (FORM PRINCIPAL)
                        Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nombre')
                                            ->required()
                                            ->maxLength(255),

                                        RichEditor::make('description')
                                            ->label('Descripcion')
                                            ->placeholder('Describe el catalogo')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        // COLUMNA DERECHA (SETTINGS)
                        Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Configuracion')
                                    ->schema([
                                        Toggle::make('status')
                                            ->label('Estado del Catálogo')
                                            ->helperText('Define si el catálogo será visible para los clientes.')
                                            ->onIcon('heroicon-m-check')
                                            ->offIcon('heroicon-m-x-mark')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->default(true)
                                            ->live(), // 👈 MUY IMPORTANTE
                                            

                                        Placeholder::make('status_label')
                                            ->label('Estado actual')
                                            ->content(
                                                fn($get) =>
                                                $get('status') ? 'Activo' : 'Inactivo'
                                            )
                                            ->extraAttributes(fn($get) => [
                                                'class' => $get('status')
                                                    ? 'text-green-600 font-semibold'
                                                    : 'text-red-600 font-semibold',
                                            ]),

                                    ]),

                                Section::make()
                                    ->schema([
                                        Placeholder::make('created_at')
                                            ->label('Created at')
                                            ->content(
                                                fn($record) =>
                                                $record?->created_at?->format('Y-m-d H:i') ?? '-'
                                            ),
                                        Placeholder::make('updated_at')
                                            ->label('Last updated')
                                            ->content(
                                                fn($record) =>
                                                $record?->updated_at?->format('Y-m-d H:i') ?? '-'
                                            ),
                                    ]),
                            ]),
                    ]),

                Section::make('Cover Image')
                    ->schema([
                        FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                            ->directory('catalogs')
                            ->imagePreviewHeight('150')
                            ->maxSize(1024)
                            ->acceptedFileTypes([
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml',
                            ])
                            ->helperText('SVG, PNG, JPG (MAX. 800x400px)')
                            ->columnSpanFull(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                     TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre'),
                    TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Descripcion'),
                   ImageColumn::make('cover_image')
                   ->label('Imagen')
                    ->disk('public')
                    ->circular(),
                
                    ToggleColumn::make('status')
                    ->label('Estado')
                    ->onColor('success')
                    ->offColor('danger'),
                /*TextColumn::make('portada')
                    ->label('Portada'),*/

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
            'index' => Pages\ListCatalogs::route('/'),
            'create' => Pages\CreateCatalog::route('/create'),
            'edit' => Pages\EditCatalog::route('/{record}/edit'),
        ];
    }
}
