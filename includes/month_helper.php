<?php
/**
 * Ay yardımcı fonksiyonları
 */

/**
 * Seçili ayı al
 */
function getSelectedMonthKey() {
    return $_SESSION['selected_month'] ?? date('m.y');
}

/**
 * Ay seçeneklerini oluştur
 */
function generateMonthOptions($selected_month = null) {
    if (!$selected_month) {
        $selected_month = getSelectedMonthKey();
    }
    
    $months = [];
    $current_year = date('Y');
    $current_month = date('m');
    
    // Geçmiş 6 ay ve gelecek 6 ay
    for ($i = -6; $i <= 6; $i++) {
        $month_num = $current_month + $i;
        $year = $current_year;
        
        if ($month_num > 12) {
            $month_num -= 12;
            $year++;
        } elseif ($month_num < 1) {
            $month_num += 12;
            $year--;
        }
        
        $month_key = sprintf('%02d.%02d', $month_num, $year % 100);
        $month_name = getMonthName($month_num);
        $year_name = $year;
        
        $months[$month_key] = "$month_name $year_name";
    }
    
    $html = '';
    foreach ($months as $key => $name) {
        $selected = ($key === $selected_month) ? 'selected' : '';
        $html .= "<option value=\"$key\" $selected>$name</option>";
    }
    
    return $html;
}

/**
 * Ay adını al
 */
function getMonthName($month_num) {
    $months = [
        1 => 'Ocak',
        2 => 'Şubat',
        3 => 'Mart',
        4 => 'Nisan',
        5 => 'Mayıs',
        6 => 'Haziran',
        7 => 'Temmuz',
        8 => 'Ağustos',
        9 => 'Eylül',
        10 => 'Ekim',
        11 => 'Kasım',
        12 => 'Aralık'
    ];
    
    return $months[$month_num] ?? 'Bilinmeyen';
}

/**
 * Kategori tipi rengini al
 */
function getKategoriTipiColor($kategori_tipi) {
    $colors = [
        'Sabit Giderler' => '#ff6b6b',
        'Değişken Giderler' => '#4ecdc4',
        'Ani/Ekstra Harcama' => '#45b7d1',
        'Alınacak Ürünler' => '#96ceb4',
        'İhtiyaçlar' => '#feca57',
        'İstek Listesi' => '#ff9ff3',
        'Favori Ürünler' => '#54a0ff',
        'Hayaller ve Hedefler' => '#5f27cd',
        'Borç Ödemeleri' => '#45b7d1',
        'Ertelenen Ödemeler' => '#ff9ff3',
        'Diğer' => '#8395a7'
    ];
    
    return $colors[$kategori_tipi] ?? '#8395a7';
}

/**
 * Kategori tipi kısa adını döndüren fonksiyon
 */
function getKategoriTipiShort($kategori_tipi) {
    $shorts = [
        'Sabit Giderler' => 'Sabit',
        'Değişken Giderler' => 'Değişken',
        'Borç Ödemeleri' => 'Borç',
        'Alınacak Ürünler' => 'Alınacaklar',
        'Ani/Ekstra Harcama' => 'Ani/Ekstra',
        'Ertelenen Ödemeler' => 'Ertelenen',
        'İhtiyaçlar' => 'İhtiyaç',
        'İstek Listesi' => 'İstek',
        'Favori Ürünler' => 'Favori',
        'Hayaller ve Hedefler' => 'Hayal/Hedef'
    ];
    
    return $shorts[$kategori_tipi] ?? 'Diğer';
}

/**
 * Para formatı
 */
function formatCurrency($amount, $currency = '₺') {
    return $currency . number_format($amount, 2, ',', '.');
}

/**
 * Tarih formatı
 */
function formatDate($date, $format = 'd.m.Y') {
    return date($format, strtotime($date));
}

/**
 * Durum badge rengi
 */
function getStatusColor($status) {
    $colors = [
        'Beklemede' => 'warning',
        'Devam Ediyor' => 'info',
        'Tamamlandı' => 'success',
        'İptal Edildi' => 'danger',
        'Gecikmiş' => 'danger',
        'Planlandı' => 'primary',
        'Ödendi' => 'success'
    ];
    
    return $colors[$status] ?? 'secondary';
}

/**
 * CSRF token doğrulama
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Güvenli string temizleme
 */
function sanitize_string($string) {
    return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
}

/**
 * Dosya boyutu formatı
 */
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, 2) . ' ' . $units[$i];
}

/**
 * Zaman önce formatı
 */
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) {
        return 'Az önce';
    } elseif ($time < 3600) {
        $minutes = floor($time / 60);
        return $minutes . ' dakika önce';
    } elseif ($time < 86400) {
        $hours = floor($time / 3600);
        return $hours . ' saat önce';
    } elseif ($time < 2592000) {
        $days = floor($time / 86400);
        return $days . ' gün önce';
    } else {
        return date('d.m.Y', strtotime($datetime));
    }
}

/**
 * Rastgele string oluştur
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $string;
}

/**
 * Email doğrulama
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * URL doğrulama
 */
function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Telefon numarası formatı
 */
function formatPhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) === 10) {
        return substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 2) . ' ' . substr($phone, 8, 2);
    } elseif (strlen($phone) === 11) {
        return substr($phone, 0, 1) . ' ' . substr($phone, 1, 3) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 2) . ' ' . substr($phone, 9, 2);
    }
    
    return $phone;
}
 