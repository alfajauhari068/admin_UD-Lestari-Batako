{{-- Enhanced Table Component
     Responsive table with dark mode support and empty states
     Usage:
     <x-table :headers="['id' => 'No', 'nama' => 'Nama']">
         @foreach($data as $row)
             <tr>
                 <td>{{ $row->id }}</td>
                 <td>{{ $row->nama }}</td>
             </tr>
         @endforeach
     </x-table>
--}}
@props([
    'headers' => [],
    'hover' => true,
    'striped' => true,
    'responsive' => true,
    'emptyText' => 'Tidak ada data',
    'emptyRoute' => null,
    'emptyLabel' => null,
    'emptyIcon' => 'inbox',
    'showPagination' => false
])

@php
    $tableClasses = 'table';
    $tableClasses .= $striped ? ' table-striped' : '';
    $tableClasses .= $hover ? ' table-hover' : '';
@endphp

<div class="table-container {{ $responsive ? 'table-responsive' : '' }}">
    <table class="{{ $tableClasses }}">
        @if(!empty($headers))
            <thead class="table-light">
                <tr>
                    @foreach($headers as $key => $label)
                        <th>
                            @if(is_string($key))
                                @php
                                    $currentSort = request('sort');
                                    $currentDir = request('direction', 'asc');
                                    $nextDir = ($currentSort === $key && $currentDir === 'asc') ? 'desc' : 'asc';
                                    $query = array_merge(request()->query(), ['sort' => $key, 'direction' => $nextDir]);
                                    $url = url()->current() . '?' . http_build_query($query);
                                @endphp
                                <a href="{{ $url }}" class="text-decoration-none text-reset d-flex align-items-center gap-1">
                                    {{ $label }}
                                    @if($currentSort === $key)
                                        <i class="bi bi-arrow-{{ $currentDir === 'asc' ? 'up' : 'down' }}-short"></i>
                                    @endif
                                </a>
                            @else
                                {{ $label }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            {{ $slot }}
        </tbody>
    </table>

    {{-- Empty State --}}
    @if(trim($slot) === '' || !preg_match('/<tr/i', trim($slot)))
        <div class="text-center py-5">
            <x-empty-state
                :icon="$emptyIcon"
                :title="$emptyText"
                :action-route="$emptyRoute"
                :action-label="$emptyLabel"
            />
        </div>
    @endif
</div>

{{-- Pagination --}}
@if($showPagination)
    <div class="mt-3 d-flex justify-content-end">
        {{ $slot->getParent() ?? '' }}
    </div>
@endif
