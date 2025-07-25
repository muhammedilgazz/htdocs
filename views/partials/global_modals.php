<!-- İhtiyaç Ekle Modal -->
<div class="modal fade" id="addIhtiyacModal" tabindex="-1" aria-labelledby="addIhtiyacModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addIhtiyacForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIhtiyacModalLabel">İhtiyaç Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">İhtiyaç Adı</label>
                        <input type="text" class="form-control" name="ihtiyac_adi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="İhtiyaçlar">İhtiyaçlar</option>
                            <option value="İstek Listesi">İstek Listesi</option>
                            <option value="Favori Ürünler">Favori Ürünler</option>
                            <option value="Hayaller ve Hedefler">Hayaller ve Hedefler</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tutar</label>
                        <input type="number" class="form-control" name="tutar" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" class="form-control" name="link">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Öncelik</label>
                        <select class="form-select" name="oncelik" required>
                            <option value="Düşük">Düşük</option>
                            <option value="Orta">Orta</option>
                            <option value="Yüksek">Yüksek</option>
                            <option value="Acil">Acil</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- İban Ekle Modal -->
<div class="modal fade" id="addIbanModal" tabindex="-1" aria-labelledby="addIbanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addIbanForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIbanModalLabel">İban Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Banka Adı</label>
                        <input type="text" class="form-control" name="banka_adi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">IBAN</label>
                        <input type="text" class="form-control" name="iban" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hesap Sahibi</label>
                        <input type="text" class="form-control" name="hesap_sahibi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hesap Ekle Modal -->
<div class="modal fade" id="addHesapModal" tabindex="-1" aria-labelledby="addHesapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addHesapForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHesapModalLabel">Hesap Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Platform/Site Adı</label>
                        <input type="text" class="form-control" name="platform_adi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" name="kullanici_adi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Şifre</label>
                        <input type="password" class="form-control" name="sifre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-posta</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="url" class="form-control" name="url">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hayal/Hedef Ekle Modal -->
<div class="modal fade" id="addHayalHedefModal" tabindex="-1" aria-labelledby="addHayalHedefModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addHayalHedefForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHayalHedefModalLabel">Hayal/Hedef Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" class="form-control" name="baslik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tür</label>
                        <select class="form-select" name="tur" required>
                            <option value="Hayal">Hayal</option>
                            <option value="Hedef">Hedef</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tutar</label>
                        <input type="number" class="form-control" name="tutar" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hedef Tarih</label>
                        <input type="date" class="form-control" name="hedef_tarih">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" class="form-control" name="link">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Harcama Ekleme Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addExpenseForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExpenseModalLabel">Harcama Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="">Kategori Seçin</option>
                            <option value="Food">Yemek</option>
                            <option value="Transport">Ulaşım</option>
                            <option value="Healthcare">Sağlık</option>
                            <option value="Education">Eğitim</option>
                            <option value="Entertainment">Eğlence</option>
                            <option value="Shopping">Alışveriş</option>
                            <option value="Bills">Faturalar</option>
                            <option value="Other">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <input type="text" class="form-control" name="urun" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tutar</label>
                        <input type="number" class="form-control" name="tutar" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarih</label>
                        <input type="date" class="form-control" name="tarih" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Harcama Ekle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hızlı İşlemler Modals -->

<!-- Not Ekle Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addNoteForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Not Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" class="form-control" name="baslik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="Genel">Genel</option>
                            <option value="Finansal">Finansal</option>
                            <option value="Kişisel">Kişisel</option>
                            <option value="İş">İş</option>
                            <option value="Alışveriş">Alışveriş</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Not İçeriği</label>
                        <textarea class="form-control" name="icerik" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Öncelik</label>
                        <select class="form-select" name="oncelik">
                            <option value="Düşük">Düşük</option>
                            <option value="Orta">Orta</option>
                            <option value="Yüksek">Yüksek</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- To-Do Ekle Modal -->
<div class="modal fade" id="addTodoModal" tabindex="-1" aria-labelledby="addTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addTodoForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTodoModalLabel">To-Do Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Görev Başlığı</label>
                        <input type="text" class="form-control" name="baslik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="Kişisel">Kişisel</option>
                            <option value="İş">İş</option>
                            <option value="Finansal">Finansal</option>
                            <option value="Sağlık">Sağlık</option>
                            <option value="Eğitim">Eğitim</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" name="bitis_tarihi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Öncelik</label>
                        <select class="form-select" name="oncelik" required>
                            <option value="Düşük">Düşük</option>
                            <option value="Orta">Orta</option>
                            <option value="Yüksek">Yüksek</option>
                            <option value="Acil">Acil</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Gelir Ekle Modal -->
<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addIncomeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIncomeModalLabel">Gelir Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Gelir Kaynağı</label>
                        <input type="text" class="form-control" name="kaynak" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" required>
                            <option value="Maaş">Maaş</option>
                            <option value="Freelance">Freelance</option>
                            <option value="Yatırım">Yatırım</option>
                            <option value="Kira Geliri">Kira Geliri</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tutar</label>
                        <input type="number" class="form-control" name="tutar" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarih</label>
                        <input type="date" class="form-control" name="tarih" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" name="aciklama" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rapor Oluştur Modals -->

<!-- Aylık Ödeme Raporu Modal -->
<div class="modal fade" id="monthlyPaymentReportModal" tabindex="-1" aria-labelledby="monthlyPaymentReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="monthlyPaymentReportModalLabel">Aylık Ödeme Raporu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Ay Seçin</label>
                    <select class="form-select" id="reportMonth">
                        <option value="1">Ocak</option>
                        <option value="2">Şubat</option>
                        <option value="3">Mart</option>
                        <option value="4">Nisan</option>
                        <option value="5">Mayıs</option>
                        <option value="6">Haziran</option>
                        <option value="7">Temmuz</option>
                        <option value="8">Ağustos</option>
                        <option value="9">Eylül</option>
                        <option value="10">Ekim</option>
                        <option value="11">Kasım</option>
                        <option value="12">Aralık</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Yıl</label>
                    <input type="number" class="form-control" id="reportYear" value="2025" min="2020" max="2030">
                </div>
                <div class="mb-3">
                    <label class="form-label">Rapor Türü</label>
                    <select class="form-select" id="reportType">
                        <option value="all">Tüm Ödemeler</option>
                        <option value="paid">Ödenenler</option>
                        <option value="pending">Bekleyenler</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" onclick="generateMonthlyReport()">Rapor Oluştur</button>
            </div>
        </div>
    </div>
</div>

<!-- Alınacaklar Listesi Modal -->
<div class="modal fade" id="shoppingListReportModal" tabindex="-1" aria-labelledby="shoppingListReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shoppingListReportModalLabel">Alınacaklar Listesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori Filtresi</label>
                    <select class="form-select" id="shoppingCategory">
                        <option value="all">Tüm Kategoriler</option>
                        <option value="İhtiyaçlar">İhtiyaçlar</option>
                        <option value="İstek Listesi">İstek Listesi</option>
                        <option value="Favori Ürünler">Favori Ürünler</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Öncelik Filtresi</label>
                    <select class="form-select" id="shoppingPriority">
                        <option value="all">Tüm Öncelikler</option>
                        <option value="Düşük">Düşük</option>
                        <option value="Orta">Orta</option>
                        <option value="Yüksek">Yüksek</option>
                        <option value="Acil">Acil</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fiyat Aralığı</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="number" class="form-control" id="minPrice" placeholder="Min Fiyat">
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control" id="maxPrice" placeholder="Max Fiyat">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" onclick="generateShoppingReport()">Rapor Oluştur</button>
            </div>
        </div>
    </div>
</div>

<!-- Hedefler Raporu Modal -->
<div class="modal fade" id="goalsReportModal" tabindex="-1" aria-labelledby="goalsReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="goalsReportModalLabel">Hedefler Raporu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Hedef Türü</label>
                    <select class="form-select" id="goalType">
                        <option value="all">Tüm Hedefler</option>
                        <option value="Hayal">Hayaller</option>
                        <option value="Hedef">Hedefler</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Durum</label>
                    <select class="form-select" id="goalStatus">
                        <option value="all">Tüm Durumlar</option>
                        <option value="Devam Ediyor">Devam Ediyor</option>
                        <option value="Tamamlandı">Tamamlandı</option>
                        <option value="İptal">İptal</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tarih Aralığı</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" class="form-control" id="goalStartDate">
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control" id="goalEndDate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" onclick="generateGoalsReport()">Rapor Oluştur</button>
            </div>
        </div>
    </div>
</div>

<!-- Yıllık Rapor Modal -->
<div class="modal fade" id="yearlyReportModal" tabindex="-1" aria-labelledby="yearlyReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yearlyReportModalLabel">Yıllık Finansal Rapor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Yıl</label>
                    <input type="number" class="form-control" id="yearlyReportYear" value="2025" min="2020" max="2030">
                </div>
                <div class="mb-3">
                    <label class="form-label">Rapor Türü</label>
                    <select class="form-select" id="yearlyReportType">
                        <option value="summary">Özet Rapor</option>
                        <option value="detailed">Detaylı Rapor</option>
                        <option value="comparison">Karşılaştırmalı Rapor</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Grafik Türü</label>
                    <select class="form-select" id="yearlyChartType">
                        <option value="line">Çizgi Grafik</option>
                        <option value="bar">Sütun Grafik</option>
                        <option value="pie">Pasta Grafik</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" onclick="generateYearlyReport()">Rapor Oluştur</button>
            </div>
        </div>
    </div>
</div>