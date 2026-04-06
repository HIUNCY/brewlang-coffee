@props([
    'title',
    'description',
    'actionLabel' => null,
    'actionHref' => null,
])

<div {{ $attributes->class('rounded-[2rem] border border-dashed border-stone-300 bg-stone-50 p-10 text-center') }}>
    <div class="mx-auto max-w-xl">
        <p class="text-lg font-bold text-stone-900">{{ $title }}</p>
        <p class="mt-3 text-sm leading-6 text-stone-600">{{ $description }}</p>

        @if($actionLabel && $actionHref)
            <a href="{{ $actionHref }}" class="mt-6 inline-flex rounded-full border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 transition hover:border-amber-300 hover:text-amber-900">
                {{ $actionLabel }}
            </a>
        @endif
    </div>
</div>
