<?php

namespace App\Services;

use App\Models\CarsUnderMaintenance;
use Illuminate\Support\Facades\Log;

class CarsUnderMaintenanceService
{







    public function create(array $data): CarsUnderMaintenance
    {
        return CarsUnderMaintenance::create($data);
    }









    public function findById(int $id): ?CarsUnderMaintenance
    {
        return CarsUnderMaintenance::find($id);
    }










    public function update(int $id, array $data): bool
    {
        $record = $this->findById($id);

        if ($record) {
            return $record->update($data);
        }

        return false;
    }









    public function delete(int $id): bool
    {
        $record = $this->findById($id);

        if ($record) {
            return $record->delete();
        }

        return false;
    }

 








    
    public function getAll()
    {
        return CarsUnderMaintenance::count();
    }
}
