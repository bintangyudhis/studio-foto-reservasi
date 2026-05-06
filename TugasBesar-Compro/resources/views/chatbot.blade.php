<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot - Sejenak Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal: #137887;
            --teal-dark: #0d6472;
            --cream: #fffaf0;
            --accent: #f7a900;
            --accent-soft: #ffc841;
            --line: rgba(19, 120, 135, .16);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            padding: clamp(18px, 5vw, 54px);
            background:
                radial-gradient(circle at 12% 88%, rgba(247,169,0,.28) 0 16%, transparent 16.5%),
                radial-gradient(circle at 88% 12%, rgba(247,169,0,.22) 0 12%, transparent 12.5%),
                linear-gradient(135deg, #f7fbfc 0%, #eef5f7 100%);
            color: var(--teal-dark);
            font-family: 'Manrope', sans-serif;
        }

        .chat-shell {
            width: min(100%, 980px);
            min-height: calc(100vh - clamp(36px, 10vw, 108px));
            display: grid;
            grid-template-columns: minmax(260px, .82fr) minmax(320px, 420px);
            align-items: center;
            gap: clamp(22px, 5vw, 54px);
            margin: auto;
        }

        .chat-intro .brand {
            font-family: 'Playfair Display', serif;
            font-size: clamp(48px, 8vw, 84px);
            font-style: italic;
            line-height: .95;
            margin-bottom: 22px;
        }

        .chat-intro p {
            max-width: 420px;
            color: #5d7d82;
            line-height: 1.8;
            margin-bottom: 28px;
        }

        .chat-intro a {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--accent);
            border-radius: 999px;
            color: var(--teal-dark);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .12em;
            padding: 13px 22px;
            text-decoration: none;
            text-transform: uppercase;
            transition: transform .2s ease, background .2s ease;
        }

        .chat-intro a:hover {
            background: var(--accent-soft);
            transform: translateY(-2px);
        }

        .chat-widget {
            width: min(100%, 420px);
            height: min(720px, calc(100vh - 72px));
            min-height: 580px;
            display: flex;
            flex-direction: column;
            justify-self: end;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(255,255,255,.72);
            border-radius: 24px;
            box-shadow: 0 28px 80px rgba(13, 100, 114, .18);
        }

        .chat-header {
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            padding: 15px 18px;
            background: var(--teal);
            color: white;
        }

        .back-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(255,255,255,.16);
            border-radius: 10px;
            color: white;
            font-size: 16px;
            line-height: 1;
            text-decoration: none;
        }

        .bot-avatar {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(255,255,255,.18);
            border-radius: 14px;
            color: white;
            font-size: 20px;
        }

        .bot-info h6 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 400;
        }

        .bot-info small {
            color: rgba(255,255,255,.78);
            font-size: 12px;
        }

        #chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
            padding: 20px 18px;
            background: #ffffff;
            scroll-behavior: smooth;
        }

        #chat-area::-webkit-scrollbar { width: 6px; }
        #chat-area::-webkit-scrollbar-thumb { background: rgba(19,120,135,.24); border-radius: 999px; }

        .msg-wrapper {
            display: flex;
            flex-direction: column;
            max-width: 78%;
            animation: fadeUp .2s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .msg-wrapper.user { align-self: flex-end; align-items: flex-end; }
        .msg-wrapper.bot { align-self: flex-start; align-items: flex-start; }

        .bubble {
            position: relative;
            padding: 10px 14px;
            border-radius: 16px;
            box-shadow: 0 8px 22px rgba(13,100,114,.08);
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .bubble.user-bubble {
            background: var(--teal);
            color: white;
            border-top-right-radius: 5px;
        }

        .bubble.bot-bubble {
            background: #fff7df;
            color: var(--teal-dark);
            border-top-left-radius: 5px;
        }

        .msg-time {
            color: #8ca2a6;
            font-size: 11px;
            margin-top: 2px;
            padding: 0 4px;
        }

        #typing-indicator {
            display: none;
            align-self: flex-start;
            background: #fff7df;
            border-radius: 16px;
            border-top-left-radius: 5px;
            padding: 10px 16px;
            box-shadow: 0 8px 22px rgba(13,100,114,.08);
            animation: fadeUp .2s ease;
        }

        .typing-dots {
            height: 18px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .typing-dots span {
            width: 7px;
            height: 7px;
            background: var(--teal);
            border-radius: 50%;
            animation: typing 1.2s infinite ease-in-out;
        }
        .typing-dots span:nth-child(2) { animation-delay: .2s; }
        .typing-dots span:nth-child(3) { animation-delay: .4s; }

        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
        }

        .date-separator {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 8px 0;
        }

        .date-separator span {
            background: #eef7f8;
            border-radius: 999px;
            color: #5d7d82;
            font-size: 12px;
            padding: 4px 11px;
        }

        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            flex-shrink: 0;
            padding: 10px 14px 8px;
            background: #ffffff;
            border-top: 1px solid rgba(19,120,135,.08);
        }

        .quick-reply-btn {
            background: white;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--teal-dark);
            cursor: pointer;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            padding: 6px 12px;
            transition: all .15s ease;
        }

        .quick-reply-btn:hover {
            background: var(--teal);
            color: white;
        }

        .chat-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            padding: 12px;
            background: #ffffff;
            border-top: 1px solid rgba(19,120,135,.12);
        }

        #msg-input {
            flex: 1;
            max-height: 100px;
            resize: none;
            background: #f8fbfb;
            border: 1px solid rgba(19,120,135,.12);
            border-radius: 16px;
            box-shadow: none;
            color: var(--teal-dark);
            font-family: 'Manrope', sans-serif;
            font-size: 14px;
            line-height: 1.4;
            outline: none;
            padding: 12px 16px;
        }

        #send-btn {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--accent);
            border: none;
            border-radius: 16px;
            color: var(--teal-dark);
            cursor: pointer;
            font-size: 18px;
            transition: background .2s ease, transform .2s ease;
        }

        #send-btn:hover { background: var(--accent-soft); }
        #send-btn:active { transform: scale(.95); }

        @media (max-width: 860px) {
            body {
                overflow: auto;
                padding: 16px;
            }

            .chat-shell {
                min-height: calc(100vh - 32px);
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .chat-intro {
                text-align: center;
            }

            .chat-intro p {
                margin-left: auto;
                margin-right: auto;
            }

            .chat-widget {
                justify-self: center;
                width: min(100%, 420px);
                height: min(650px, 72vh);
                min-height: 500px;
            }
        }

        @media (max-width: 520px) {
            body {
                padding: 0;
                background: #ffffff;
            }

            .chat-shell {
                min-height: 100vh;
                display: block;
            }

            .chat-intro {
                display: none;
            }

            .chat-widget {
                width: 100%;
                height: 100vh;
                min-height: 100vh;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .chat-header {
                padding-top: max(14px, env(safe-area-inset-top));
            }

            .msg-wrapper {
                max-width: 86%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-shell">
        <aside class="chat-intro">
            <div class="brand">Sejenak<br>Bot</div>
            <p>Tanyakan lokasi, jam buka, paket foto, cara reservasi, atau detail studio. Bot akan membantu sebelum kamu lanjut booking.</p>
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Kembali ke Home</a>
        </aside>

        <section class="chat-widget" aria-label="Chatbot Sejenak Studio">
            <div class="chat-header">
                <a href="{{ route('home') }}" class="back-btn" title="Kembali ke Home">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <div class="bot-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bot-info">
                    <h6>Sejenak Bot</h6>
                    <small id="bot-status">Online</small>
                </div>
            </div>

            <div id="chat-area">
                <div class="date-separator">
                    <span>Hari ini, {{ now()->translatedFormat('d F Y') }}</span>
                </div>

                <div class="msg-wrapper bot" id="welcome-msg">
                    <div class="bubble bot-bubble">
                        Halo! Saya <strong>Sejenak Bot</strong>, asisten virtual Sejenak Studio Purwokerto.<br><br>
                        Silakan tanyakan apa saja seputar studio kami. Saya siap membantu!
                    </div>
                    <span class="msg-time">{{ now()->format('H:i') }}</span>
                </div>

                <div id="typing-indicator">
                    <div class="typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>

            <div class="quick-replies" id="quick-replies">
                <button class="quick-reply-btn" onclick="sendQuick('Lokasi studio di mana?')">Lokasi</button>
                <button class="quick-reply-btn" onclick="sendQuick('Jam buka studio?')">Jam Buka</button>
                <button class="quick-reply-btn" onclick="sendQuick('Berapa harga paket foto?')">Harga</button>
                <button class="quick-reply-btn" onclick="sendQuick('Bagaimana cara reservasi?')">Reservasi</button>
                <button class="quick-reply-btn" onclick="sendQuick('Kontak sejenak studio')">Kontak</button>
            </div>

            <div class="chat-footer">
                <textarea
                    id="msg-input"
                    placeholder="Ketik pesan..."
                    rows="1"
                    autofocus
                ></textarea>
                <button id="send-btn" title="Kirim">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </section>
    </div>

    <script>
        const CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').content;
        const CHAT_URL    = "{{ route('chatbot.chat') }}";
        const chatArea    = document.getElementById('chat-area');
        const msgInput    = document.getElementById('msg-input');
        const sendBtn     = document.getElementById('send-btn');
        const typingEl    = document.getElementById('typing-indicator');
        const botStatus   = document.getElementById('bot-status');

        function appendMessage(text, sender) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('msg-wrapper', sender);

            const bubble = document.createElement('div');
            bubble.classList.add('bubble', sender === 'user' ? 'user-bubble' : 'bot-bubble');
            bubble.textContent = text;

            const time = document.createElement('span');
            time.classList.add('msg-time');
            time.textContent = getCurrentTime();

            wrapper.appendChild(bubble);
            wrapper.appendChild(time);
            chatArea.insertBefore(wrapper, typingEl);
            scrollToBottom();
        }

        function showTyping() {
            typingEl.style.display = 'block';
            botStatus.textContent = 'sedang mengetik...';
            scrollToBottom();
        }

        function hideTyping() {
            typingEl.style.display = 'none';
            botStatus.textContent = 'Online';
        }

        async function sendMessage() {
            const text = msgInput.value.trim();
            if (!text) return;

            appendMessage(text, 'user');
            msgInput.value = '';
            autoResize();
            msgInput.disabled = true;
            sendBtn.disabled = true;
            showTyping();
            document.getElementById('quick-replies').style.display = 'none';

            try {
                const response = await fetch(CHAT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                await sleep(600 + Math.random() * 500);

                hideTyping();
                appendMessage(data.reply, 'bot');
            } catch (error) {
                hideTyping();
                appendMessage('Maaf, terjadi gangguan koneksi. Silakan coba lagi.', 'bot');
                console.error('Chatbot error:', error);
            } finally {
                msgInput.disabled = false;
                sendBtn.disabled = false;
                msgInput.focus();
            }
        }

        function sendQuick(text) {
            msgInput.value = text;
            sendMessage();
        }

        function scrollToBottom() {
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function getCurrentTime() {
            const now = new Date();
            return now.getHours().toString().padStart(2, '0') + ':' +
                   now.getMinutes().toString().padStart(2, '0');
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function autoResize() {
            msgInput.style.height = 'auto';
            msgInput.style.height = Math.min(msgInput.scrollHeight, 100) + 'px';
        }

        sendBtn.addEventListener('click', sendMessage);

        msgInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        msgInput.addEventListener('input', autoResize);
        scrollToBottom();
    </script>
</body>
</html>
