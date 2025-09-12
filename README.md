```bash
composer create-project laravel/laravel community_laravel
```

gerekli tablo bilgilerini notlar.md ye yaz.
.env dosyasından veritabanına ait güncellemeleri gerçekleştir
propmt1->notlar.md bu sütunlar için bana migration ve model dosyalarını hazırla.

manuel migration oluşturma
```bash
php artisan migrate
```

prompt2:  bu tablolara ait controller oluştur, model binding kullan. crud işlemlerini gerçekleştir
routes/api.php: api.php dosyasına gerekli düzenlemeleri yap.

boostrap klasöründe app.php dosyasına      api: __DIR__.'/../routes/api.php', ekle.

api-test.http dosyasına test için apileri ekle.

seed data oluşturmak için de promptu yaz.
manuel oluşturmak için gerekli olabilecek komutlar

```bash
php artisan db:seed
php artisan migrate:fresh --seed
```
```bash
php artisan serve 
```ile çalıştırmayı unutma
