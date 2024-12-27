<?php

namespace App\Filament\Resources\ClientesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Builder;

class CertificadosRelationManager extends RelationManager
{
    protected static string $relationship = 'certificados';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo')
                    ->required(),
                Forms\Components\Textarea::make('documento_pdf'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo'),
                Tables\Columns\TextColumn::make('documento_pdf'),
            ])
            ->filters([
                //
            ]);
    }
}