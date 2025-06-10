<!-- filepath: resources/views/components/breadcrumb.blade.php -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>