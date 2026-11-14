@props([
    'eyebrow' => null,
    'title',
    'titleId' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'max-w-2xl']) }}>
    @if ($eyebrow)
        <p class="font-mono text-xs font-bold tracking-wide text-[#926018] uppercase">
            {{ $eyebrow }}
        </p>
    @endif
    <h2 @if($titleId) id="{{ $titleId }}" @endif class="{{ $eyebrow ? 'mt-1' : '' }} text-2xl font-bold tracking-tight text-[#10231b] sm:text-3xl">
        {{ $title }}
    </h2>
    <div aria-hidden="true" class="mt-2.5 h-1 w-12 rounded-full bg-[#d49b35]"></div>
    @if ($subtitle)
        <p class="mt-3 text-sm leading-relaxed text-[#3f5249] sm:text-[15px]">
            {{ $subtitle }}
        </p>
    @endif
</div>

