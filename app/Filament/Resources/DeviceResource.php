<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Section::make('Nueva Dispositivo')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre | Ruta')
                                    ->required(),
                                TextInput::make('description')
                                    ->label('Descripcion'),
                                TextInput::make('serial')
                                    ->required()
                            ])->columns(2)->columnSpan(3),
                        Section::make('Activo / Inactivo')
                            ->schema([    
                                Toggle::make('status')
                                    ->onIcon('heroicon-s-check')
                                    ->default(1)
                                    ->label('Estado')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->columns(3)->columnSpan(3)
                                    ->columns(4)->columnSpan(4)
                            ])->columns(4)->columnSpan(1)
                    ])->columns(4)->columnSpan(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre | Ruta'),
                TextColumn::make('description')
                    ->label('Descripcion'),
                TextColumn::make('serial')
                    ->label('Serie'),
                ToggleColumn::make('status')
                    ->label('Estado')
                    ->onColor('success')
                    ->offColor('danger'),
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
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
{
    return true;
}

public static function shouldRegisterNavigation(): bool
{
    return true;
}

 public static function getModelLabel(): string
    {
        return 'Dispositivos';
    }

}
