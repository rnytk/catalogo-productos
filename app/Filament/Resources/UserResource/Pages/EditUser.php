<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
//use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BaseEditRecord as EditRecord;

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
                    
                    if($user->tokens()->exists()) {
                        Notification::make()
                            ->title('Ya existe un token para este usuario')
                            ->danger()
                            ->send();
                    return false;

                    }

                    $token = $user->createToken('token-generado-filament')->plainTextToken;

         
                   $this->form->fill(array_merge(
                        $this->form->getState(),
                        ['generated_token' => $token]
                    ));

                    Notification::make()
                        ->title('Token generado correctamente')
                        ->success()
                        ->send();

                        return false;
                })
        ];
    }
}
