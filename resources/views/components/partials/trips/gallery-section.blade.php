@props(['trip'])

@if($trip->images->isNotEmpty())
    <div>
        <h2 class="font-display text-lg font-bold text-ink mb-4">Galeri Foto</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($trip->images as $image)
                <div class="aspect-4/3 rounded-xl overflow-hidden bg-surface-sunken">
                    <img
                        src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : Storage::url($image->image_path) }}"
                        alt="{{ $trip->title }}"
                        class="size-full object-cover hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    >
                </div>
            @endforeach
        </div>
    </div>
@endif
