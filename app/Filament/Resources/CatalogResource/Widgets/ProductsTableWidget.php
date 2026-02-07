<?php

namespace App\Filament\Resources\CatalogResource\Widgets;

use App\Models\Catalog;
use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Builder;

class ProductsTableWidget extends BaseWidget
{
    public ?Catalog $record = null;

    protected int | string | array $columnSpan = 'full';
    protected function getTableQuery(): Builder
    {
        return Product::query();
    }

    protected function isProductInCatalog(Product $product): bool
    {
        return $this->record
            ->products()
            ->where('products.id', $product->id)
            ->exists();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
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
                    
                ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (Product $record) => 
                        $this->isProductInCatalog($record) ? 'Incluido' : 'No incluido'
                    )
                    ->color(fn (Product $record) => 
                        $this->isProductInCatalog($record) ? 'success' : 'gray'
                    ),
            ])
            ->filters([
                Tables\Filters\Filter::make('incluidos')
                    ->label('Solo incluidos')
                    ->query(fn (Builder $query) => 
                        $query->whereHas('catalogs', fn ($q) => 
                            $q->where('catalogs.id', $this->record->id)
                        )
                    ),
                    
                Tables\Filters\Filter::make('no_incluidos')
                    ->label('Solo no incluidos')
                    ->query(fn (Builder $query) => 
                        $query->whereDoesntHave('catalogs', fn ($q) => 
                            $q->where('catalogs.id', $this->record->id)
                        )
                    ),

                
                SelectFilter::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Action::make('toggle')
                    ->label(fn (Product $record) => 
                        $this->isProductInCatalog($record) ? 'Quitar' : 'Agregar'
                    )
                    ->icon(fn (Product $record) => 
                        $this->isProductInCatalog($record) 
                            ? 'heroicon-o-minus-circle' 
                            : 'heroicon-o-plus-circle'
                    )
                    ->color(fn (Product $record) => 
                        $this->isProductInCatalog($record) ? 'danger' : 'success'
                    )
                    ->action(function (Product $product) {
                        $isInCatalog = $this->isProductInCatalog($product);

                        if ($isInCatalog) {
                            $this->record->products()->detach($product->id);
                            $message = 'Producto quitado';
                        } else {
                            $this->record->products()->attach($product->id);
                            $message = 'Producto agregado';
                        }

                        \Filament\Notifications\Notification::make()
                            ->title($message)
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading(fn (Product $record) => 
                        $this->isProductInCatalog($record) 
                            ? '¿Quitar del catálogo?' 
                            : '¿Agregar al catálogo?'
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('agregar')
                    ->label('Agregar al catálogo')
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->action(function ($records) {
                        $this->record->products()->syncWithoutDetaching($records->pluck('id'));
                        \Filament\Notifications\Notification::make()
                            ->title('Productos agregados')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                    
                Tables\Actions\BulkAction::make('quitar')
                    ->label('Quitar del catálogo')
                    ->icon('heroicon-o-minus')
                    ->color('danger')
                    ->action(function ($records) {
                        $this->record->products()->detach($records->pluck('id'));
                        \Filament\Notifications\Notification::make()
                            ->title('Productos quitados')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}