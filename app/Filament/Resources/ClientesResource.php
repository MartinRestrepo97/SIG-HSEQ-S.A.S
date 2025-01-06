<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientesResource\Pages;
use App\Filament\Resources\ClientesResource\RelationManagers;
use App\Models\Clientes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientesResource extends Resource
{
    protected static ?string $model = Clientes::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cedula')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('correo')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('codigo')
                    ->required()
                    ->maxLength(255),   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->sortable()   
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cedula')
                    ->searchable(),
                Tables\Columns\TextColumn::make('correo')
                    ->sortable()   
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('codigo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public function getClienteByCedula($cedula)
    {
        // Buscamos al cliente por la cédula,
        // y a la vez cargamos la relación con los certificados
        $cliente = Clientes::where('cedula', $cedula)
            ->with(['certificadosCliente.certificado'])
            ->first();

        // Si no se encuentra el cliente, retornamos algún tipo de respuesta
        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        // Retornamos la información del cliente y sus certificados
        return response()->json([
            'cliente'     => $cliente,
            'certificados' => $cliente->certificadosCliente->map(function($pivot) {
                return [
                    'certificado_id'        => $pivot->certificado_id,
                    'curso'                 => $pivot->certificado->curso,
                    'fecha_inicio'          => $pivot->certificado->fecha_inicio,
                    'fecha_fin'             => $pivot->certificado->fecha_fin,
                    'norma_cumplida'        => $pivot->certificado->norma_cumplida,
                    'estado'                => $pivot->certificado->estado,
                    'documento_pdf'         => $pivot->certificado->documento_pdf,
                    'fecha_inicio_validez'  => $pivot->fecha_inicio_validez,
                    'fecha_fin_validez'     => $pivot->fecha_fin_validez,
                ];
            })
        ], 200);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CertificadosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateClientes::route('/create'),
            'edit' => Pages\EditClientes::route('/{record}/edit'),
        ];
    }
}
