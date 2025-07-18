<?php

namespace App\Models;

class UIHelper {

    /**
     * Generates a form input field.
     *
     * @param string $label The label for the input.
     * @param string $name The name and id for the input.
     * @param string $type The input type (e.g., 'text', 'number', 'password').
     * @param bool $required Whether the input is required.
     * @param string $value The default value for the input.
     * @param string $placeholder The placeholder text.
     * @return string The HTML for the form input.
     */
    public static function render_input($label, $name, $type = 'text', $required = true, $value = '', $placeholder = '', $options = [], $min = null) {
        $html = '<div class="mb-3">';
        $html .= '    <label for="' . $name . '" class="form-label">' . htmlspecialchars($label) . '</label>';

        if ($type === 'textarea') {
            $html .= '    <textarea class="form-control" id="' . $name . '" name="' . $name . '" ';
            if ($required) {
                $html .= 'required ';
            }
            if ($placeholder) {
                $html .= 'placeholder="' . htmlspecialchars($placeholder) . '" ';
            }
            $html .= '>' . htmlspecialchars($value) . '</textarea>';
        } elseif ($type === 'select') {
            $html .= '    <select class="form-select" id="' . $name . '" name="' . $name . '" ';
            if ($required) {
                $html .= 'required';
            }
            $html .= '>';
            foreach ($options as $option) {
                $selected = ($option['value'] == $value) ? ' selected' : '';
                $html .= '        <option value="' . htmlspecialchars($option['value']) . '"' . $selected . '>' . htmlspecialchars($option['text']) . '</option>';
            }
            $html .= '    </select>';
        } else {
            $html .= '    <input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" ';
            if ($required) {
                $html .= 'required ';
            }
            if ($placeholder) {
                $html .= 'placeholder="' . htmlspecialchars($placeholder) . '" ';
            }
            if ($min !== null) {
                $html .= 'min="' . htmlspecialchars($min) . '" ';
            }
            $html .= 'value="' . htmlspecialchars($value) . '">';
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Generates a modal window.
     *
     * @param string $id The ID for the modal.
     * @param string $title The title of the modal.
     * @param string $form_id The ID for the form inside the modal.
     * @param string $body_html The HTML content for the modal body (usually form fields).
     * @param string $footer_html The HTML content for the modal footer (usually buttons).
     * @return string The HTML for the modal.
     */
    public static function render_modal($id, $title, $form_id, $body_html, $footer_html) {
        $html = '<div class="modal fade" id="' . $id . '" tabindex="-1" aria-labelledby="' . $id . 'Label" aria-hidden="true">';
        $html .= '    <div class="modal-dialog">';
        $html .= '        <div class="modal-content">';
        $html .= '            <div class="modal-header">';
        $html .= '                <h5 class="modal-title" id="' . $id . 'Label">' . htmlspecialchars($title) . '</h5>';
        $html .= '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $html .= '            </div>';
        $html .= '            <form id="' . $form_id . '">';
        $html .= '                <div class="modal-body">';
        $html .= $body_html;
        $html .= '                </div>';
        $html .= '                <div class="modal-footer">';
        $html .= $footer_html;
        $html .= '                </div>';
        $html .= '            </form>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }

    public static function getSelectedMonthKey() {
        return $_SESSION['selected_month'] ?? date('m.y');
    }

    public static function generateMonthOptions($selected_month = null) {
        if (!$selected_month) {
            $selected_month = self::getSelectedMonthKey();
        }
        
        $months = [];
        $current_year = date('Y');
        $current_month = date('m');
        
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
            $month_name = self::getMonthName($month_num);
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

    public static function getMonthName($month_num) {
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

    public static function getKategoriTipiColor($kategori_tipi) {
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

    public static function getKategoriTipiShort($kategori_tipi) {
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

    public static function formatCurrency($amount, $currency = '₺') {
        return $currency . number_format($amount, 2, ',', '.');
    }

    public static function formatDate($date, $format = 'd.m.Y') {
        return date($format, strtotime($date));
    }

    public static function getStatusColor($status) {
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

    public static function verify_csrf_token($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function sanitize_string($string) {
        return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
    }

    public static function formatFileSize($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function timeAgo($datetime) {
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

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $string;
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function formatPhoneNumber($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (strlen($phone) === 10) {
            return substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 2) . ' ' . substr($phone, 8, 2);
        } elseif (strlen($phone) === 11) {
            return substr($phone, 0, 1) . ' ' . substr($phone, 1, 3) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 2) . ' ' . substr($phone, 9, 2);
        }
        
        return $phone;
    }
}