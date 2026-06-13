<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Event') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('organizer.events.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label>Title</label>
                            <input type="text" name="title" class="w-full border rounded p-2" required>
                        </div>
                        <div class="mb-4">
                            <label>Description</label>
                            <textarea name="description" class="w-full border rounded p-2" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label>Venue</label>
                            <input type="text" name="venue" class="w-full border rounded p-2" required>
                        </div>
                        <div class="mb-4">
                            <label>Event Date</label>
                            <input type="date" name="event_date" class="w-full border rounded p-2" required>
                        </div>
                        <div class="mb-4">
                            <label>Category</label>
                            <input type="text" name="category" class="w-full border rounded p-2" required>
                        </div>
                        <div class="mb-4">
                            <label>Max Slots</label>
                            <input type="number" name="max_slots" class="w-full border rounded p-2" required>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>