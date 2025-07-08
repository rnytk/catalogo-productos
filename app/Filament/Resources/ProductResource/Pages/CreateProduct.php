<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
//use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord as CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    
}
