# Proyecto Laravel: Implementación con Sail, TDD y Principios SOLID
Este es un proyecto Laravel configurado con Laravel Sail como entorno de desarrollo local en Docker. La finalidad es desarrollar una aplicación sencilla pero implementando buenas prácticas de código, permitiendo que otros desarrolladores puedan revisar el código y apreciar la calidad del mismo a través de:


- ✅ **Test-Driven Development (TDD)**
- ✅ **Principios SOLID aplicados**
- ✅ **Arquitectura limpia y mantenible**
- ✅ **Code standards y convenciones de Laravel**
- ✅ **Documentación clara del código**

## Requisitos Previos
Docker (Instalado)

## Instalación
**1. Clonar el proyecto**
```bash
    git clone git@github.com:allencarlosdev/Solid-Project.git
```
**2. Entrar al proyecto**
```bash
    cd Solid-Project
```
**3. Configurar variables de entorno**
   En la consola agregas lo siguiente:
```bash
cp .env.example .env
```
**4. Configuras las variables de entorno**
```bash
    DB_CONNECTION=
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
```

**5. Instalas la Imagen de sail 8.4 e instala las dependencias en el contenedor**
    Esto lo colocas en tu consola :
```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
```

**6. Levantas los contenedores del Proyecto en Docker**
    Esto lo colocas en tu consola :
```bash
./vendor/bin/sail up -d
```

**6.1 Cambiar el alias ( Opcional )**
    Esto lo colocas en tu consola :
```bash
    echo 'alias sail="./vendor/bin/sail"' >> ~/.bashrc
    source ~/.bashrc
```

**7 Generar una nueva Key**
    Esto lo colocas en tu consola :
```bash
sail artisan key:generate
```
**8 Migrar las tablas de la base de datos**
    Esto lo colocas en tu consola :
```bash
sail artisan migrate
```
**9 El proyecto de laravel ya esta en marcha**
    Esto lo colocas en tu browser :
    (http://localhost:8083)


---

A continuación se documentará el progreso del desarrollo, incluyendo la metodología SCRUM, avances en funcionalidades y capturas del proyecto en desarrollo.

**Ejemplo SCRUM:**

![SCRUM Screenshot](https://raw.githubusercontent.com/allencarlosdev/Solid-Project/refs/heads/main/public/img/scrum_screenshoot.png)

**Ejemplo de la Aplicación:**
![SCRUM Screenshot](https://raw.githubusercontent.com/allencarlosdev/Solid-Project/refs/heads/main/public/img/preview.png)
![SCRUM Screenshot](https://raw.githubusercontent.com/allencarlosdev/Solid-Project/refs/heads/main/public/img/Solid-project.gif)

