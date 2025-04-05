from flask import Flask, render_template, request, jsonify
from openai import OpenAI

app = Flask(__name__)
client = OpenAI(base_url="http://192.168.200.1:1234/v1", api_key="lm-studio")


conversation_history = []

@app.route('/a1')
def home():
    return render_template('index.html')

@app.route('/ask', methods=['POST'])
def ask_question():
    global conversation_history
    
    user_input = request.json['question']
    
    # 更新对话历史
    conversation_history.append({"role": "user", "content": user_input})
    
    try:
        response = client.chat.completions.create(
            model="local-model",
            messages=conversation_history,
            temperature=1.0,
        )
        
        ai_response = response.choices[0].message.content
        conversation_history.append({"role": "assistant", "content": ai_response})
        
        return jsonify({
            "status": "success",
            "answer": ai_response
        })
        
    except Exception as e:
        return jsonify({
            "status": "error",
            "message": str(e)
        }), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)