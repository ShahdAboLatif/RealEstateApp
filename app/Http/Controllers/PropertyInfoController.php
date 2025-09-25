<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyInfoRequest;
use App\Http\Requests\UpdatePropertyInfoRequest;
use App\Services\PropertyInfoService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class PropertyInfoController extends Controller
{
    public function __construct(
        private PropertyInfoService $propertyInfoService
    ) {
        $this->middleware('permission:properties.index')->only('index');
        $this->middleware('permission:properties.create')->only('create');
        $this->middleware('permission:properties.store')->only('store');
        $this->middleware('permission:properties.show')->only('show');
        $this->middleware('permission:properties.edit')->only('edit');
        $this->middleware('permission:properties.update')->only('update');
    }

    public function index(Request $request): Response
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->only(['property_name']);

        $properties = $this->propertyInfoService->getAllPaginated($perPage, $filters);
        $statistics = $this->propertyInfoService->getStatistics();

        return Inertia::render('Properties/Index', [
            'properties' => $properties,
            'statistics' => $statistics,
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        $cities = $this->propertyInfoService->getCities();

        return Inertia::render('Properties/Create', [
            'cities' => $cities,
        ]);
    }

    public function store(StorePropertyInfoRequest $request): RedirectResponse
    {
        try {
            $this->propertyInfoService->create($request->validated());

            return redirect()->route('properties-info.index')
                ->with('success', 'Property created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create property: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(int $id): Response
    {
        $property = $this->propertyInfoService->findById($id);

        return Inertia::render('Properties/Show', [
            'property' => $property,
        ]);
    }

    public function edit(int $id): Response
    {
        $property = $this->propertyInfoService->findById($id);
        $cities = $this->propertyInfoService->getCities();

        return Inertia::render('Properties/Edit', [
            'property' => $property,
            'cities' => $cities,
        ]);
    }

    public function update(UpdatePropertyInfoRequest $request, int $id): RedirectResponse
    {
        try {
            $property = $this->propertyInfoService->findById($id);
            $this->propertyInfoService->update($property, $request->validated());

            $message = $request->input('archived') ? 'Property archived successfully' : 'Property updated successfully';

            return redirect()->route('properties-info.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update property: ' . $e->getMessage())
                ->withInput();
        }
    }

    // public function dashboard(): Response
    // {
    //     $statistics = $this->propertyInfoService->getStatistics();

    //     return Inertia::render('Properties/Dashboard', [
    //         'statistics' => $statistics,
    //     ]);
    // }
}
