<?php

namespace App\Filament\Resources\CertificadosResource\Pages;

use App\Filament\Resources\CertificadosResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificados extends CreateRecord
{
    protected static string $resource = CertificadosResource::class;

    // Sobrescribir el método para redirigir al listado después de crear
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirige al listado
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'Certificado creado exitosamente'; // Mensaje personalizado
    }
}
