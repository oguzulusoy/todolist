# Açıklamalar

1. Görev İstenen Şekilde Tamamlanmıştır

  - Konsoldan komutla Provider1 ve Provider2 çalıştırılabilir durumdadır
  - OOP kodlamaya dikkat edilmiştir.
  - Tasarım deseni olarak API Providers için Adapter Pattern ve Task Model için Repositories kullanılmıştır.
  - Veritabanı tablolarının kolayca oluşturulabilmesi için migrationslar oluturulmuştur.
  - Projenin Docker ile çalıştırılabilmesi için gerekli işlemler uygulanmıştır
  - En kısa sürede bitirme süresini hesaplayan algoritma geliştirilmiştir.
  - Bu Case'de Laravel 8 kullanılmıştır.


# Docker İle Projeyi Çalıştırma

1 - Proje ana dizininde iken __sudo docker-compose up__ komutu çalıştırılmalıdır.

2 - Proje ana dizininde iken tabloların oluşturulması ve örnek datalarını yüklenmesi için __sudo docker-compose exec main php artisan migrate:fresh --seed__ komutu çalıştırılmalıdır.
3 - Povider 1 Sağlayıcısını komutla çalıştırmak için __sudo docker-compose exec main php artisan insert:tasks --provider=Provider1__
4 - Povider 2 Sağlayıcısını komutla çalıştırmak için __sudo docker-compose exec main php artisan insert:tasks --provider=Provider2__

Yukarıdaki işlemler sonrasında proje ayağa kaldırılmış ve ihtiyaç duyulan tablo ve datalar yüklenmiş olacaktır.

# Algoritma
    /**
    * Algoritmanın doğru çalışması için tasklar ve developerlar levellerine göre sıralı bir şekilde çekildi
    * İlk önce gelen tasklarda minimum aynı eşitlikte olan leveller kullanıcıların levellerine göre yerleştirildi ve kuyruktan çıkarıldı
    * Artık her kullanıcı kendi leveline göre 1 er saat mesgul bulunmakta ve hepsi aynı sürede işi bitirdiğini varsayıp yeteneklerine gore;
    * Kuyrukta kalan diğer işler levellerine göre sırasıyla 5 4 3 level ki bu leveller yüksek olanlar yakınlık durumuna göre 5, 4 ve 3 levelli
    * calisanlar arasında paylasildi 1 ve 2 nin yüksek katları olduklarından dolayı dahil edilmedi bu süre zarfında gecen süre hesaplandı
    * Mininum harcanan süreyi cıkardım 5,4,3 levelleri için 
    * 3,4,5 için Minimum harcanan saat kadar  1 ve 2 numaralı yetenekte ki çalışanlar kendi işlerini halledibilirler onlarda hesaplandı
    * en son kalan 1 ve 2de ki işler daha cabuk bitmesi acısından 5,4 ve 3 arasında paylasıldı
    * Minimum süre elde edildi
    * */
