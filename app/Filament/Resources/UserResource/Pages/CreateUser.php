<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Sobrescribir el método para redirigir al listado después de crear
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirige al listado
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'Usuario creado exitosamente'; // Mensaje personalizado
    }
}
