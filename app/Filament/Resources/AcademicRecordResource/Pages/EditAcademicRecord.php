<?php

namespace App\Filament\Resources\AcademicRecordResource\Pages;

use App\Filament\Resources\AcademicRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicRecord extends EditRecord
{
    protected static string $resource = AcademicRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
