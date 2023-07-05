@php
    $sort_by_asc = fn($name) => request()->query('sort_by') === $name && request()->query('order_by') === 'asc';
    $sort_by_desc = fn($name) => request()->query('sort_by') === $name && request()->query('order_by') === 'desc';
    $sort_by = request()->query('sort_by');
    $sort_active_class = "flex-none ml-2 rounded bg-gray-200 dark:bg-gray-500 text-gray-900 group-hover:bg-gray-300 dark:group-hover:bg-gray-400";
    $sort_class = "invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible";
    $svg_desc = "M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z";
    $svg_asc = "M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z";
@endphp
<th scope="col"
    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-300 sm:pl-6">
    <a href="{{ route('admin.users.index', ['sort_by' => $field, 'order_by' => $sort_by_asc($field) ? 'desc' : 'asc']) }}"
       class="group inline-flex">
        {{ __($title) }}
        <span
            class="@if($sort_by === $field) {{ $sort_active_class }} @else {{ $sort_class }} @endif">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                 fill="currentColor" class="w-5 h-5">
                  <path fill-rule="evenodd"
                        d="@if($sort_by_desc($field)){{$svg_desc}}@else{{$svg_asc}}@endif"
                        clip-rule="evenodd"/>
            </svg>
        </span>
    </a>
</th>
