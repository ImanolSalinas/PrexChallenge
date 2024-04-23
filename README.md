# PrexChallenge
Challenge para Prex-.

Link con los Archivos Pedidos: https://drive.google.com/drive/folders/1eJ6sO5X5zRPNt3Wltd3Nnql2vntaX2yU?usp=sharing


# Laravel 11 Dockerizado con Laravel Sail

Este proyecto utiliza Laravel 11, Docker y Laravel Sail para proporcionar un entorno de desarrollo fácil de configurar. Incluye OAuth y está configurado para usar una base de datos de pruebas llamada `testing` para ejecutar tests automatizados.

## Requisitos Previos

Antes de comenzar, asegúrate de tener Docker instalado en tu sistema. Si no lo tienes, puedes descargarlo e instalarlo desde [Docker](https://www.docker.com/products/docker-desktop).

## Configuración Inicial

1. **Clonar el Repositorio**

    Para obtener el proyecto, clona el repositorio en tu máquina local usando:
    bash
    git clone <URL_DEL_REPOSITORIO>


   Reemplaza `<URL_DEL_REPOSITORIO>` con la URL de tu repositorio.

2. **Configurar el Archivo .env**

   Copia el archivo `.env.example` a `.env` en la raíz del proyecto:

   cp .env.example .env


   Asegúrate de revisar y ajustar las variables de entorno en el archivo `.env` según sea necesario, especialmente las relacionadas con la base de datos y cualquier otro servicio externo que el proyecto utilice.

3. **Levantar el Proyecto con Docker y Laravel Sail**

   Laravel Sail es una interfaz de línea de comandos ligera para interactuar con Laravel's default Docker environment. Para iniciar el proyecto, ejecuta:

    ./vendor/bin/sail up


   La primera vez que ejecutes este comando, Docker construirá los contenedores necesarios, lo cual puede tomar algún tiempo. Una vez completado, tu aplicación debería estar corriendo y accesible en `http://localhost`.

4. **Generar Clave de Aplicación**

   Genera una clave de aplicación de Laravel ejecutando:

   ./vendor/bin/sail artisan key:generate


    
5. **Ejecutar Migraciones y Seeders**

   Para configurar tu base de datos, ejecuta las migraciones y seeders con:

   ./vendor/bin/sail artisan migrate --seed



6. **Ejecutar Tests**

   Para ejecutar los tests automatizados, utiliza:


   ./vendor/bin/sail artisan test



   
   Asegúrate de que tu archivo `.env.testing` esté configurado correctamente para apuntar a tu base de datos de testing.

    ## Acceso

    Una vez que el proyecto esté corriendo, puedes acceder a él a través de tu navegador web en `http://localhost`.




