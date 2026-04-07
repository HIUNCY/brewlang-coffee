@props([
    'title',
    'description',
    'actionLabel' => null,
    'actionHref' => null,
])

<div {{ $attributes->class('rounded-2xl border border-dashed border-stone-700 bg-stone-900/50 p-10 text-center') }}>
    <div class="mx-auto max-w-xs">
        <div class="mx-auto mb-4 w-12 h-12 rounded-2xl bg-stone-800 border border-stone-700 flex items-center justify-center">
            <i class="fa-regular fa-circle-dot text-stone-500 text-lg"></i>
        </div>
        <p class="text-base font-bold text-stone-300">{{ $title }}</p>
        <p class="mt-2 text-sm leading-6 text-stone-600">{{ $description }}</p>

        @if($actionLabel && $actionHref)
            <a href="{{ $actionHref }}" class="btn-secondary mt-6 !text-sm !py-2 !px-4">
                {{ $actionLabel }}
            </a>
        @endif
    </div>
</div>
