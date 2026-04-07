@props(['status'])

@php
    $config = match ($status) {
        'unpaid'      => ['classes' => 'bg-yellow-400/10 text-yellow-400 border-yellow-400/30', 'icon' => 'fa-clock', 'label' => 'Unpaid', 'pulse' => false],
        'paid'        => ['classes' => 'bg-blue-400/10 text-blue-400 border-blue-400/30',   'icon' => 'fa-credit-card', 'label' => 'Paid', 'pulse' => false],
        'in_progress' => ['classes' => 'bg-orange-400/10 text-orange-400 border-orange-400/30', 'icon' => 'fa-fire', 'label' => 'In Progress', 'pulse' => true],
        'all_done'    => ['classes' => 'bg-emerald-400/10 text-emerald-400 border-emerald-400/30', 'icon' => 'fa-circle-check', 'label' => 'All Done', 'pulse' => false],
        default       => ['classes' => 'bg-stone-400/10 text-stone-400 border-stone-400/30', 'icon' => 'fa-circle', 'label' => str($status)->headline(), 'pulse' => false],
    };
@endphp

<span {{ $attributes->class("inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-bold {$config['classes']}") }}>
    <i class="fa-solid {{ $config['icon'] }} text-[10px] {{ $config['pulse'] ? 'animate-status-pulse' : '' }}"></i>
    {{ $config['label'] }}
</span>
