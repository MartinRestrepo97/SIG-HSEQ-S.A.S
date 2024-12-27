<?php

namespace App\Filament\Resources\CertificadosResource\Pages;

use App\Filament\Resources\CertificadosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificados extends EditRecord
{
    protected static string $resource = CertificadosResource::class;

    // Sobrescribir el método para redirigir al listado después de editar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirige al listado
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
