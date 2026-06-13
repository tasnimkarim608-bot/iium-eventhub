<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upcoming Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($events->count() > 0)
                        @foreach($events as $event)
                            <div class="border rounded-lg p-4 shadow mb-4">
                                <h3 class="text-lg font-bold">{{ $event->title }}</h3>
                                <p class="text-gray-600">{{ $event->description }}</p>
                                <p class="mt-2"><strong>Venue:</strong> {{ $event->venue }}</p>
                                <p><strong>Date:</strong> {{ $event->event_date }}</p>
                                <p><strong>Category:</strong> {{ $event->category }}</p>
                                <p><strong>Available Slots:</strong> {{ $event->max_slots - $event->registrations->count() }}</p>
                                
                                <button onclick="openModal({{ $event->id }}, '{{ $event->title }}')" style="background-color: #00A19D; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer; border: none;">
                                    Register for Event
                                </button>
                            </div>
                        @endforeach
                    @else
                        <p>No events available yet.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="registerModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; width: 400px;">
            <h3 id="modalEventTitle" style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">Register for Event</h3>
            
            <form id="registrationForm">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Name</label>
                    <input type="text" id="studentName" readonly style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; background: #f5f5f5;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Matric Number</label>
                    <input type="text" id="matricNumber" readonly style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; background: #f5f5f5;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Kulliyah</label>
                    <input type="text" id="kulliyah" value="KICT" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Year</label>
                    <input type="text" id="year" value="2" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="background-color: #00A19D; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer; border: none;">Register</button>
                    <button type="button" onclick="closeModal()" style="background-color: #ccc; padding: 10px 20px; border-radius: 5px; cursor: pointer; border: none;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentEventId = null;
        
        function openModal(eventId, eventTitle) {
            currentEventId = eventId;
            document.getElementById('modalEventTitle').innerText = 'Register for ' + eventTitle;
            document.getElementById('studentName').value = '{{ Auth::user()->name }}';
            document.getElementById('matricNumber').value = '{{ Auth::user()->email }}';
            document.getElementById('registerModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('registerModal').style.display = 'none';
        }
        
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch('/events/register/' + currentEventId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            }).then(response => response.json()).then(data => {
                closeModal();
                let notification = document.createElement('div');
                notification.innerText = data.message;
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.backgroundColor = '#00A19D';
                notification.style.color = 'white';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.zIndex = '1001';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
                setTimeout(() => location.reload(), 1500);
            }).catch(error => {
                closeModal();
                let notification = document.createElement('div');
                notification.innerText = 'Registration failed!';
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.backgroundColor = 'red';
                notification.style.color = 'white';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.zIndex = '1001';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            });
        });
    </script>
</x-app-layout>