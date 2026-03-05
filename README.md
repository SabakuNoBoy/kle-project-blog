# KLE Blog Projesi

Bu proje, Laravel tabanlı bir blog sistemidir. İçerisinde API destekli bir backend mimarisi ve Livewire + Tailwind CSS kullanan, tamamen API üzerinden beslenen bir frontend uygulaması barındırmaktadır.

## Özellikler

- **Gelişmiş API Yaklaşımı:** Frontend tarafı veritabanına doğrudan bağlanmaz, sadece Backend API'larını tüketir.
- **Yönetim Paneli (FilamentPHP):** Adminler için gelişmiş dashboard. Kategoriler, Yazılar, Yorumlar, Kullanıcılar ve Sözleşmeler yönetilebilir.
- **Yetkilendirme:** Sanctum üzerinden Token bazlı kullanıcı doğrulama.
- **Kullanıcı İşlemleri:** Livewire ile dinamik kayıt olma, giriş yapma, profil güncelleme, yazı ve yorum oluşturma özellikleri.
- **Onay Sistemi:** Kullanıcıların oluşturduğu yazılar ve yorumlar varsayılan olarak inaktif gelir, admin onayından sonra yayınlanır.
- **Docker:** Tek bir `docker-compose` dosyasıyla backend, frontend ve veritabanı kolayca ayağa kaldırılabilir.
- **Responsive Tasarım:** Tailwind CSS kullanılarak her cihaza uyumlu arayüz.

## Kurulum ve Çalıştırma

Proje Docker kullanılarak tamamen izole edilmiş bir ortamda çalışacak şekilde yapılandırılmıştır. Tüm sistemi ayağa kaldırmak için aşağıdaki adımları izleyin:

1. Proje dizinine terminalden gidin:
   ```bash
   cd kle-project-blog-main
   ```

2. Docker Compose kullanarak servisleri başlatın:
   ```bash
   docker compose up -d --build
   ```

3. Backend tarafındaki veritabanı tablolarını ve seed verilerini yükleyin (Gerekirse):
   ```bash
   docker compose exec backend php artisan migrate --seed
   ```

   **Not:** Filament admin kullanıcısı oluşturmak için yukarıdaki işlemin ardından terminale şu komutu yazabilirsiniz:
   ```bash
   docker compose exec backend php artisan make:filament-user
   ```

## Servis Adresleri

- **Blog Sitesi (Frontend):** [http://localhost:8001](http://localhost:8001)
- **API Sunucusu (Backend):** [http://localhost:8000/api](http://localhost:8000/api)
- **Yönetim Paneli (Admin):** [http://localhost:8000/admin](http://localhost:8000/admin) (Frontend üzerinden `/admin` rotasına giderseniz otomatik yönlendirilirsiniz)

## Klasör Yapısı

```
kle-project-blog-main/
│
├── kle-project-backend-main/  # Laravel Backend (Filament Admin + API)
├── kle-project-frontend-main/ # Laravel Frontend (Livewire + Tailwind)
├── docker-compose.yml         # Docker orchestration dosyası
└── README.md                  # Proje dökümantasyonu
```

## Geliştirme Notları
- Loglar veya hata ayıklama için `docker compose logs -f` kullanabilirsiniz.
- Frontend'deki `Dashboard`, `PostCreate` ve `PostDetail` sistemleri, kimlik denetimini API Token'ları aracılığıyla yapmaktadır. Herhangi bir `auth` middleware sorunu yaşanmaz.
