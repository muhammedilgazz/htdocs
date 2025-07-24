document.addEventListener('DOMContentLoaded', function() {
    const durumSelects = document.querySelectorAll('.durum-select');
    
    durumSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const durum = this.value;
            
            fetch('ajax/update_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'update_status',
                    id: id,
                    durum: durum
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const toplamBorc = document.querySelector('#toplam-borc strong');
                    if (toplamBorc) {
                        toplamBorc.textContent = 'Toplam Ödenecek Tutar: ₺' + data.kalan_borc;
                    }
                    alert('Ödeme durumu güncellendi!');
                } else {
                    alert('Hata: ' + data.error);
                }
            })
            .catch(error => {
                alert('Bir hata oluştu: ' + error);
            });
        });
    });
});