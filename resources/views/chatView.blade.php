<!-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Form</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <h2>Kirim Pesan</h2>
    <form id="chatForm">
        <label for="receiver_id">ID Penerima:</label>
        <input type="number" id="receiver_id" name="receiver_id" required><br><br>

        <label for="message">Pesan:</label>
        <textarea id="message" name="message" required></textarea><br><br>

        <button type="submit">Kirim</button>
    </form>

    <p id="responseMessage"></p>

    <script>
        axios.get('http://localhost:8001/api/messages/2', {
            headers: {
                Authorization: `Bearer {{ session('sanctum_token') }}`,
            },
        })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.error(error);
            });

        document.getElementById('chatForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah reload halaman

            const receiverId = document.getElementById('receiver_id').value;
            const message = document.getElementById('message').value;

            axios.post('http://localhost:8001/api/messages/send', {
                receiver_id: receiverId,
                message: message
            }, {
                headers: {
                    Authorization: `Bearer {{ session('sanctum_token') }}`,
                },
            }

            )
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>

</html> -->

<!DOCTYPE html>
<html lang="id">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Form</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/bootstrap.js'])
    @endif
</head>

<body>
    <div id="chat-box" style="border:1px solid #ddd; padding:10px; height: 300px; overflow-y: auto;">
        <!-- Pesan akan muncul di sini -->
    </div>

    <input type="text" id="message" placeholder="Ketik pesan..." />
    <button onclick="sendMessage()">Kirim</button>
    <div>
        {{ __(key: 'chat.users') }}
    </div>
    <div name="content">
        <a href="{{ route('change.lang', ['lang' => 'en']) }}">
            English
        </a>

        <a href="{{ route('change.lang', ['lang' => 'id']) }}">
            Indonesia
        </a>
    </div>

    @php($languages = ['en' => 'English', 'id' => 'Indonesia',])
    <div>Language: {{ $languages[Session::get('locale', 'en')] }}</div>

    <script>
        let userIds = {{ auth()->id() }};
        console.log("User ID:", userIds == 1 ? 2 : 1);

        async function sendMessage() {
            let message = document.getElementById('message').value;
            let receiverId = userIds == 1 ? 2 : 1;

            let response = await fetch("/api/messages/send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer {{ session('sanctum_token') }}`
                },
                body: JSON.stringify({
                    receiver_id: receiverId,
                    message: message
                })
            });

            
            console.log("Pesan terkirim:", response);
        }


        async function getMessage() {
            let message = document.getElementById('message').value;
            let receiverId = 2; // Ganti dengan ID user tujuan

            let response = await fetch(`/api/messages/${userIds}}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer {{ session('sanctum_token') }}`
                }

            });

            let data = await response.json();
            console.log("Pesan diterima:", data);
        }

        getMessage();

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let userId = {{ auth()->id() }};
            console.log("Laravel Echo:", window.Echo);

            window.Echo.channel(`chat.{{ auth()->id() }}`)
                .listen('MessageSent', (e) => {
                    console.log("Pesan baru diterima:", e.message);
                    let chatBox = document.getElementById('chat-box');
                    let newMessage = document.createElement('div');
                    newMessage.innerHTML = `<strong>${e.message.sender_id}:</strong> ${e.message.message}`;
                    chatBox.appendChild(newMessage);
                });

        });

    </script>

</body>

</html>