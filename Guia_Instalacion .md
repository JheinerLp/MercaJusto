# 📖 Guía de Instalación y Configuración - MercaJusto

Esta guía contiene los pasos necesarios para instalar y configurar el proyecto **MercaJusto** en una computadora nueva desde cero, incluyendo la restauración de la base de datos PostgreSQL y la configuración del correo SMTP de Gmail.

---

## 🛠️ Requisitos Previos

Antes de comenzar, asegúrate de tener instalado el siguiente software en la computadora destino:

1. **XAMPP / PHP:**
   * Descarga e instala XAMPP (con **PHP 8.2 o superior**).
   * Asegúrate de habilitar la extensión `pdo_pgsql` y `pgsql` en el archivo de configuración `php.ini` de PHP (remueve el punto y coma `;` al inicio de las líneas correspondientes y reinicia los servicios).

2. **PostgreSQL:**
   * Descarga e instala **PostgreSQL** (versión 14 o superior recomendada) junto con su herramienta de administración **pgAdmin**.

3. **Composer:**
   * Descarga e instala **Composer** (gestor de dependencias de PHP) de manera global.

4. **Node.js y NPM:**
   * Descarga e instala la última versión LTS de **Node.js** (que incluye `npm`).

---

## 🚀 Pasos para la Instalación

### Paso 1: Copiar el Proyecto
Copia la carpeta completa del proyecto `Mercajusto` a tu computadora. La ubicación estándar si usas XAMPP en Windows es:
`C:\xampp\htdocs\Mercajusto`

### Paso 2: Crear el archivo `.env`
1. En la raíz del proyecto, busca el archivo `.env.example` y crea una copia llamada `.env`
2. Abre el archivo `.env` con un editor de texto y configura las siguientes variables clave:

```env
APP_NAME=Mercajusto
APP_ENV=local
APP_KEY=base64:bjZ6pxMsBtd9S3VS4cXW2fBW3cQwa32A58G8GPdgkDg=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Conexión a Base de Datos (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Merca
DB_USERNAME=tu_usuario_postgres
DB_PASSWORD=tu_contraseña_postgres

# Configuración de Colas (Obligatorio para que funcionen los mails)
QUEUE_CONNECTION=database

# Configuración del Correo (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=mercarjusto@gmail.com
MAIL_PASSWORD=ssajmtlgudzvrlyl 
MAIL_FROM_ADDRESS=mercarjusto@gmail.com
MAIL_FROM_NAME="MercaJusto"

# Configuración de Imágenes (Cloudinary)
CLOUDINARY_URL=cloudinary://918145551675262:4WZBN1MT9mE2mgH8rp9DHYwFd60@mercajusto
CLOUDINARY_CLOUD_NAME=mercajusto
CLOUDINARY_API_KEY=918145551675262
CLOUDINARY_API_SECRET=4WZBN1MT9mE2mgH8rp9DHYwFd60
```



### Paso 3: Restaurar la Base de Datos desde el Backup

1. Abre **pgAdmin** o la consola de PostgreSQL.
2. Crea una nueva base de datos llamada `Merca` (o el nombre que configuraste en `DB_DATABASE` en tu archivo `.env`).
3. Haz clic derecho sobre la base de datos `Merca` creada y selecciona **Restore** (Restaurar).
4. Selecciona el archivo de backup provisto (por ejemplo: `backup_merca.sql` o el archivo de respaldo `.dump` / `.tar`).
5. En la pestaña de opciones, selecciona el rol del propietario (`postgres` o tu usuario) y ejecuta la restauración.

*Alternativa por consola (PowerShell/CMD):*
```bash
pg_restore -U postgres -d Merca C:/ruta/al/archivo_de_backup.dump
```

---

### Paso 4: Instalar las Dependencias

Abre una terminal (CMD, PowerShell o Git Bash) en la raíz de la carpeta del proyecto e instala las dependencias necesarias ejecutando los siguientes comandos:

1. **Instalar dependencias de PHP (Composer):**
   ```bash
   composer install
   ```

2. **Generar la llave de la aplicación (en caso de que no esté definida en el `.env`):**
   ```bash
   php artisan key:generate
   ```

3. **Instalar dependencias de Javascript (NPM):**
   ```bash
   npm install
   ```

4. **Compilar recursos JS/CSS para producción:**
   ```bash
   npm run build
   ```

5. **Enlazar el almacenamiento público (Storage):**
   ```bash
   php artisan storage:link
   ```

---

## 🏃‍♂️ Cómo Iniciar la Aplicación

Para poner en marcha el proyecto localmente, debes ejecutar dos procesos en terminales independientes:

### Terminal 1: Iniciar el Servidor Laravel
Este comando inicia el servidor local de desarrollo:
```bash
php artisan serve
```
La aplicación estará disponible en tu navegador en: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Terminal 2: Iniciar el Procesador de Correos (Queue Worker)
Dado que los correos de soporte y notificaciones se envían en segundo plano para no ralentizar la navegación del usuario, **es obligatorio** tener el worker activo para que los correos salgan de la cola de base de datos:
```bash
php artisan queue:work
```

---

## 🔍 Solución de Problemas Comunes

* **Error de conexión a la Base de Datos:** Verifica que el servicio de PostgreSQL esté iniciado en la computadora y que el puerto (`5432`), usuario y contraseña en el archivo `.env` coincidan exactamente con la configuración de tu PostgreSQL.
* **Los correos no se envían:** Asegúrate de que el comando `php artisan queue:work` esté corriendo en una terminal de fondo y que tu contraseña de aplicación de Gmail esté activa y sea correcta.
* **Error de clases no encontradas o rutas rotas:** Ejecuta estos comandos de limpieza de caché en la consola del proyecto:
  ```bash
  php artisan config:clear
  php artisan route:clear
  php artisan cache:clear
  ```

Pdt : Hola profe pinno organice toda la informacion importante aqui si depronto necesita ingresar al correo que cree para las peticiones de la api y el envio de los correos 
estas serian las credenciales de google : 
gmail : mercarjusto@gmail.com
Contraseña: GyWj98#@  
Recordar que en este .zip esta la base de datos llamada Merca 
