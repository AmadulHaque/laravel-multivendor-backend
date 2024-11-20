<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'division', 'district', 'city'
        $locations = [
            [
                'type' => 'division',
                'name' => 'Dhaka',
                'children' => [
                    [
                        'type' => 'district',
                        'name' => 'Gazipur',
                        'children' => [
                            ['type' => 'city', 'name' => 'Gazipur Sadar'],
                            ['type' => 'city', 'name' => 'Kaliakair'],
                            ['type' => 'city', 'name' => 'Kapasia'],
                        ],
                    ],
                    [
                        'type' => 'district',
                        'name' => 'Faridpur',
                        'children' => [
                            ['type' => 'city', 'name' => 'Faridpur Sadar'],
                            ['type' => 'city', 'name' => 'Bhanga'],
                            ['type' => 'city', 'name' => 'Madhukhali'],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'division',
                'name' => 'Chattogram',
                'children' => [
                    [
                        'type' => 'district',
                        'name' => 'Cox\'s Bazar',
                        'children' => [
                            ['type' => 'city', 'name' => 'Teknaf'],
                            ['type' => 'city', 'name' => 'Ukhiya'],
                        ],
                    ],
                ],
            ],
        ];

        // Seed the data recursively
        $this->seedLocations($locations);
    }

    /**
     * Recursively seed locations.
     *
     * @param array $locations
     * @param int|null $parentId
     */
    private function seedLocations(array $locations, ?int $parentId = null): void
    {
        foreach ($locations as $location) {
            $newLocation = Location::create([
                'type' => $location['type'],
                'name' => $location['name'],
                'parent_id' => $parentId,
            ]);

            if (isset($location['children'])) {
                $this->seedLocations($location['children'], $newLocation->id);
            }
        }
    }
}
