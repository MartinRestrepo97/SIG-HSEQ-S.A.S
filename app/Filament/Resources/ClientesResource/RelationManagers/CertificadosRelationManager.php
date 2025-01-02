<?php

namespace App\Filament\Resources\ClientesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CertificadosRelationManager extends RelationManager
{
    protected static string $relationship = 'certificados';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('curso')
                    ->required()
                    ->unique(),
                Forms\Components\DatePicker::make('fecha_emision')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_expiracion')
                    ->required(),
                Forms\Components\TextInput::make('norma_cumplida')
                    ->required(),
                Forms\Components\Select::make('estado')
                    ->options([
                        'Active' => 'Activo',
                        'Expired' => 'Vencido',
                    ])
                    ->default('Active')
                    ->required(),
                Forms\Components\FileUpload::make('documento_pdf')
                    ->label('Documento PDF')
                    ->directory('certificados_pdf') // Directorio donde se guardarán los PDFs
                    ->preserveFilenames() // Preservar el nombre original del archivo
                    ->acceptedFileTypes(['application/pdf']), // Aceptar solo archivos PDF
                Forms\Components\DatePicker::make('pivot.fecha_certificacion')
                    ->label('Fecha de Certificación'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('fecha_emision')->date(),
                Tables\Columns\TextColumn::make('fecha_expiracion')->date(),
                Tables\Columns\TextColumn::make('norma_cumplida'),
                Tables\Columns\TextColumn::make('estado'),
                Tables\Columns\TextColumn::make('documento_pdf')
                    ->label('PDF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pivot.fecha_certificacion')
                    ->label('Fecha de Certificación')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\DatePicker::make('fecha_certificacion')
                            ->label('Fecha de Certificación'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}