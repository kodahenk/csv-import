# Projeler ile ilgili Açıklamalar

## Ön Bilgilendirme

- Bilgisayarda Docker Kurulu olmalı.
- Docker'ın MySQL(3306) ve Apache(80) için kullanacağı portları müsait olmalı.

## Csv Import - csv-import.test

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

# .env için ayarlar
cp sample.env .env

# Docker için
docker compose up

## http://csv-import.test
```