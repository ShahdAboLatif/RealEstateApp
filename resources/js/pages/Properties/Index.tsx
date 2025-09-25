// Properties/Index.tsx
import React, { useState } from 'react';
import { Head, useForm, router, usePage } from '@inertiajs/react';
import { Property, City, PropertyIndexProps } from '@/types/property';
import AppLayout from '@/Layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Trash2, Plus, X, Archive, ArchiveRestore } from 'lucide-react';
import { usePermissions } from '@/hooks/usePermissions';

interface Props extends PropertyIndexProps {
  cities?: City[]; // Made optional with default value
}

const Index = ({ properties, cities = [], statistics, filters }: Props) => {
  const [showForm, setShowForm] = useState(false);
  const { data, setData, post, processing, errors, reset } = useForm({
    city_id: '',
    name: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post('/properties', {
      onSuccess: () => {
        reset();
        setShowForm(false);
      }
    });
  };

  const handleDelete = (id: number) => {
    if (window.confirm('Are you sure you want to delete this property?')) {
      router.delete(`/properties/${id}`);
    }
  };

  const handleArchive = (id: number, currentStatus: boolean) => {
    const action = currentStatus ? 'unarchive' : 'archive';
    if (window.confirm(`Are you sure you want to ${action} this property?`)) {
      router.patch(`/properties/${id}/archive`, {
        archived: !currentStatus
      });
    }
  };

  const { hasPermission, hasAnyPermission, hasAllPermissions } = usePermissions();

  // Early return if required data is not available
  if (!properties) {
    return (
      <AppLayout>
        <Head title="Properties" />
        <div className="py-12 bg-background text-foreground transition-colors min-h-screen">
          <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div className="text-center">Loading...</div>
          </div>
        </div>
      </AppLayout>
    );
  }

  return (
    <AppLayout>
      <Head title="Properties" />

      <div className="py-12 bg-background text-foreground transition-colors min-h-screen">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          {/* Statistics Cards - Only show if statistics exists */}
          {statistics && (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
              <Card className="bg-card text-card-foreground shadow-lg">
                <CardContent className="p-6">
                  <div className="text-2xl font-bold">{statistics.total}</div>
                  <p className="text-muted-foreground">Active Properties</p>
                </CardContent>
              </Card>
              <Card className="bg-card text-card-foreground shadow-lg">
                <CardContent className="p-6">
                  <div className="text-2xl font-bold">{statistics.archived}</div>
                  <p className="text-muted-foreground">Archived Properties</p>
                </CardContent>
              </Card>
              <Card className="bg-card text-card-foreground shadow-lg">
                <CardContent className="p-6">
                  <div className="text-2xl font-bold">{statistics.total_with_archived}</div>
                  <p className="text-muted-foreground">Total Properties</p>
                </CardContent>
              </Card>
            </div>
          )}

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {/* Add Property Form Card */}
            {hasAllPermissions(['properties.store', 'properties.create']) && (
              <div className="lg:col-span-1">
                <Card className="bg-card text-card-foreground shadow-lg">
                  <CardHeader>
                    <div className="flex justify-between items-center">
                      <CardTitle className="text-xl">Manage Properties</CardTitle>
                      <Button onClick={() => setShowForm(!showForm)} variant={showForm ? "outline" : "default"}>
                        {showForm ? (
                          <>
                            <X className="h-4 w-4 mr-2" />
                            Cancel
                          </>
                        ) : (
                          <>
                            <Plus className="h-4 w-4 mr-2" />
                            Add Property
                          </>
                        )}
                      </Button>
                    </div>
                  </CardHeader>

                  {/* Create Form */}
                  {showForm && (
                    <CardContent>
                      <h3 className="text-lg font-semibold mb-3 text-foreground">Add New Property</h3>
                      <form onSubmit={handleSubmit} className="space-y-4">
                        <div>
                          <Label htmlFor="city_id" className="block text-sm font-medium text-foreground mb-1">
                            City <span className="text-destructive">*</span>
                          </Label>
                          <Select
                            value={data.city_id.toString()}
                            onValueChange={(value) => setData('city_id', value)}
                          >
                            <SelectTrigger className="bg-input text-input-foreground">
                              <SelectValue placeholder="Select a city" />
                            </SelectTrigger>
                            <SelectContent>
                              {cities && cities.length > 0 ? (
                                cities.map((city) => (
                                  <SelectItem key={city.id} value={city.id.toString()}>
                                    {city.city}
                                  </SelectItem>
                                ))
                              ) : (
                                <SelectItem value="" disabled>
                                  No cities available
                                </SelectItem>
                              )}
                            </SelectContent>
                          </Select>
                          {errors.city_id && <div className="text-destructive text-sm mt-1">{errors.city_id}</div>}
                        </div>

                        <div>
                          <Label htmlFor="name" className="block text-sm font-medium text-foreground mb-1">
                            Property Name <span className="text-destructive">*</span>
                          </Label>
                          <Input
                            id="name"
                            type="text"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            placeholder="Enter property name"
                            className="bg-input text-input-foreground"
                            required
                          />
                          {errors.name && <div className="text-destructive text-sm mt-1">{errors.name}</div>}
                        </div>

                        <Button type="submit" disabled={processing} className="w-full">
                          {processing ? 'Adding...' : 'Add Property'}
                        </Button>
                      </form>
                    </CardContent>
                  )}
                </Card>
              </div>
            )}

            {/* Properties Table Card */}
            <div className="lg:col-span-2">
              <Card className="bg-card text-card-foreground shadow-lg">
                <CardHeader>
                  <CardTitle className="text-xl">Properties List</CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="overflow-x-auto">
                    <Table>
                      <TableHeader>
                        <TableRow className="border-border">
                          <TableHead className="text-muted-foreground">Property Name</TableHead>
                          <TableHead className="text-muted-foreground">City</TableHead>
                          <TableHead className="text-muted-foreground">Status</TableHead>
                          <TableHead className="text-muted-foreground">Units</TableHead>
                          {(hasPermission('properties.destroy') || hasPermission('properties.update')) && (
                            <TableHead className="text-muted-foreground">Actions</TableHead>
                          )}
                        </TableRow>
                      </TableHeader>
                      <TableBody>
                        {properties.data && properties.data.length > 0 ? (
                          properties.data.map((property) => (
                            <TableRow key={property.id} className="hover:bg-muted/50 border-border">
                              <TableCell className="font-medium text-foreground">{property.name}</TableCell>
                              <TableCell className="text-foreground">
                                {property.city?.city || 'N/A'}
                              </TableCell>
                              <TableCell>
                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                  property.archived
                                    ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                    : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                }`}>
                                  {property.archived ? 'Archived' : 'Active'}
                                </span>
                              </TableCell>
                              <TableCell className="text-foreground">
                                <div className="text-sm">
                                  <div>Total: {property.total_units || 0}</div>
                                  <div className="text-muted-foreground">
                                    Vacant: {property.vacant_units || 0} |
                                    Occupied: {property.occupied_units || 0}
                                  </div>
                                </div>
                              </TableCell>
                              {(hasPermission('properties.destroy') || hasPermission('properties.update')) && (
                                <TableCell>
                                  <div className="flex gap-2">
                                    {hasPermission('properties.update') && (
                                      <Button
                                        variant="outline"
                                        size="sm"
                                        onClick={() => handleArchive(property.id, property.archived)}
                                        className={`${
                                          property.archived
                                            ? 'text-green-600 hover:text-green-600 hover:bg-green-50 border-green-200'
                                            : 'text-orange-600 hover:text-orange-600 hover:bg-orange-50 border-orange-200'
                                        }`}
                                      >
                                        {property.archived ? (
                                          <ArchiveRestore className="h-4 w-4" />
                                        ) : (
                                          <Archive className="h-4 w-4" />
                                        )}
                                      </Button>
                                    )}
                                    {hasPermission('properties.destroy') && (
                                      <Button
                                        variant="outline"
                                        size="sm"
                                        onClick={() => handleDelete(property.id)}
                                        className="text-destructive hover:text-destructive hover:bg-destructive/10 border-destructive/20"
                                      >
                                        <Trash2 className="h-4 w-4" />
                                      </Button>
                                    )}
                                  </div>
                                </TableCell>
                              )}
                            </TableRow>
                          ))
                        ) : (
                          <TableRow>
                            <TableCell colSpan={5} className="text-center py-8 text-muted-foreground">
                              <p className="text-lg">No properties found.</p>
                              <p className="text-sm">Add your first property using the form on the left.</p>
                            </TableCell>
                          </TableRow>
                        )}
                      </TableBody>
                    </Table>
                  </div>

                  {/* Pagination and Records Info - Only show if properties.data exists */}
                  {properties.data && (
                    <div className="mt-6 flex justify-between items-center border-t border-border pt-4">
                      <div className="text-sm text-muted-foreground">
                        Showing {properties.from || 0} to {properties.to || 0} of {properties.total || 0} properties
                      </div>

                      {properties.last_page > 1 && (
                        <div className="flex gap-2">
                          {properties.links && properties.links.map((link, index) => (
                            <Button
                              key={index}
                              variant={link.active ? "default" : "outline"}
                              size="sm"
                              onClick={() => link.url && router.visit(link.url)}
                              disabled={!link.url}
                              className="text-xs"
                            >
                              <span dangerouslySetInnerHTML={{ __html: link.label }} />
                            </Button>
                          ))}
                        </div>
                      )}
                    </div>
                  )}
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  );
};

export default Index;
