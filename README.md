# products-api

Bu projede Laravel Sail, Docker, PostgreSQL kullanılmıştır.
Projede kullanmış olduğum REST API: https://makeup-api.herokuapp.com/api/v1/products.json
Kullanıma açık bu  ürün servisinden alınan bilgiler tek bir komutla çalışabilecek şekilde ayarlanmış Command'lar ile veritabanına kaydedilmektedir. 
Bu veriler, frontend'e sunmak üzere endpointler üzerinden erişilebilir hale getirilmiştir. Proje, yalnızca Backend API bileşenlerini içermektedir.

./vendor/bin/sail build //Docker build etme
./vendor/bin/sail up -d  //Konteynerları ayağa kaldırmak için
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed //Authentication için hazırlanmış kullanıcı kaydını seed eder.
./vendor/bin/sail artisan app:all //Tüm verileri veritabanına kayıt ettiğini terminal üzerinden gözlemleyebilirsiniz.

Postman üzerinden gerekli endpointleri test edebilirsiniz.
