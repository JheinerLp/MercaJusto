# 🛒 MERCAJUSTO

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![Docker](https://img.shields.io/badge/Docker-Enabled-blue)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Database-blue)

![Banner](public/images/Banner.png)

> **Calidad y frescura a tu alcance** 🌱  
> Plataforma web que conecta proveedores locales con clientes de manera rápida, sencilla y directa.

---

## ✨ Descripción

**MercaJusto** es una aplicación web desarrollada en Laravel que permite a proveedores gestionar sus productos y conectar directamente con clientes mediante WhatsApp, promoviendo el comercio local y la accesibilidad digital.

---

## 🚀 Características principales

- 🛍️ Gestión de productos
- 🧑‍🌾 Panel exclusivo para proveedores
- ✏️ Edición de información empresarial
- 📸 Subida de imágenes de productos
- 📱 Contacto directo por WhatsApp
- 🗂️ Organización por categorías
- ⚡ Interfaz moderna y rápida
- 📦 Sistema de inventario básico
- 📱 Contacto por WhatsApp
- ⚙ Solicita soporte 

---

## 🧑‍🌾 Funcionalidades del proveedor

Como proveedor puedes:

- ➕ Agregar nuevos productos
- ✏️ Editar productos existentes
- ❌ Eliminar productos
- 🏢 Editar la información de tu empresa
- 📸 Subir imágenes de tus productos
- 📲 Recibir contactos de clientes vía WhatsApp
- 🗃️ Gestionar categorías de productos

---

## 🖼️ Vista previa

![Dashboard](public/images/Dasboard.JPG)
![Productos](public/images/Productos.JPG)

---

## 🛠️ Tecnologías utilizadas

- ⚙️ Laravel 12
- 🐘 PostgreSQL
- 🐳 Docker
- 🎨 Blade + CSS
- ⚡ JavaScript

---

## 📦 Instalación

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/tuusuario/mercajusto.git
cd mercajusto
```
###  ⚙ configurar
 .env con la informacion suministrada del encargado
### 🛠 Empezar docker 
```bash
docker-compose up --build
```
### 📦 Instalar dependencias
```bash
docker exec -it laravel_app composer install
```
### 🔑 Generar la llave
```bash
docker exec -it laravel_app php artisan key:generate
```
### 🔹 Ejecutar migraciones
```bash
docker exec -it laravel_app php artisan migrate
```
en tu navegador :
http://localhost:8000
