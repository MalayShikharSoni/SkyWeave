<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Waypoint;
use App\Models\Navaid;
use App\Models\ATSRoute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        $user = User::factory()->create([
            'name' => 'Admin Controller',
            'email' => 'admin@skyweave.local',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed NAVAIDs (Major Indian VORs/DMEs)
        $navaidsData = [
            ['identifier' => 'DPN', 'name' => 'Delhi VOR', 'type' => 'VOR_DME', 'frequency' => 116.30, 'latitude' => 28.5665, 'longitude' => 77.1031],
            ['identifier' => 'BBB', 'name' => 'Mumbai VOR', 'type' => 'VOR_DME', 'frequency' => 116.60, 'latitude' => 19.0886, 'longitude' => 72.8679],
            ['identifier' => 'JAI', 'name' => 'Jaipur VOR', 'type' => 'VOR', 'frequency' => 112.90, 'latitude' => 26.8242, 'longitude' => 75.8009],
            ['identifier' => 'HIA', 'name' => 'Ahmedabad VOR', 'type' => 'VOR_DME', 'frequency' => 114.70, 'latitude' => 23.0734, 'longitude' => 72.6265],
            ['identifier' => 'BPL', 'name' => 'Bhopal VOR', 'type' => 'VOR_DME', 'frequency' => 113.80, 'latitude' => 23.2878, 'longitude' => 77.3371],
            ['identifier' => 'NNI', 'name' => 'Nagpur VOR', 'type' => 'VOR_DME', 'frequency' => 112.70, 'latitude' => 21.0922, 'longitude' => 79.0472],
            ['identifier' => 'HYD', 'name' => 'Hyderabad VOR', 'type' => 'VOR_DME', 'frequency' => 115.10, 'latitude' => 17.2405, 'longitude' => 78.4294],
            ['identifier' => 'BIA', 'name' => 'Bengaluru VOR', 'type' => 'VOR_DME', 'frequency' => 112.30, 'latitude' => 13.1979, 'longitude' => 77.7063],
            ['identifier' => 'MMV', 'name' => 'Chennai VOR', 'type' => 'VOR_DME', 'frequency' => 112.50, 'latitude' => 12.9900, 'longitude' => 80.1693],
            ['identifier' => 'CEA', 'name' => 'Kolkata VOR', 'type' => 'VOR_DME', 'frequency' => 112.50, 'latitude' => 22.6547, 'longitude' => 88.4467],
            ['identifier' => 'LKO', 'name' => 'Lucknow VOR', 'type' => 'VOR_DME', 'frequency' => 112.40, 'latitude' => 26.7594, 'longitude' => 80.8893],
            ['identifier' => 'GWT', 'name' => 'Guwahati VOR', 'type' => 'VOR_DME', 'frequency' => 113.30, 'latitude' => 26.1060, 'longitude' => 91.5859],
        ];

        foreach ($navaidsData as $data) {
            Navaid::create($data);
        }

        // 3. Seed Waypoints (RNAV Fixes and NAVAID collocated fixes)
        // Note: In real ATS, some NAVAIDs also act as waypoints. We'll add them to waypoints table too.
        $waypointsData = [
            ['identifier' => 'DPN', 'latitude' => 28.5665, 'longitude' => 77.1031, 'type' => 'FIX', 'region' => 'Delhi FIR'],
            ['identifier' => 'SARIN', 'latitude' => 27.5000, 'longitude' => 76.2000, 'type' => 'RNAV', 'region' => 'Delhi FIR'],
            ['identifier' => 'JAI', 'latitude' => 26.8242, 'longitude' => 75.8009, 'type' => 'FIX', 'region' => 'Delhi FIR'],
            ['identifier' => 'BOM', 'latitude' => 19.0886, 'longitude' => 72.8679, 'type' => 'FIX', 'region' => 'Mumbai FIR'],
            ['identifier' => 'HIA', 'latitude' => 23.0734, 'longitude' => 72.6265, 'type' => 'FIX', 'region' => 'Mumbai FIR'],
            ['identifier' => 'APANO', 'latitude' => 20.8500, 'longitude' => 72.2500, 'type' => 'RNAV', 'region' => 'Mumbai FIR'],
            ['identifier' => 'BPL', 'latitude' => 23.2878, 'longitude' => 77.3371, 'type' => 'FIX', 'region' => 'Mumbai FIR'],
            ['identifier' => 'NNI', 'latitude' => 21.0922, 'longitude' => 79.0472, 'type' => 'FIX', 'region' => 'Mumbai FIR'],
            ['identifier' => 'HYD', 'latitude' => 17.2405, 'longitude' => 78.4294, 'type' => 'FIX', 'region' => 'Chennai FIR'],
            ['identifier' => 'BIA', 'latitude' => 13.1979, 'longitude' => 77.7063, 'type' => 'FIX', 'region' => 'Chennai FIR'],
            ['identifier' => 'MMV', 'latitude' => 12.9900, 'longitude' => 80.1693, 'type' => 'FIX', 'region' => 'Chennai FIR'],
            ['identifier' => 'CEA', 'latitude' => 22.6547, 'longitude' => 88.4467, 'type' => 'FIX', 'region' => 'Kolkata FIR'],
            ['identifier' => 'LKO', 'latitude' => 26.7594, 'longitude' => 80.8893, 'type' => 'FIX', 'region' => 'Delhi FIR'],
            ['identifier' => 'GWT', 'latitude' => 26.1060, 'longitude' => 91.5859, 'type' => 'FIX', 'region' => 'Kolkata FIR'],
            ['identifier' => 'DABEN', 'latitude' => 24.5000, 'longitude' => 84.1000, 'type' => 'RNAV', 'region' => 'Kolkata FIR'],
            ['identifier' => 'REXOD', 'latitude' => 15.3000, 'longitude' => 79.2000, 'type' => 'RNAV', 'region' => 'Chennai FIR'],
        ];

        $waypoints = collect();
        foreach ($waypointsData as $data) {
            $waypoints->push(Waypoint::create($data));
        }

        // 4. Seed ATS Routes
        $routesData = [
            [
                'route_name' => 'W15',
                'description' => 'Major domestic trunk route Delhi to Mumbai via Jaipur and Ahmedabad.',
                'created_by' => $user->id,
                'waypoint_identifiers' => ['DPN', 'SARIN', 'JAI', 'HIA', 'APANO', 'BOM']
            ],
            [
                'route_name' => 'W20',
                'description' => 'Delhi to Kolkata via Lucknow.',
                'created_by' => $user->id,
                'waypoint_identifiers' => ['DPN', 'LKO', 'DABEN', 'CEA']
            ],
            [
                'route_name' => 'W29',
                'description' => 'Mumbai to Chennai via Hyderabad.',
                'created_by' => $user->id,
                'waypoint_identifiers' => ['BOM', 'HYD', 'REXOD', 'MMV']
            ],
            [
                'route_name' => 'W115',
                'description' => 'Delhi to Bengaluru via Bhopal and Nagpur.',
                'created_by' => $user->id,
                'waypoint_identifiers' => ['DPN', 'BPL', 'NNI', 'HYD', 'BIA']
            ]
        ];

        foreach ($routesData as $rData) {
            $route = ATSRoute::create([
                'route_name' => $rData['route_name'],
                'description' => $rData['description'],
                'created_by' => $rData['created_by'],
            ]);

            $sequence = 1;
            foreach ($rData['waypoint_identifiers'] as $wpIdentifier) {
                $wp = $waypoints->firstWhere('identifier', $wpIdentifier);
                if ($wp) {
                    $route->waypoints()->attach($wp->id, ['sequence_order' => $sequence]);
                    $sequence++;
                }
            }
        }
    }
}

