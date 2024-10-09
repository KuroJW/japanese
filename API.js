async function convertToHiragana(sentence, requestId = null) {
    const url = "https://labs.goo.ne.jp/api/hiragana";
    const appId = "0de8fb3ddf098754d404feaa15cca6442967a4af5882351875c244f5a3ff335b";

    // Dados da requisição
    const data = {
        app_id: appId,
        sentence: sentence,
        output_type: 'hiragana'
    };

    // Adiciona o requestId se fornecido
    if (requestId) {
        data.request_id = requestId;
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const httpCode = response.status;
        
        // Verifica se a requisição foi bem-sucedida
        if (httpCode === 200) {
            const result = await response.json();
            return result;
        } else {
            return {
                error: `Erro na requisição: HTTP status ${httpCode}`,
                response: await response.text(),
            };
        }
    } catch (error) {
        return {
            error: `Erro na requisição: ${error.message}`,
        };
    }
}

const btn = document.getElementById('Pesquisar-kanji')
const input = document.getElementById('Kanji');

// Exemplo de uso

btn.addEventListener("click",() => {
    event.preventDefault();
    let sentence = input.value;
    convertToHiragana(sentence).then(result => document.getElementById("Src_output").innerHTML = (result.converted));
    setTimeout(() => 
        {
            document.getElementById('Src_input').innerHTML = document.getElementById('Kanji').value;
        }, 1400);
})
