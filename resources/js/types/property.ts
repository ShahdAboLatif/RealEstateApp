// resources/js/types/property.ts

export interface City {
    id: number;
    city: string;
    created_at?: string;
    updated_at?: string;
}

export interface Property {
    id: number;
    city_id: number;
    name: string;
    archived: boolean;
    created_at: string;
    updated_at: string;
    city?: City; // Relationship data when loaded

    // Calculated properties from your model
    total_units?: number;
    vacant_units?: number;
    occupied_units?: number;
    listed_units?: number;
}

export interface PropertyFormData {
    city_id: number | string;
    name: string;
    archived?: boolean;
}

export interface PropertyFilters {
    property_name?: string;
}

export interface PropertyStatistics {
    total: number;
    total_with_archived: number;
    archived: number;
}

export interface PaginatedProperties {
    data: Property[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
}

export interface PropertyCreateProps {
    cities: City[];
}

export interface PropertyEditProps {
    property: Property;
    cities: City[];
}

export interface PropertyIndexProps {
    properties: PaginatedProperties;
    statistics: PropertyStatistics;
    filters: PropertyFilters;
}
