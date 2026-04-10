@php
    $containerClass = $containerClass ?? 'kontak-map relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.08),0_1px_2px_rgba(0,0,0,0.06)]';
    $height = $height ?? '280px';
    $mapLabel = $mapLabel ?? 'Klik untuk buka di Google Maps';
@endphp

<div class="{{ $containerClass }}" style="height: {{ $height }};">
    <iframe
        title="Lokasi SD N 2 Dermolo"
        src="{{ $mapsEmbed }}"
        class="h-full w-full border-0"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
    <a href="{{ $mapsOpen }}"
       target="_blank"
       rel="noopener"
       class="absolute inset-0"
       aria-label="Buka lokasi SD N 2 Dermolo di Google Maps"></a>
    <div class="absolute bottom-2 right-2 rounded-full bg-white/90 px-3 py-1 text-[0.7rem] font-semibold text-slate-700 shadow">
        {{ $mapLabel }}
    </div>
</div>
