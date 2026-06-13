<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Organizer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('organizer.events.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Create New Event</a>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse($events as $event)
                        <div class="border p-4 mb-2 rounded">
                            <h3 class="font-bold text-lg">{{ $event->title }}</h3>
                            <p>{{ $event->event_date }} | {{ $event->venue }} | Slots: {{ $event->max_slots - $event->registrations->count() }}/{{ $event->max_slots }}</p>
                            <div class="mt-2 flex gap-2">
                                <a href="{{ route('organizer.events.edit', $event->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                                <a href="{{ route('organizer.events.registrations', $event->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">View Registrations</a>
                                <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>No events created yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>