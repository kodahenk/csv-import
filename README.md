# Projeler ile ilgili Açıklamalar

- Dosya Upload işlemi yapılıyor, dosya csv değilse upload işlemi yapılmıyor
- Formu back end tarafında kontrol ediyor, bir hata varsa bilgilendirme yapıyor
- Form başarılı bir şelikde işlenirse satırlar kontrol ediliyor
- İstenilen formattaki satırlar db'ye yazdırılıyo, invalidate satırlar geri bildirim olarak dönüyor

## Ön Bilgilendirme

- Bilgisayarda Docker Kurulu olmalı.
- Docker'ın MySQL(3306) ve Apache(80) için kullanacağı portları müsait olmalı.
- Kurulumuyla ilgili video https://youtu.be/KebgcXm5IIk

## Csv Import - csv-import.test

Projenin çalışan versiyonu http://csv-import.kodahenk.com adresinde mevcut

Bilgisayarınızda projenin .test uzantılı adresini çalıştırmak için **hosts** dosyasına site adını eklemeniz gerekiyor.
- Windows için **C:\Windows\System32\drivers\etc**
- Mac için **/etc/hosts**

```
127.0.0.1       csv-import.test
```

Veritabanı : http://localhost:8080

Site adresi: http://csv-import.test


### Kurulumu
Yukarıdaki ayarlamaları (docker kurulumu, portların müsaitliği ve hosts dosyasına ekleme) yaptıktan sonra:
```
# Projeyi indirmek için
git clone https://github.com/kodahenk/csv-import.git

# indirilen projenin içine giriyoruz
cd csv-import

# Docker için
docker compose up

# PhpMyAdmin'in kendine gelmesi 2-3 dk sürebilir
```

http://localhost:8080 adresine gidip import_db adında bir veritabanı oluşturun. Daha sonra import_db.sql dosyasını import edin.

> Proje'nin PHP dosyaları /www/csv-import/ klasörünün altında
