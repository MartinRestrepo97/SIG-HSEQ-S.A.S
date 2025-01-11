<?php

namespace App\Filament\Resources\ClientesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use App\Models\Certificados;


class CertificadosRelationManager extends RelationManager
{
    protected static string $relationship = 'certificados';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curso')
                    ->options(Certificados::all()->pluck('curso','id'))
                    ->required(),
                Forms\Components\DatePicker::make('fecha_inicio_validez')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_fin_validez')
                    ->required(),
                Forms\Components\FileUpload::make('documento_pdf_validez')
                    ->label('Documento PDF validez')
                    ->directory('certificados_pdf_validez')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/pdf']),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio_validez')
                    ->date(),
                Tables\Columns\TextColumn::make('fecha_fin_validez')
                    ->date(),
                Tables\Columns\TextColumn::make('documento_pdf_validez')
                    ->label('PDF')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
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
}