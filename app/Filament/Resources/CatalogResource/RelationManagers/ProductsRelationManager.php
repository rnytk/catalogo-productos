 <?php
/*
namespace App\Filament\Resources\CatalogResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Gestionar Productos del Catálogo';

    // 👇 MÉTODO QUE TE FALTABA
    protected function isProductInCatalog($record): bool
    {
        $catalog = $this->getOwnerRecord(); // Obtiene el catálogo actual
        return $catalog->products()->where('products.id', $record->id)->exists();
    }

    // Muestra TODOS los productos disponibles en el sistema
    protected function getTableQuery(): Builder
    {
        return Product::query();
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->searchable(),
                    
                TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable(),
                    
                ImageColumn::make('image')
                    ->label('Imagen')
                    ->circular(),

                // Columna para ver visualmente si está en el catálogo
                TextColumn::make('en_catalogo')
                    ->label('Estado')
                    ->badge()
                    ->state(function ($record) {
                        return $this->isProductInCatalog($record) 
                            ? 'Incluido' 
                            : 'No incluido';
                    })
                    ->color(fn ($state) => $state === 'Incluido' ? 'success' : 'gray'),
            ])
            ->filters([
                // Filtro para ver solo productos ya incluidos en el catálogo
                Tables\Filters\Filter::make('incluidos')
                    ->label('Solo productos incluidos')
                    ->query(function (Builder $query) {
                        $catalogId = $this->getOwnerRecord()->id;
                        return $query->whereHas('catalogs', function ($q) use ($catalogId) {
                            $q->where('catalogs.id', $catalogId);
                        });
                    }),
                    
                // Filtro para ver solo productos NO incluidos
                Tables\Filters\Filter::make('no_incluidos')
                    ->label('Solo productos no incluidos')
                    ->query(function (Builder $query) {
                        $catalogId = $this->getOwnerRecord()->id;
                        return $query->whereDoesntHave('catalogs', function ($q) use ($catalogId) {
                            $q->where('catalogs.id', $catalogId);
                        });
                    }),
            ])
            ->headerActions([
                // Opcional: acción para agregar múltiples de una vez
            ])
            ->actions([
                Action::make('toggleProduct')
                    ->label(function ($record) {
                        return $this->isProductInCatalog($record)
                            ? 'Quitar'
                            : 'Agregar';
                    })
                    ->icon(function ($record) {
                        return $this->isProductInCatalog($record)
                            ? 'heroicon-o-minus-circle'
                            : 'heroicon-o-plus-circle';
                    })
                    ->color(function ($record) {
                        return $this->isProductInCatalog($record)
                            ? 'danger'
                            : 'success';
                    })
                    ->action(function ($record) {
                        $catalog = $this->getOwnerRecord();

                        if ($this->isProductInCatalog($record)) {
                            // Quitar del catálogo
                            $catalog->products()->detach($record->id);
                        } else {
                            // Agregar al catálogo
                            $catalog->products()->attach($record->id);
                        }
                        
                        // Opcional: notificación
                        \Filament\Notifications\Notification::make()
                            ->title($this->isProductInCatalog($record) ? 'Producto agregado' : 'Producto quitado')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading(function ($record) {
                        return $this->isProductInCatalog($record)
                            ? '¿Quitar producto del catálogo?'
                            : '¿Agregar producto al catálogo?';
                    })
                    ->modalDescription(fn ($record) => 'Producto: ' . $record->name),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Acción masiva para agregar múltiples productos
                    Tables\Actions\BulkAction::make('agregar_multiples')
                        ->label('Agregar al catálogo')
                        ->icon('heroicon-o-plus')
                        ->color('success')
                        ->action(function ($records) {
                            $catalog = $this->getOwnerRecord();
                            $catalog->products()->syncWithoutDetaching($records->pluck('id'));
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Productos agregados al catálogo')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    
                    // Acción masiva para quitar múltiples productos
                    Tables\Actions\BulkAction::make('quitar_multiples')
                        ->label('Quitar del catálogo')
                        ->icon('heroicon-o-minus')
                        ->color('danger')
                        ->action(function ($records) {
                            $catalog = $this->getOwnerRecord();
                            $catalog->products()->detach($records->pluck('id'));
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Productos quitados del catálogo')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}

*/