<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Generar Token')
                ->color('primary')
                ->icon('heroicon-o-key')
                ->requiresConfirmation()
                ->modalHeading('Generar nuevo token')
                ->modalSubmitActionLabel('Generar')
                ->action(function () {
                    $user = $this->record;

                    // Elimina tokens anteriores si deseas
                    $user->tokens()->delete();

                    // Genera el nuevo token
                    $token = $user->createToken('token-generado-filament')->plainTextToken;

         
                   $this->form->fill(array_merge(
    $this->form->getState(),
    ['generated_token' => $token]
));
                    Notification::make()
                        ->title('Token generado correctamente')
                        ->success()
                        ->send();
                })
        ];
    }
}
