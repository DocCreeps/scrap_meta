<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-4" x-data="{ loading: false }">

    <form wire:submit.prevent="fetchPreview" @submit="loading = true" class="flex gap-2">
        <div class="relative flex-1">
            <input type="url" wire:model.defer="url" placeholder="Collez votre lien ici (https://...)" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('url') border-red-500 @enderror" />
            @error('url')
            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2 disabled:opacity-50" wire:loading.attr="disabled">
            <span wire:loading wire:target="fetchPreview" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
            <span>Générer</span>
        </button>
    </form>

    <div wire:loading.remove wire:target="fetchPreview">
        @if($error)
        <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm">
            {{ $error }}
        </div>
        @endif
    </div>



    @if($metadata && !$error)
    <a href="{{ $metadata['url'] }}" target="_blank" rel="noopener noreferrer" class="block border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-300 group bg-gray-50" wire:loading.class="hidden" wire:target="fetchPreview">
        @if($metadata['image'])
        <div class="h-48 w-full overflow-hidden bg-gray-100 relative">
            <img src="{{ $metadata['image'] }}" alt="{{ $metadata['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
        </div>
        @endif

        <div class="p-4 space-y-1">
            <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                {{ $metadata['provider'] }}
            </p>
            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                {{ $metadata['title'] }}
            </h3>
            <p class="text-sm text-gray-600 line-clamp-2">
                {{ $metadata['description'] }}
            </p>
            <span class="text-xs text-gray-400 inline-block pt-2 truncate w-full">
                {{ $metadata['url'] }}
            </span>
        </div>
    </a>
    @endif
</div>
