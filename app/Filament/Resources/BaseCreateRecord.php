<?php

namespace App\Filament\Resources;

use Filament\Resources\Pages\CreateRecord;

class BaseCreateRecord extends CreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
