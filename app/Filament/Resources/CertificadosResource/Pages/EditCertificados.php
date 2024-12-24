<?php

namespace App\Filament\Resources\CertificadosResource\Pages;

use App\Filament\Resources\CertificadosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificados extends EditRecord
{
    protected static string $resource = CertificadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
