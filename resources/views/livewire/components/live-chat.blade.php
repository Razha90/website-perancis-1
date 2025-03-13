<div>
    <div x-data="chatComponent()" x-init="loadMessages()">
        <div style="height: 300px; overflow-y: auto;">
            <template x-for="msg in messages" :key="msg . id">
                <p><strong x-text="msg.sender_id"></strong>: <span x-text="msg.message"></span></p>
            </template>
        </div>

        <div>
            <input type="text" wire:model="newMessage" placeholder="Tulis pesan...">
            <button wire:click="sendMessage('{{ $newMessage }}')">Kirim</button>
        </div>
    </div>

    <script>
        function chatComponent() {
            return {
                messages: JSON.parse(localStorage.getItem('chat_messages')) || @json($messages),
                newMessage: '',

                loadMessages() {
                    window.addEventListener('message-received', event => {
                        this.messages.push(event.detail);
                        localStorage.setItem('chat_messages', JSON.stringify(this.messages));
                    });
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let userId = {{ auth()->id() }};
            window.Echo.channel(`chat.{{ auth()->id() }}`)
                .listen('MessageSent', (e) => {
                    console.log("Pesan baru diterima:", e.message);

                });

        });
    </script>

</div>