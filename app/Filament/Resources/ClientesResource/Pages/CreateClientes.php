<?php

namespace App\Filament\Resources\ClientesResource\Pages;

use App\Filament\Resources\ClientesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;

class CreateClientes extends CreateRecord
{
    protected static string $resource = ClientesResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->form([
                        TextInput::make('nombre')
                            //->required()
                            ->maxLength(255),
                        TextInput::make('cedula')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('telefono')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('codigo')
                            ->required()
                            ->maxLength(255),    
                        // ...
                    ]),
            ]);
    }
}
