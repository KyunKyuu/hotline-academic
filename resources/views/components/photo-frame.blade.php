@props(['item', 'path' => 'gallery'])

<div {{ $attributes->merge(['class' => 'group relative overflow-hidden bg-surface-card shadow-sm']) }}>
    @if (!empty($item['exists']))
        <img
            src="{{ asset('images/'.$path.'/'.$item['file']) }}"
            alt="{{ $item['caption'] }}"
            loading="lazy"
            class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
        >
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink/80 via-ink/10 to-transparent p-5 pt-12">
            <p class="text-sm font-medium text-on-dark">{{ $item['caption'] }}</p>
        </div>
    @else
        <div class="photo-frame absolute inset-0 text-ink/[0.06]"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 p-6 text-center">
            <svg viewBox="0 0 24 24" class="h-9 w-9 text-muted-soft" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M3 7h3l1.5-2h9L18 7h3v12H3z" />
                <circle cx="12" cy="13" r="3.3" stroke-width="1.2" />
            </svg>
            <span class="h-px w-10 bg-primary/40"></span>
            <p class="max-w-[16rem] font-serif text-lg italic leading-snug text-muted">{{ $item['caption'] }}</p>
        </div>
    @endif
</div>
