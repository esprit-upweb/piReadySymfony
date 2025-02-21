from flask import Flask, request, jsonify
from flask_cors import CORS
from deep_translator import GoogleTranslator

app = Flask(__name__)
CORS(app)  


SUPPORTED_LANGUAGES = ['en', 'fr', 'es', 'de', 'ar', 'zh'] 
@app.route('/translate', methods=['POST'])
def translate():
    data = request.json
    texts = data.get('texts', [])
    target_language = data.get('target_language', 'fr')
    
    if not texts:
        return jsonify({'error': 'No texts provided'}), 400
    
    if target_language not in SUPPORTED_LANGUAGES:
        return jsonify({'error': f'Unsupported target language: {target_language}'}), 400
    
    translated_texts = []
    for text in texts:
        if text:
            translated_text = GoogleTranslator(source='auto', target=target_language).translate(text)
            translated_texts.append(translated_text)
        else:
            translated_texts.append('')
    
    return jsonify({'translated_texts': translated_texts})

if __name__ == '__main__':
    app.run(debug=True)