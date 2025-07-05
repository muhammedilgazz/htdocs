// Dropdown menü işlevselliği
document.addEventListener('DOMContentLoaded', function () {
    // Tüm dropdown seçicileri
    const dropdowns = document.querySelectorAll('.downpdown_selector');

    dropdowns.forEach(dropdown => {
        const selected = dropdown.querySelector('.dds_selected');
        const selectList = dropdown.querySelector('.dds_select_lists');
        const items = dropdown.querySelectorAll('.dds_select_item');

        // Dropdown açma/kapama
        selected.addEventListener('click', function (e) {
            e.stopPropagation();

            // Diğer dropdownları kapat
            dropdowns.forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.querySelector('.dds_select_lists').style.height = '0';
                    otherDropdown.classList.remove('active');
                }
            });

            // Mevcut dropdown'u aç/kapat
            if (selectList.style.height === '0px' || !selectList.style.height) {
                selectList.style.height = 'auto';
                dropdown.classList.add('active');
            } else {
                selectList.style.height = '0';
                dropdown.classList.remove('active');
            }
        });

        // Seçenek seçimi
        items.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();

                // Aktif sınıfı güncelle
                items.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                // Seçili metni güncelle
                const selectedText = this.querySelector('span').textContent;
                selected.querySelector('span').textContent = selectedText;

                // Dropdown'u kapat
                selectList.style.height = '0';
                dropdown.classList.remove('active');

                // Sıralama işlemi
                const sortValue = this.getAttribute('data-sort');
                if (sortValue) {
                    handleSorting(sortValue);
                }
            });
        });
    });

    // Dışarı tıklandığında dropdownları kapat
    document.addEventListener('click', function () {
        dropdowns.forEach(dropdown => {
            dropdown.querySelector('.dds_select_lists').style.height = '0';
            dropdown.classList.remove('active');
        });
    });
});

// Sıralama işlevi
function handleSorting(sortValue) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortValue);
    window.location.href = url.toString();
}
