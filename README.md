# Gestor de Tienda en Tiempo Real

Proyecto de gestión de productos desarrollado con **Laravel**, **Livewire** y **Reverb** para actualizaciones instantáneas en el panel de ventas y la tienda.

## Características
- Gestión de inventario en tiempo real.
- Notificaciones automáticas de productos nuevos/actualizados.
- Interfaz moderna y responsiva.

---

## Tecnologías utilizadas

* **PHP 8.x / Laravel**
* **Livewire**
* **Reverb (WebSockets)**
* **Vite**

```
```

## Interfaces de la Tienda

Aquí puedes observar el diseño y la estructura de la aplicación, desde la página de inicio hasta el panel de control administrativo donde se gestionan los productos en tiempo real.

| Inicio | Dashboard | Panel de Administración | Vista de Tienda |
| :---: | :---: | :---: | :---: |
| ![Inicio](<img width="1918" height="865" alt="Captura de pantalla 2026-06-01 112758" src="https://github.com/user-attachments/assets/52406e70-beb8-4b86-bbdc-21a632390015" />
) | ![Dashboard](<img width="1898" height="868" alt="Captura de pantalla 2026-06-01 112810" src="https://github.com/user-attachments/assets/0dac6515-e979-469a-a840-870f45c3f31f" />
) | ![Panel de Administrador](<img width="1900" height="867" alt="Captura de pantalla 2026-06-01 112551" src="https://github.com/user-attachments/assets/0960ac03-0cba-4e86-98b0-743180c2e723" />
) | ![Tienda](<img width="1896" height="864" alt="Captura de pantalla 2026-06-01 112531" src="https://github.com/user-attachments/assets/76b3d999-99fe-4c98-bc09-f6a5070cba07" />
) |

---

## Flujo de la App en Video

Demostración donde se aprecia la reactividad del sistema, mostrando cómo las actualizaciones de inventario se reflejan instantáneamente en la interfaz gracias a Laravel Reverb.

*(https://github.com/user-attachments/assets/0893051e-c7e4-437e-9adf-44432fd31505)*


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
php artisan reverb:start --debug

```


3. **Compilación de Assets:**
```bash
npm run dev

```
