document.addEventListener('DOMContentLoaded', () => {
    const chatHistory = document.getElementById('chat-history');
    const userInput = document.getElementById('user-input');
    const sendBtn = document.getElementById('send-btn');

    function addMessage(content, isUser = true) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
        messageDiv.textContent = content;
        chatHistory.appendChild(messageDiv);
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }

    async function sendQuestion() {
        const question = userInput.value.trim();
        if (!question) return;

        addMessage(question, true);
        userInput.value = '';
        sendBtn.disabled = true;

        try {
            const response = await fetch('/ask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ question })
            });

            const data = await response.json();
            if (data.status === 'success') {
                addMessage(data.answer, false);
            } else {
                addMessage(`错误：${data.message}`, false);
            }
        } catch (error) {
            addMessage('请求失败，请检查网络连接', false);
        } finally {
            sendBtn.disabled = false;
        }
    }

    sendBtn.addEventListener('click', sendQuestion);
    
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendQuestion();
        }
    });
});