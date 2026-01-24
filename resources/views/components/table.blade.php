{{-- Minimal table component
     Expects: $rows (iterable), and optional $headers (array of ['key'=>'Label'])
     Provides: sortable header attrs, badge span helper, skeleton rows when empty
--}}
@props(['rows' => null, 'headers' => null, 'emptyText' => 'No data'])

<div class="table-component" id="table-component-{{ uniqid() }}">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            {{-- slot for actions (export buttons etc) --}}
            {{ $slot ?? '' }}
        </div>
        <div class="text-muted small">Total: {{ is_countable($rows) ? count($rows) : (method_exists($rows, 'count') ? $rows->count() : '-') }}</div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    @if($headers)
                        @foreach($headers as $key => $label)
                            @php
                                $currentSort = request('sort');
                                $currentDir = request('direction', 'asc');
                                $nextDir = ($currentSort === $key && $currentDir === 'asc') ? 'desc' : 'asc';
                                $query = array_merge(request()->query(), ['sort' => $key, 'direction' => $nextDir]);
                                $url = url()->current() . '?' . http_build_query($query);
                            @endphp
                            <th>
                                <a href="{{ $url }}" class="text-decoration-none text-reset" data-sort="{{ $key }}">
                                    {{ $label }}
                                    @if($currentSort === $key)
                                        <i class="bi bi-arrow-{{ $currentDir === 'asc' ? 'up' : 'down' }}-short"></i>
                                    @endif
                                </a>
                            </th>
                        @endforeach
                    @else
                        {{-- fallback to automatic header from first row keys --}}
                        @php $first = is_iterable($rows) ? (is_countable($rows) && count($rows)>0 ? (is_array($rows) ? $rows[0] : $rows->first()) : null) : null; @endphp
                        @if($first)
                            @foreach(array_keys((array)$first) as $k)
                                <th>{{ $k }}</th>
                            @endforeach
                        @else
                            <th>Data</th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($rows && (is_countable($rows) ? count($rows) > 0 : (method_exists($rows, 'isEmpty') ? !$rows->isEmpty() : true)))
                    {{-- allow the caller to render rows by iterating $rows themselves via include --}}
                    @foreach($rows as $row)
                        <tr>
                            @if($headers)
                                @foreach($headers as $key => $label)
                                    <td>
                                        @php $v = data_get($row, $key); @endphp
                                        @if(is_bool($v))
                                            <span class="badge bg-{{ $v ? 'success' : 'danger' }}">{{ $v ? 'Yes' : 'No' }}</span>
                                        @else
                                            {{ $v }}
                                        @endif
                                    </td>
                                @endforeach
                            @else
                                <td>{{ is_object($row) ? json_encode($row) : (is_array($row) ? implode(', ', $row) : $row) }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    {{-- skeleton / empty state --}}
                    <tr>
                        <td colspan="100" class="text-center text-muted py-4">{{ $emptyText }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

        {{-- Include loading overlay for progressive enhancement --}}
        @include('components.loading', ['id' => 'table-loading'])

        {{-- If rows are paginator, render links --}}
        @if(method_exists($rows, 'links'))
            <div class="mt-2">
                {{ $rows->withQueryString()->links() }}
            </div>
        @endif
</div>
