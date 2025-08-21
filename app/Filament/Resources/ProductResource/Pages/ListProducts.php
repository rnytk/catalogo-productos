<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('GenerarPDF')
                ->label('Generar PDF')
                ->color('danger')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    
                $filters = $this->getTableFilterState('business');

                // 📌 Validar si "business" está vacío
                if (empty($filters['value'] ?? null)) {
                    Notification::make()
                        ->title('Debe seleccionar una empresa')
                        ->danger()
                        ->send();

                    return; // No generar PDF
                }
                    // Respetar filtros actuales de la tabla
                    $products = $this->getFilteredTableQuery()
                    ->select('sort','imagen')
                    ->where('status', '1')
                    ->orderBy('sort', 'asc')
                    ->get();

                    //dd($products);
                    // Generar el PDF con una vista Blade
                    $pdf = Pdf::loadView('pdf.products-images', compact('products'))
                     ->setPaper('a4', 'landscape'); 
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'catalogo_drc.pdf'
                    );
                }),
        ];
    }
}
