<?php

namespace App\Filament\Resources\CertificadosResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientesRelationManager extends RelationManager
{
    protected static string $relationship = 'clientes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')->required(),
                Forms\Components\TextInput::make('apellido')->required(),
                Forms\Components\TextInput::make('cedula')->required(),
                Forms\Components\TextInput::make('correo')->email()->required(),
                Forms\Components\TextInput::make('telefono')->required(),
                Forms\Components\TextInput::make('codigo')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('apellido')->searchable(),
                Tables\Columns\TextColumn::make('cedula')->searchable(),
                Tables\Columns\TextColumn::make('correo')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('telefono')->searchable(),
                Tables\Columns\TextColumn::make('codigo')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}