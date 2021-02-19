- Clone repo <br/>
- rename .env.example ke .env
- Ubah konfigurasi Database dan Mail (mailtrap)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your email
MAIL_FROM_NAME="${APP_NAME}"
```
- Install Composer <br/>
- Buat Database. Import sql file (Saya tidak membuat migration)
