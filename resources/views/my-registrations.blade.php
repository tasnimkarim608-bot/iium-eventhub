<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Registrations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @php
                        $registrations = App\Models\Registration::where('user_id', Auth::id())->with('event')->get();
                    @endphp

                    @forelse($registrations as $reg)
                        <div class="border p-4 mb-2 rounded flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">{{ $reg->event->title }}</h3>
                                <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($reg->event->event_date)->format('F j, Y') }}</p>
                                <p><strong>Venue:</strong> {{ $reg->event->venue }}</p>
                            </div>
                            <button onclick="openCancelModal({{ $reg->event->id }}, '{{ $reg->event->title }}')" style="background-color: red; color: white; padding: 8px 16px; border-radius: 5px; cursor: pointer; border: none;">
                                Cancel
                            </button>
                        </div>
                    @empty
                        <p>You haven't registered for any events yet.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; width: 350px; text-align: center;">
            <h3 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">Confirm Cancellation</h3>
            <p id="cancelEventTitle" style="margin-bottom: 25px; font-size: 16px;"></p>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <button id="confirmCancelBtn" style="background-color: red; color: white; padding: 10px 25px; border-radius: 5px; cursor: pointer; border: none; font-size: 16px;">Yes</button>
                <button onclick="closeCancelModal()" style="background-color: #ccc; color: black; padding: 10px 25px; border-radius: 5px; cursor: pointer; border: none; font-size: 16px;">No</button>
            </div>
        </div>
    </div>

    <script>
        let cancelEventId = null;
        
        function openCancelModal(eventId, eventTitle) {
            cancelEventId = eventId;
            document.getElementById('cancelEventTitle').innerHTML = 'Cancel registration for <strong>"' + eventTitle + '"</strong>?';
            document.getElementById('cancelModal').style.display = 'block';
        }
        
        function closeCancelModal() {
            document.getElementById('cancelModal').style.display = 'none';
        }
        
        document.getElementById('confirmCancelBtn').onclick = function() {
            fetch('/events/cancel/' + cancelEventId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                closeCancelModal();
                
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
                notification.style.fontSize = '16px';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                    location.reload();
                }, 2000);
            }).catch(error => {
                closeCancelModal();
                let notification = document.createElement('div');
                notification.innerText = 'Error cancelling registration!';
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.backgroundColor = 'red';
                notification.style.color = 'white';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.zIndex = '1001';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 2000);
            });
        };
    </script>
</x-app-layout>