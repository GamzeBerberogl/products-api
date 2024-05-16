## Proje Hakkında
Bu proje, Laravel Sail, Docker ve PostgreSQL kullanılarak oluşturulmuş bir arka uç API'si içermektedir. REST API'den (https://makeup-api.herokuapp.com/api/v1/products.json) alınan bilgiler özel Laravel komutları kullanılarak PostgreSQL veritabanına kaydedilmiştir. Bu veriler, frontend'e sunulmak üzere endpointler aracılığıyla erişilebilir hale getirilmiştir. Proje yalnızca Backend API bileşenlerini içermektedir.

## Başlarken

### Ön Koşullar
- Docker
- Laravel Sail yüklü olmalıdır

### Kurulum
Repositoriyi klonlayın ve ortamınızı çalışır hale getirmek için bu adımları izleyin:

**Docker ortamını oluşturun:**
./vendor/bin/sail build

**Konteynerleri başlatın:**
./vendor/bin/sail up -d

**Migrasyonları çalıştırın:**
./vendor/bin/sail artisan migrate


**Veritabanını seed edin (kimlik doğrulama için kullanıcı içerir):**
./vendor/bin/sail artisan db:seed


**Ürün verilerini veritabanına kaydetmek için özel komutu çalıştırın:**
./vendor/bin/sail artisan app:all


Bu işlem, belirtilen API'den veri çekip veritabanına kaydeder ve süreci terminal üzerinden gözlemleyebilirsiniz.

Kullanım

API endpoint'lerini Postman gibi araçlar kullanarak test edebilirsiniz. Bu proje, REST API tarafından sağlanan ürün verilerini çekmek ve yönetmek için gelen istekleri işlemek üzere ayarlanmıştır.

Katkıda Bulunma

Açık kaynak topluluğu, öğrenmek, ilham almak ve yaratmak için harika bir yerdir ve yaptığınız katkılar çok değerlidir.

Projeyi Forklayın
Kendi Dalınızı Oluşturun
Değişikliklerinizi Commit Edin 
Dalınızı Push Edin 
Pull Request Açın


Lisans

MIT Lisansı altında dağıtılmaktadır. Daha fazla bilgi için LICENSE dosyasına bakın.

Teşekkürler

Laravel Sail
Docker
PostgreSQL
