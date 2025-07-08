<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use Filament\Actions;
//use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord as CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;
}
