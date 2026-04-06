@props(['status'])

@php
    $classes = match ($status) {
        'unpaid' => 'bg-yellow-100 text-yellow-800',
        'paid' => 'bg-blue-100 text-blue-800',
        'in_progress' => 'bg-orange-100 text-orange-800',
        'all_done' => 'bg-green-100 text-green-800',
        default => 'bg-stone-100 text-stone-700',
    };

    $label = match ($status) {
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
        'in_progress' => 'In Progress',
        'all_done' => 'All Done',
        default => str($status)->headline(),
    };
@endphp

<span {{ $attributes->class("rounded-full px-3 py-1 text-xs font-bold {$classes}") }}>
    {{ $label }}
</span>
