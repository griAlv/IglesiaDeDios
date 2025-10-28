<?php




define('CLOUDINARY_CLOUD_NAME', 'ddne5ennu'); // ✅ Nombre de la nube
define('CLOUDINARY_API_KEY', '583185233142238'); // ✅ Clave API
define('CLOUDINARY_API_SECRET', 'LHNSy4Ib6GLPvXrwL36WkDU3jUM'); // ✅ API Secret configurado
define('CLOUDINARY_UPLOAD_PRESET', 'himnos_preset'); // Preset para subidas (opcional)

define('CLOUDINARY_FOLDER', 'himnos'); // Carpeta donde se guardarán los himnos

/**
 * Función para subir un archivo de audio a Cloudinary
 * 
 * @param string $filePath Ruta del archivo local a subir
 * @param string $publicId ID público para el archivo (opcional)
 * @return array Respuesta de Cloudinary con la URL del archivo
 */
function subirAudioACloudinary($filePath, $publicId = null) {
    $cloudName = CLOUDINARY_CLOUD_NAME;
    $apiKey = CLOUDINARY_API_KEY;
    $apiSecret = CLOUDINARY_API_SECRET;
    $folder = CLOUDINARY_FOLDER;
    
    // Validar que el archivo existe
    if (!file_exists($filePath)) {
        return [
            'success' => false,
            'error' => 'El archivo no existe: ' . $filePath
        ];
    }
    
    // Preparar el archivo para la subida
    $timestamp = time();
    
    // Parámetros de la subida
    $params = [
        'timestamp' => $timestamp
    ];
    
    // Si se proporciona un public_id, agregarlo con la carpeta
    if ($publicId) {
        $params['public_id'] = $folder . '/' . $publicId;
    } else {
        $params['folder'] = $folder;
    }
    
    // Generar la firma (NO incluir resource_type en la firma)
    $paramsToSign = $params;
    ksort($paramsToSign);
    $signatureString = '';
    foreach ($paramsToSign as $key => $value) {
        $signatureString .= $key . '=' . $value . '&';
    }
    $signatureString = rtrim($signatureString, '&') . $apiSecret;
    $signature = sha1($signatureString);
    
    // Preparar los datos para el POST
    $postData = $params;
    $postData['api_key'] = $apiKey;
    $postData['signature'] = $signature;
    $postData['file'] = new CURLFile($filePath);
   
    $url = "https://api.cloudinary.com/v1_1/{$cloudName}/video/upload";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => 'Error de cURL: ' . $error
        ];
    }
    
    curl_close($ch);
    
    // Decodificar la respuesta
    $result = json_decode($response, true);
    
    if ($httpCode === 200 && isset($result['secure_url'])) {
        return [
            'success' => true,
            'url' => $result['secure_url'],
            'public_id' => $result['public_id'],
            'format' => $result['format'],
            'duration' => isset($result['duration']) ? $result['duration'] : null
        ];
    } else {
        return [
            'success' => false,
            'error' => isset($result['error']['message']) ? $result['error']['message'] : 'Error desconocido',
            'response' => $result
        ];
    }
}

/**
 * Función para eliminar un archivo de audio de Cloudinary
 * 
 * @param string $publicId ID público del archivo a eliminar
 * @return array Respuesta de Cloudinary
 */
function eliminarAudioDeCloudinary($publicId) {
    $cloudName = CLOUDINARY_CLOUD_NAME;
    $apiKey = CLOUDINARY_API_KEY;
    $apiSecret = CLOUDINARY_API_SECRET;
    
    $timestamp = time();
    
    $params = [
        'public_id' => $publicId,
        'timestamp' => $timestamp
    ];
    
    $paramsToSign = $params;
    ksort($paramsToSign);
    $signatureString = '';
    foreach ($paramsToSign as $key => $value) {
        $signatureString .= $key . '=' . $value . '&';
    }
    $signatureString = rtrim($signatureString, '&') . $apiSecret;
    $signature = sha1($signatureString);
    
    $postData = $params;
    $postData['api_key'] = $apiKey;
    $postData['signature'] = $signature;
    
    $url = "https://api.cloudinary.com/v1_1/{$cloudName}/video/destroy";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => 'Error de cURL: ' . $error
        ];
    }
    
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if ($httpCode === 200 && isset($result['result']) && $result['result'] === 'ok') {
        return [
            'success' => true,
            'message' => 'Archivo eliminado correctamente'
        ];
    } else {
        return [
            'success' => false,
            'error' => isset($result['error']['message']) ? $result['error']['message'] : 'Error desconocido',
            'response' => $result
        ];
    }
}
