@props(['currentRoute'])

@php
    $segments = explode('/', trim(request()->path(), '/'));
    $breadcrumbs = [];
    
    // Always add Dashboard as the first item
    $breadcrumbs[] = [
        'title' => 'Dashboard',
        'href' => route('dashboard'),
        'isCurrent' => false
    ];
    
    // Build the breadcrumb trail
    $path = '';
    foreach ($segments as $segment) {
        $path .= '/' . $segment;
        $route = request()->root() . $path;
        
        // Skip numeric segments (like user IDs)
        if (is_numeric($segment)) {
            continue;
        }
        
        // Get the route name if it exists
        $routeName = null;
        try {
            $routeName = Route::getRoutes()->match(Request::create($route))->getName();
        } catch (\Exception $e) {
            // Route not found, continue
        }
        
        // Format the segment title
        $title = str_replace('-', ' ', $segment);
        $title = ucwords($title);
        
        // Special cases for route names
        if ($routeName) {
            switch ($routeName) {
                case 'users.index':
                    $title = 'Users';
                    break;
                case 'users.create':
                    $title = 'Create User';
                    break;
                case 'users.edit':
                    $title = 'Edit User';
                    break;
                case 'users.show':
                    $title = 'User Details';
                    break;
                // Add more cases as needed
            }
        }
        
        $breadcrumbs[] = [
            'title' => $title,
            'href' => $route,
            'isCurrent' => $path === request()->path()
        ];
    }
@endphp

<div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
    <flux:breadcrumbs>
        @foreach ($breadcrumbs as $index => $breadcrumb)
            @if ($index === count($breadcrumbs) - 1)
                <flux:breadcrumbs.item>{{ $breadcrumb['title'] }}</flux:breadcrumbs.item>
            @else
                <flux:breadcrumbs.item :href="$breadcrumb['href']">{{ $breadcrumb['title'] }}</flux:breadcrumbs.item>
            @endif
        @endforeach
    </flux:breadcrumbs>
</div> 