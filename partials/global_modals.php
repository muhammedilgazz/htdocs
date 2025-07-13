<?php

require_once __DIR__ . '/UIHelper.php';
require_once __DIR__ . '/../classes/Expense.php';
require_once __DIR__ . '/../classes/Payment.php';
require_once __DIR__ . '/../classes/Account.php';
require_once __DIR__ . '/../classes/Iban.php';
require_once __DIR__ . '/../classes/DreamGoal.php';
require_once __DIR__ . '/../classes/Note.php';
require_once __DIR__ . '/../classes/Todo.php';
require_once __DIR__ . '/../classes/Income.php';

// Bu dosya, her sayfada kullanılacak global modalları içerir.
// $csrf_token ve $selected_month gibi değişkenlerin bu dosya dahil edildiğinde mevcut olduğu varsayılır.

// Ödeme Ekleme Modal
$add_payment_modal_body = '';
$add_payment_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_payment_modal_body .= UIHelper::render_input('Kişi Adı', 'kisi_adi');
$add_payment_modal_body .= UIHelper::render_input('Tutar', 'tutar', 'number', true, '', '', [], 0.01);

$add_payment_modal_footer = '<button type="button" class="btn btn-outlined" data-bs-dismiss="modal">İptal</button>';
$add_payment_modal_footer .= '<button type="submit" class="btn btn-success">Ödeme Ekle</button>';

echo UIHelper::render_modal('addPaymentModal', 'Ödeme Ekle', 'addPaymentForm', $add_payment_modal_body, $add_payment_modal_footer);

// Harcama Ekle Modal (İhtiyaç Ekleme için de kullanılır)
$add_harcama_modal_body = '';
$add_harcama_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_harcama_modal_body .= '<input type="hidden" name="kategori_tipi" value="Alınacak Ürünler">';
$add_harcama_modal_body .= UIHelper::render_input('Kategori', 'kategori', 'text', true, 'İhtiyaç');
$add_harcama_modal_body .= UIHelper::render_input('Harcama Dönemi', 'harcama_donemi', 'select', true, $selected_month, '', [
    ['value' => '07.25', 'text' => 'Temmuz 2025'],
    ['value' => '08.25', 'text' => 'Ağustos 2025'],
    ['value' => '09.25', 'text' => 'Eylül 2025'],
]);
$add_harcama_modal_body .= UIHelper::render_input('Aylık / Tek Seferlik', 'tur', 'select', true, 'Tek Seferlik', '', [
    ['value' => 'Tek Seferlik', 'text' => 'Tek Seferlik'],
    ['value' => 'Aylık', 'text' => 'Aylık'],
]);
$add_harcama_modal_body .= UIHelper::render_input('Sıra No (Öncelik)', 'sira', 'number', true, '1', '', [], 1);
$add_harcama_modal_body .= UIHelper::render_input('İhtiyaç adı', 'urun', 'text', true, '', 'Örn: Gıda, Temizlik, Giyim');
$add_harcama_modal_body .= UIHelper::render_input('Tutar (₺)', 'tutar', 'number', true, '', '', [], 0.01);
$add_harcama_modal_body .= UIHelper::render_input('Link (Opsiyonel)', 'link', 'url', false);
$add_harcama_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'aciklama', 'textarea', false);
$add_harcama_modal_body .= UIHelper::render_input('Durum', 'durum', 'select', true, 'Beklemede', '', [
    ['value' => 'Beklemede', 'text' => 'Beklemede'],
    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
]);

$add_harcama_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_harcama_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('harcamaEkleModal', 'Yeni İhtiyaç Ekle', 'harcamaEkleForm', $add_harcama_modal_body, $add_harcama_modal_footer);

// IBAN Ekle Modal
$add_iban_modal_body = '';
$add_iban_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_iban_modal_body .= UIHelper::render_input('Banka Adı', 'banka_adi');
$add_iban_modal_body .= UIHelper::render_input('IBAN Numarası', 'iban_no');
$add_iban_modal_body .= UIHelper::render_input('Hesap Sahibi', 'hesap_sahibi');
$add_iban_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'aciklama', 'textarea', false);

$add_iban_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_iban_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('addIbanModal', 'Yeni IBAN Ekle', 'addIbanForm', $add_iban_modal_body, $add_iban_modal_footer);

// Hesap Ekle Modal
$add_hesap_modal_body = '';
$add_hesap_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_hesap_modal_body .= UIHelper::render_input('Platform/Site Adı', 'platform');
$add_hesap_modal_body .= UIHelper::render_input('Kullanıcı Adı', 'kullanici_adi');
$add_hesap_modal_body .= UIHelper::render_input('Şifre', 'sifre', 'password');
$add_hesap_modal_body .= UIHelper::render_input('Giriş Linki (Opsiyonel)', 'giris_linki', 'url', false);
$add_hesap_modal_body .= UIHelper::render_input('Hesap Türü', 'hesap_turu', 'select', true, '', '', [
    ['value' => '', 'text' => 'Hesap türünü seçin'],
    ['value' => 'İnternet Bankacılığı', 'text' => 'İnternet Bankacılığı'],
    ['value' => 'Mail', 'text' => 'Mail'],
    ['value' => 'Sosyal Medya', 'text' => 'Sosyal Medya'],
    ['value' => 'Bahis Sitesi', 'text' => 'Bahis Sitesi'],
    ['value' => 'E-ticaret', 'text' => 'E-ticaret'],
    ['value' => 'Eğitim', 'text' => 'Eğitim'],
    ['value' => 'İş', 'text' => 'İş'],
    ['value' => 'Diğer', 'text' => 'Diğer'],
]);

$add_hesap_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_hesap_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('addHesapModal', 'Yeni Hesap Ekle', 'addHesapForm', $add_hesap_modal_body, $add_hesap_modal_footer);

// Hayal/Hedef Ekle Modal
$add_dream_goal_modal_body = '';
$add_dream_goal_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_dream_goal_modal_body .= UIHelper::render_input('Başlık', 'baslik');
$add_dream_goal_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'aciklama', 'textarea', false);
$add_dream_goal_modal_body .= UIHelper::render_input('Hedef Tutar (₺)', 'hedef_tutar', 'number', true, '', '', [], 0.01);
$add_dream_goal_modal_body .= UIHelper::render_input('Mevcut Tutar (₺)', 'mevcut_tutar', 'number', false, '0', '', [], 0.01);
$add_dream_goal_modal_body .= UIHelper::render_input('Durum', 'durum', 'select', true, 'Beklemede', '', [
    ['value' => 'Beklemede', 'text' => 'Beklemede'],
    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
]);
$add_dream_goal_modal_body .= UIHelper::render_input('Hedef Tarih (Opsiyonel)', 'hedef_tarih', 'date', false);

$add_dream_goal_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_dream_goal_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('addHayalHedefModal', 'Yeni Hayal/Hedef Ekle', 'addHayalHedefForm', $add_dream_goal_modal_body, $add_dream_goal_modal_footer);

// Not Ekle Modal
$add_note_modal_body = '';
$add_note_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_note_modal_body .= UIHelper::render_input('Başlık', 'baslik');
$add_note_modal_body .= UIHelper::render_input('İçerik', 'icerik', 'textarea');

$add_note_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_note_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('addNoteModal', 'Yeni Not Ekle', 'addNoteForm', $add_note_modal_body, $add_note_modal_footer);

// To-Do Ekle Modal
$add_todo_modal_body = '';
$add_todo_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_todo_modal_body .= UIHelper::render_input('Görev', 'gorev');
$add_todo_modal_body .= UIHelper::render_input('Durum', 'durum', 'select', true, 'Beklemede', '', [
    ['value' => 'Beklemede', 'text' => 'Beklemede'],
    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
]);
$add_todo_modal_body .= UIHelper::render_input('Son Tarih (Opsiyonel)', 'son_tarih', 'date', false);

$add_todo_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_todo_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('addTodoModal', 'Yeni To-Do Ekle', 'addTodoForm', $add_todo_modal_body, $add_todo_modal_footer);

// Gelir Ekle Modal
$add_income_modal_body = '';
$add_income_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_income_modal_body .= UIHelper::render_input('Kaynak', 'kaynak');
$add_income_modal_body .= UIHelper::render_input('Tutar (₺)', 'tutar', 'number', true, '', '', [], 0.01);
$add_income_modal_body .= UIHelper::render_input('Tarih', 'tarih', 'date', true, date('Y-m-d'));
$add_income_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'aciklama', 'textarea', false);

$add_income_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
$add_income_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

echo UIHelper::render_modal('addIncomeModal', 'Yeni Gelir Ekle', 'addIncomeForm', $add_income_modal_body, $add_income_modal_footer);
?>