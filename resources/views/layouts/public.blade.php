{{-- Public Layout
     Minimal layout for public-facing pages
     Extends app.blade.php for consistent header/footer
--}}
@extends('layouts.app')

@section('content')
    <div class="public-content">
        {{ $slot }}
    </div>
@endsection
