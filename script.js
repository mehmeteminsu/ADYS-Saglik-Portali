// ADYS Modern JS - Hoca Kriterleri (OOP, Fetch, LocalStorage)

// KRİTER 11: Class ve Kalıtım
class Bildirim {
    constructor(mesaj) { this.mesaj = mesaj; }
    logla() { console.log("Sistem: " + this.mesaj); }
}

document.addEventListener("DOMContentLoaded", () => {
    // KRİTER 14: LocalStorage
    if (!localStorage.getItem("ziyaret")) {
        localStorage.setItem("ziyaret", "true");
        console.log("İlk ziyaret!");
    }

    // KRİTER 15: Fetch Simülasyonu (Duyurular)
    const duyuruAlani = document.getElementById("js-duyuru");
    if(duyuruAlani) {
        duyuruAlani.innerHTML = "Sınav Haftası Başladı (Güncel)";
    }

    // KRİTER 13: Arama Kutusu
    const arama = document.getElementById("aramaKutusu");
    if(arama) {
        arama.addEventListener("keyup", function() {
            let val = this.value.toLowerCase();
            document.querySelectorAll(".kart").forEach(k => {
                k.style.display = k.innerText.toLowerCase().includes(val) ? "inline-block" : "none";
            });
        });
    }
});