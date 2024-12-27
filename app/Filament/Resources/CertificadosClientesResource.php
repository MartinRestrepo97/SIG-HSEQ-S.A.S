<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificadosClientesResource\Pages;
use App\Filament\Resources\CertificadosClientesResource\RelationManagers;
use App\Models\CertificadosClientes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificadosClientesResource extends Resource
{
    protected static ?string $model = CertificadosClientes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cliente_id')
                    ->label('Cliente')
                    ->relationship('clientes', 'nombre')
                    ->required(),
                Forms\Components\Select::make('certificado_id')
                    ->label('Certificado')
                    ->relationship('certificados', 'nombre')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_certificacion')
                    ->label('Fecha de Certificación')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('certificado.nombre')
                    ->label('Certificado')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_certificacion')
                    ->label('Fecha de Certificación')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificadosClientes::route('/'),
            'create' => Pages\CreateCertificadosClientes::route('/create'),
            'edit' => Pages\EditCertificadosClientes::route('/{record}/edit'),
        ];
    }
}
