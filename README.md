# Gestor de Tienda en Tiempo Real

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4E56B6?style=for-the-badge&logo=livewire&logoColor=white)
![Reverb](https://img.shields.io/badge/Reverb-000000?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

Proyecto de gestión de productos desarrollado con **Laravel**, **Livewire** y **Reverb** para actualizaciones instantáneas en el panel de ventas y la tienda.

## Características
- Gestión de inventario en tiempo real.
- Notificaciones automáticas de productos nuevos/actualizados.
- Interfaz moderna y responsiva.



## Tecnologías utilizadas

* **PHP 8.x / Laravel**
* **Livewire**
* **Reverb (WebSockets)**
* **Vite**



## Flujo de la App en Video

Demostración donde se aprecia la reactividad del sistema, mostrando cómo las actualizaciones de inventario se reflejan instantáneamente en la interfaz gracias a Laravel Reverb.

<video src="https://github.com/user-attachments/assets/1be459cf-d691-4951-8609-1b6f71aadac3" controls width="100%"></video>



## Interfaces de la Tienda

Aquí puedes observar el diseño y la estructura de la aplicación, desde la página de inicio hasta el panel de control administrativo donde se gestionan los productos en tiempo real.

<div align="center">
  <img src="https://github.com/user-attachments/assets/52406e70-beb8-4b86-bbdc-21a632390015" width="23%" />
  <img src="https://github.com/user-attachments/assets/0dac6515-e979-469a-a840-870f45c3f31f" width="23%" />
  <img src="https://github.com/user-attachments/assets/0960ac03-0cba-4e86-98b0-743180c2e723" width="23%" />
  <img src="https://github.com/user-attachments/assets/76b3d999-99fe-4c98-bc09-f6a5070cba07" width="23%" />
</div>

<div align="center">
  <b>Inicio</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <b>Dashboard</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <b>Administración</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <b>Tienda</b>
</div>
---

## Instalación

Sigue estos pasos para ejecutar el proyecto en tu máquina local:

1. **Clonar el repositorio:**
```bash
   git clone [https://github.com/Yudith1924/gestor-tienda-laravel.git](https://github.com/Yudith1924/gestor-tienda-laravel.git)
   cd gestor-tienda-laravel

```

2. **Instalar dependencias:**
```bash
composer install
npm install

```


3. **Configurar entorno:**
```bash
cp .env.example .env
php artisan key:generate

```


*(Recuerda configurar tu base de datos en el archivo .env)*
4. **Ejecutar migraciones:**
```bash
php artisan migrate

```



---

## Ejecución del Proyecto

Para que la aplicación funcione correctamente con las actualizaciones en tiempo real, **debes tener abiertas tres terminales** ejecutando los siguientes comandos simultáneamente:

1. **Servidor Web:**
```bash
php artisan serve

```


2. **Servidor de WebSockets (Reverb):**
```bash
php artisan reverb:start 

```


3. **Compilación de Assets:**
```bash
npm run dev

```
