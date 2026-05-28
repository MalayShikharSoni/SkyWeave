# SkyWeave — Software Requirements Specification (SRS)

## Aviation Route Visualization & ATS Route Management Platform

---

# 1. Executive Summary

## 1.1 Project Overview

**SkyWeave** is a professional-grade aviation navigation and ATS (Air Traffic Service) route management web application designed for efficient geographical visualization and structured route planning.

The platform enables aviation professionals, trainees, dispatch operators, and navigation analysts to:

- Visualize aviation waypoints on an interactive aeronautical map
- View and filter NAVAIDs (VOR, DME, NDB, TACAN, etc.)
- Construct ATS routes by connecting valid navigation points
- Manage route metadata and waypoint sequencing
- Validate route integrity using aviation-oriented constraints

The platform prioritizes:

- Data accuracy
- Workflow efficiency
- Geospatial clarity
- Real-world aviation utility
- Clean professional UI

The system explicitly avoids:
- Gamification
- Achievement systems
- Social engagement mechanics
- Habit tracking

SkyWeave is intended to function as a serious operational and educational aviation utility.

---

# 2. Technology Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel |
| Architecture Pattern | MVC |
| Frontend Templating | Laravel Blade |
| Styling | TailwindCSS |
| Mapping Library | Google Maps JavaScript API |
| Database | PostgreSQL or MySQL |
| ORM | Laravel Eloquent |
| Authentication | Laravel Breeze or Jetstream |
| API Response Format | JSON |
| Session Management | Laravel Sessions |

---

# 3. Core Features

## 3.1 Waypoints & NAVAIDs

### Functionalities
- Create, update, delete, and manage waypoints
- Display aviation navigation aids
- Filter waypoints by type, region, or identifier
- Plot coordinates on an interactive map
- Support aviation-grade coordinate integrity

### Supported NAVAIDs
- VOR
- DME
- VOR/DME
- NDB
- TACAN

---

## 3.2 ATS Route Builder

### Functionalities
- Create ATS routes
- Add ordered waypoint sequences
- Remove or reorder route waypoints
- Save route drafts
- Calculate route distances
- Validate waypoint continuity

---

## 3.3 Interactive Map Features (Google Maps JavaScript API)

### Features
- Zoom, pan, and smooth vector rendering
- Polyline route rendering with dashed amber lines
- SVG circle markers for waypoints and NAVAIDs
- Custom dark JSON style array matching SkyWeave's premium aesthetic
- InfoWindow tooltip overlays on hover
- Real-time layer toggling (Waypoints / NAVAIDs / Routes)
- Permanent waypoint labels on route detail view via OverlayView
- Accurate geopolitical boundaries (Google's authoritative map data)
- Async API loading via bootstrap loader pattern

---

# 4. MVC Architecture

## Models

- User
- Waypoint
- Navaid
- ATSRoute
- RouteWaypoint

---

## Controllers

| Controller | Responsibility |
|---|---|
| DashboardController | Dashboard rendering |
| WaypointController | Waypoint CRUD |
| NavaidController | NAVAID CRUD |
| ATSRouteController | ATS route management |
| MapApiController | JSON map endpoints |
| DraftRouteController | Session draft handling |

---

## Blade Views

```plaintext
dashboard.blade.php
waypoints/index.blade.php
waypoints/create.blade.php
waypoints/edit.blade.php

navaids/index.blade.php

routes/index.blade.php
routes/create.blade.php
routes/show.blade.php
routes/edit.blade.php
```

---

# 5. Database Architecture

## create_waypoints_table

```php
Schema::create('waypoints', function (Blueprint $table) {
    $table->id();

    $table->string('identifier')->unique();

    $table->decimal('latitude', 10, 7);
    $table->decimal('longitude', 10, 7);

    $table->string('region')->nullable();

    $table->string('type')->default('FIX');

    $table->timestamps();
});
```

---

## create_navaids_table

```php
Schema::create('navaids', function (Blueprint $table) {
    $table->id();

    $table->string('identifier')->unique();

    $table->string('name');

    $table->enum('type', [
        'VOR',
        'DME',
        'VOR_DME',
        'NDB',
        'TACAN'
    ]);

    $table->decimal('frequency', 6, 2)->nullable();

    $table->decimal('latitude', 10, 7);
    $table->decimal('longitude', 10, 7);

    $table->timestamps();
});
```

---

## create_ats_routes_table

```php
Schema::create('ats_routes', function (Blueprint $table) {
    $table->id();

    $table->string('route_name')->unique();

    $table->text('description')->nullable();

    $table->foreignId('created_by')
          ->constrained('users')
          ->onDelete('cascade');

    $table->timestamps();
});
```

---

## create_route_waypoint_table

```php
Schema::create('route_waypoint', function (Blueprint $table) {

    $table->id();

    $table->foreignId('ats_route_id')
          ->constrained()
          ->onDelete('cascade');

    $table->foreignId('waypoint_id')
          ->constrained()
          ->onDelete('cascade');

    $table->integer('sequence_order');

    $table->timestamps();

    $table->unique([
        'ats_route_id',
        'sequence_order'
    ]);
});
```

---

# 6. Laravel Routing

## web.php

```php
Route::middleware(['auth'])->group(function () {

    Route::resource('waypoints', WaypointController::class);

    Route::resource('navaids', NavaidController::class);

    Route::resource('routes', ATSRouteController::class);

    Route::post('/routes/draft/add',
        [DraftRouteController::class, 'addWaypoint']);

    Route::post('/routes/draft/remove',
        [DraftRouteController::class, 'removeWaypoint']);
});
```

---

## api.php

```php
Route::get('/map/waypoints',
    [MapApiController::class, 'waypoints']);

Route::get('/map/navaids',
    [MapApiController::class, 'navaids']);

Route::get('/map/routes',
    [MapApiController::class, 'routes']);
```

---

# 7. Validation Rules

## Latitude Validation

```php
'latitude' => [
    'required',
    'numeric',
    'between:-90,90'
]
```

---

## Longitude Validation

```php
'longitude' => [
    'required',
    'numeric',
    'between:-180,180'
]
```

---

## Route Validation

```php
'waypoints' => [
    'required',
    'array',
    'min:2'
]
```

---

# 8. Session State Management

## Draft Route Session Example

```php
session([
    'draft_route' => [
        'waypoints' => [...],
        'metadata' => [...]
    ]
]);
```

---

# 9. Mapping API Integration (Google Maps JavaScript API)

## Configuration

The Google Maps API key is managed via Laravel's config system:

| Layer | Location | Value |
|---|---|---|
| Environment | `.env` | `GOOGLE_MAPS_API_KEY=AIzaSy...` |
| Config | `config/services.php` | `'google_maps' => ['key' => env('GOOGLE_MAPS_API_KEY')]` |
| Template | `layouts/app.blade.php` | `config('services.google_maps.key')` |

The API is loaded asynchronously using Google's official **Dynamic Library Import** bootstrap loader, ensuring the page renders immediately while the map library loads in the background.

## Internal API Endpoints

```plaintext
GET /api/map/waypoints    → google.maps.Marker (SVG circle icons)
GET /api/map/navaids      → google.maps.Marker (color-coded hollow circles)
GET /api/map/routes       → google.maps.Polyline (dashed amber lines)
```

---

## Example JSON Response

```json
[
  {
    "id": 1,
    "identifier": "DPN",
    "latitude": 28.7041,
    "longitude": 77.1025,
    "type": "FIX"
  }
]
```

---

# 10. Performance Targets

| Requirement | Target |
|---|---|
| Dashboard Load | < 3 seconds |
| API Response | < 500 ms |
| Map Rendering | < 2 seconds |
| Waypoint Search | < 300 ms |

---

# 11. Security Requirements

- CSRF protection
- Eloquent ORM SQL injection prevention
- Input sanitization
- Rate limiting
- Authorization middleware

---

# 12. Future Enhancements

- FIR overlays
- Weather layers
- NOTAM integration
- GeoJSON import/export
- ICAO route export
- Real-time aircraft visualization

---

# 13. Final Notes

SkyWeave is designed as a professional aviation routing and geospatial visualization platform with a strict emphasis on:

- Data integrity
- Real-world operational utility
- Maintainable Laravel MVC architecture
- Professional UI/UX
- Scalable geospatial systems
