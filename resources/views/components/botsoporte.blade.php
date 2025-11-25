<!-- Bot flotante (frontend simulado) -->
<div id="chatbot" class="chatbot">
  <div class="chat-header">
    <span>🤖 Asistente MercaJusto</span>
    <button onclick="toggleChat()">&times;</button>
  </div>
  <div class="chat-body">
    <div class="chat-msg bot">Hola, ¿En qué puedo ayudarte hoy?</div>
  </div>
  <div class="chat-input">
    <input type="text" id="userMsg" placeholder="Escribe tu mensaje..." onkeydown="if(event.key==='Enter'){sendMsg()}" />
    <button onclick="sendMsg()">Enviar</button>
  </div>
</div>
<button class="chat-toggle" onclick="toggleChat()">💬?</button>




<style>
.chatbot {
  position: fixed;
  bottom: 145px;
  right: 20px;
  width: 300px;
  max-height: 400px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  display: none;
  flex-direction: column;
  overflow: hidden;
  z-index: 1000;
}

.chat-header {
  background: #d40f0f;
  color: white;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  font-weight: bold;
}

.chat-body {
  padding: 10px;
  flex: 1;
  overflow-y: auto;
  font-size: 14px;
}

.chat-input {
  display: flex;
  border-top: 1px solid #ccc;
}
.chat-input input {
  flex: 1;
  padding: 8px;
  border: none;
}
.chat-input button {
  padding: 8px 12px;
  background: #d40f0f;
  color: white;
  border: none;
}
.chat-toggle {
  position: fixed;
  bottom: 80px;
  right: 20px;
  background: #d40f0f;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 50%;
  cursor: pointer;
  font-size: 20px;
  z-index: 1000;
}
.chat-msg.bot {
  background: #eee;
  padding: 5px 10px;
  margin-bottom: 5px;
  border-radius: 8px;
  width: fit-content;
}


</style>

<script>
function toggleChat() {
  const chat = document.getElementById('chatbot');
  chat.style.display = chat.style.display === 'flex' ? 'none' : 'flex';
}

function sendMsg() {
  const input = document.getElementById('userMsg');
  const msg = input.value.trim();
  if (!msg) return;

  const msgBox = document.createElement('div');
  msgBox.className = 'chat-msg bot';
  msgBox.textContent = `¡Gracias por tu mensaje! Pronto te responderemos.`;
  document.querySelector('.chat-body').appendChild(msgBox);
  input.value = '';
}

function toggleFaq(elem) {
  const answer = elem.nextElementSibling;
  answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
}
</script>
