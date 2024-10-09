<?php

function convertToHiragana($sentence, $request_id = null) {
    $url = "https://labs.goo.ne.jp/api/hiragana";
    $app_id = "0de8fb3ddf098754d404feaa15cca6442967a4af5882351875c244f5a3ff335b";

    // Dados da requisição
    $data = [
        'app_id' => $app_id,
        'sentence' => $sentence,
        'output_type' => 'hiragana'
    ];

    // Adiciona o request_id se fornecido
    if ($request_id) {
        $data['request_id'] = $request_id;
    }

    // Inicializa cURL
    $ch = curl_init($url);

    // Configura as opções do cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executa a requisição
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Fecha a conexão cURL
    curl_close($ch);

    // Verifica se a requisição foi bem-sucedida
    if ($http_code === 200) {
        return json_decode($response, true);
    } else {
        return [
            'error' => "Erro na requisição: HTTP status $http_code",
            'response' => $response,
        ];
    }
}

// Exemplo de uso
$sentence = "学校";
$result = convertToHiragana($sentence);

echo "<pre>";
print_r($result);
echo "</pre>";
?>
