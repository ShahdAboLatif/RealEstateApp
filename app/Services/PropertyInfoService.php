<?php

namespace App\Services;

use App\Models\PropertyInfo;
use App\Models\Cities;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PropertyInfoService
{
    public function getAllPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = PropertyInfo::with('city');

        // Apply filters
        if (!empty($filters['property_name'])) {
            $query->where('name', 'like', '%' . $filters['property_name'] . '%');
        }

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    public function create(array $data): PropertyInfo
    {
        $data['archived'] = false; // Ensure new properties are not archived
        return PropertyInfo::create($data);
    }

    public function findById(int $id): PropertyInfo
    {
        return PropertyInfo::withArchived()->with('city')->findOrFail($id);
    }

    public function update(PropertyInfo $propertyInfo, array $data): PropertyInfo
    {
        $propertyInfo->update($data);
        return $propertyInfo->fresh();
    }

    public function getStatistics(): array
    {
        $total = PropertyInfo::count(); // Only active (non-archived)
        $totalWithArchived = PropertyInfo::withArchived()->count();
        $archived = PropertyInfo::onlyArchived()->count();

        return [
            'total' => $total,
            'total_with_archived' => $totalWithArchived,
            'archived' => $archived,
        ];
    }

    public function getCities(): Collection
    {
        return Cities::orderBy('city')->get();
    }

    public function getArchived(): Collection
    {
        return PropertyInfo::onlyArchived()->with('city')->orderBy('name')->get();
    }

    public function getAllWithArchived(): Collection
    {
        return PropertyInfo::withArchived()->with('city')->orderBy('name')->get();
    }

}
