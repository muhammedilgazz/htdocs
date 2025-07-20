<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

try {
    // Cache dosyası yolu
    $cache_file = '../cache/exchange_rate.json';
    $cache_duration = 300; // 5 dakika
    
    // Cache kontrolü
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_duration) {
        $cached_data = json_decode(file_get_contents($cache_file), true);
        if ($cached_data && isset($cached_data['rate'])) {
            json_response([
                'success' => true,
                'rate' => $cached_data['rate'],
                'last_update' => $cached_data['last_update'],
                'cached' => true
            ]);
            exit;
        }
    }
    
    // API'den veri çek
    $api_url = 'https://api.exchangerate-api.com/v4/latest/USD';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code !== 200 || !$response) {
        // Fallback: Sabit değer kullan
        $fallback_rate = 32.50;
        $cache_data = [
            'rate' => $fallback_rate,
            'last_update' => date('Y-m-d H:i:s'),
            'source' => 'fallback'
        ];
        
        // Cache dizinini oluştur
        if (!is_dir('../cache')) {
            mkdir('../cache', 0755, true);
        }
        
        file_put_contents($cache_file, json_encode($cache_data));
        
        json_response([
            'success' => true,
            'rate' => $fallback_rate,
            'last_update' => date('Y-m-d H:i:s'),
            'cached' => false,
            'note' => 'API erişilemedi, varsayılan değer kullanıldı'
        ]);
        exit;
    }
    
    $data = json_decode($response, true);
    
    if (!$data || !isset($data['rates']['TRY'])) {
        throw new Exception('API yanıtı geçersiz');
    }
    
    $rate = $data['rates']['TRY'];
    $last_update = $data['date'] ?? date('Y-m-d');
    
    // Cache'e kaydet
    $cache_data = [
        'rate' => $rate,
        'last_update' => $last_update,
        'source' => 'api'
    ];
    
    // Cache dizinini oluştur
    if (!is_dir('../cache')) {
        mkdir('../cache', 0755, true);
    }
    
    file_put_contents($cache_file, json_encode($cache_data));
    
    json_response([
        'success' => true,
        'rate' => $rate,
        'last_update' => $last_update,
        'cached' => false
    ]);
    
} catch (Exception $e) {
    error_log('Exchange rate error: ' . $e->getMessage());
    
    // Hata durumunda varsayılan değer döndür
    json_response([
        'success' => true,
        'rate' => 32.50,
        'last_update' => date('Y-m-d H:i:s'),
        'cached' => false,
        'note' => 'Hata oluştu, varsayılan değer kullanıldı'
    ]);
}
?> 