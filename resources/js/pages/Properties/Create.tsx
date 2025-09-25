// resources/js/Pages/Properties/Create.tsx

import React from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/app-layout';
import { PropertyFormData, PropertyCreateProps } from '@/types/property';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

export default function Create({ cities }: PropertyCreateProps) {
    const { data, setData, post, processing, errors } = useForm<PropertyFormData>({
        city_id: '',
        city: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('properties-info.store'));
    };

    return (
        <AppLayout>
            <Head title="Create Property" />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <Card>
                        <CardHeader>
                            <div className="flex justify-between items-center">
                                <CardTitle className="text-2xl">Create New Property</CardTitle>
                                <Link href={route('properties-info.index')}>
                                    <Button variant="outline">Back to List</Button>
                                </Link>
                            </div>
                        </CardHeader>

                        <CardContent>
                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div className="grid md:grid-cols-2 gap-4">
                                    {/* City Selection */}
                                    <div>
                                        <Label htmlFor="city_id">City *</Label>
                                        <Select
                                            value={data.city_id.toString()}
                                            onValueChange={(value) => setData('city_id', parseInt(value))}
                                        >
                                            <SelectTrigger>
                                                <SelectValue placeholder="Select a city" />
                                            </SelectTrigger>
                                            <SelectContent>
    {cities.map((city) => (
        <SelectItem key={city.id} value={city.id.toString()}>
            {city.city}  {/* Changed from city.name to city.city */}
        </SelectItem>
    ))}
</SelectContent>
                                        </Select>
                                        {errors.city_id && (
                                            <p className="text-red-600 text-sm mt-1">{errors.city_id}</p>
                                        )}
                                    </div>

                                    {/* Property Name */}
                                    <div>
                                        <Label htmlFor="name">Property Name *</Label>
                                        <Input
                                            id="name"
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            placeholder="Enter property name"
                                            error={errors.name}
                                        />
                                        {errors.name && (
                                            <p className="text-red-600 text-sm mt-1">{errors.name}</p>
                                        )}
                                    </div>
                                </div>

                                <div className="flex justify-end gap-2">
                                    <Link href={route('properties-info.index')}>
                                        <Button type="button" variant="outline">
                                            Cancel
                                        </Button>
                                    </Link>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? 'Creating...' : 'Create Property'}
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
