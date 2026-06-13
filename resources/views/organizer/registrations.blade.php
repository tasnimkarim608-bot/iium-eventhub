<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrations: {{ $event->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($registrations as $reg)
                        <div class="border p-2 mb-2">{{ $reg->user->name }} - {{ $reg->user->email }}</div>
                    @empty
                        <p>No registrations yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>