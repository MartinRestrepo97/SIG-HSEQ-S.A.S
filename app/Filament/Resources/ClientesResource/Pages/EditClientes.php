<?php

namespace App\Filament\Resources\ClientesResource\Pages;

use App\Filament\Resources\ClientesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;


class EditClientes extends EditRecord
{
    protected static string $resource = ClientesResource::class;

    // Sobrescribir el método para redirigir al listado después de editar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirige al listado
    }

    public function table(Table $table): Table
    {
        return $table
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('nombre')
                            //->required()
                            ->maxLength(255),
                        TextInput::make('cedula')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('correo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('telefono')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('codigo')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
