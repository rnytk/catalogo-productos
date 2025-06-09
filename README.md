# 📦 Catálogo de Productos

Este proyecto es un sistema de catálogo de productos desarrollado con **Laravel 12** y el panel administrativo **FilamentPHP v#**, ideal para gestionar marcas, categorías, productos y usuarios de forma eficiente y moderna.

---

## 🚀 Requisitos

Antes de comenzar, asegúrate de tener instalado:

- PHP >= 8.1
- Composer
- Node.js y NPM
- MySQL 
- Laravel CLI
- Git

---

## ⚙️ Instalación

Sigue estos pasos para levantar el proyecto localmente:

1. **Clonar el repositorio**

```bash
git clone https://github.com/rnytk/catalogo-productos.git
cd catalogo-productos

```

2. **Instalar dependencias PHP y JS**

```bash
composer install
npm install
```

3. **Copiar archivo de entorno y generar clave**

```bash
cp .env.example .env
php artisan key:generate
```
4. **Configurar la base de datos**

```bash
DB_DATABASE=nombre_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

```
5. **Ejecutar migraciones y seeders**


```bash

php artisan migrate --seed. 

```
6. **Iniciar el servidor local**

```bash 
php artisan serve
```


