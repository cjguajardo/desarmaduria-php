# Desarmaduria PHP

Este es un proyecto para una clase de desarrollo en la universidad. Es una aplicación web para un almacén de piezas de automóviles. Se construye utilizando PHP, MySQL y Docker.

## Instalación

Instrucciones sobre cómo instalar y ejecutar el proyecto.

```bash
git clone https://github.com/cjguajardo/desarmaduria-php.git
cd desarmaduria-php
```

## Instalación de Docker

Este proyecto utiliza Docker para crear un entorno reproducible. Si no tienes Docker instalado, necesitarás instalarlo antes de poder ejecutar este proyecto.

### Para Windows y macOS

1. Descarga Docker Desktop del sitio web oficial de Docker[1].
2. Instala Docker Desktop siguiendo las instrucciones del instalador.

### Para Linux

1. Actualiza tu lista actualizada de paquetes: `sudo apt-get update`
2. Instala un par de paquetes previos que permiten que apt utilice paquetes sobre HTTPS: `sudo apt-get install apt-transport-https ca-certificates curl software-properties-common`
3. Añade la clave GPG del repositorio oficial de Docker a tu sistema: `curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -`
4. Añade el repositorio de Docker a las fuentes de APT: `sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"`
5. Actualiza el catálogo de paquetes con los paquetes de Docker del repositorio recién agregado: `sudo apt-get update`
6. Asegúrate de que estés a punto de instalar desde el repositorio de Docker en lugar de la fuente predeterminada de Ubuntu: `apt-cache policy docker-ce`
7. Instala Docker: `sudo apt-get install docker-ce`

Para instrucciones más detalladas, vea la documentación oficial de Docker[3].

## Construcción e Ejecución de los Contenedores Docker

Una vez que tienes Docker instalado, puedes construir y ejecutar los contenedores definidos en este proyecto utilizando Docker Compose.

1. Navega hasta el directorio del proyecto en tu terminal.

```bash
cd path/a/tu/proyecto
```

2. Construye las imágenes Docker. Esto puede llevar alguno tiempo la primera vez que lo ejecutes, ya que Docker necesita descargar las imágenes base y construir tus contenedores.

```bash
docker-compose build
```

3. Una vez que las imágenes estén construidas, puedes comenzar los contenedores:

```bash
docker-compose up -d
```

La bandera -d indica a Docker que ejecute los contenedores en segundo plano.

Deberías tener ahora tus contenedores en ejecución. Puedes verificar el estado de tus contenedores ejecutando:

```bash
docker-compose ps
```

Para instrucciones más detalladas sobre el uso de Docker Compose, vea la documentación oficial de Docker Compose[4].

## Ejecución de la Aplicación

Una vez que tienes tus contenedores en ejecución, puedes abrir la aplicación web en http://localhost:8080

## Compilación de Sass - Docker

Este proyecto utiliza Sass para los estilos. Si hace cambios en los archivos Sass, necesitarás compilar tus cambios a CSS.

1. Navega hasta el directorio del proyecto en tu terminal.

```bash
cd path/a/tu/proyecto
```

2. Ejecuta el siguiente comando para compilar tus Sass a CSS:

```bash
docker-compose run --rm node npm run sass
```

## Compilación de Sass - Local

Si prefieres, puedes compilar tus Sass localmente en lugar de utilizar Docker.

1. Navega hasta el directorio del proyecto en tu terminal.

```bash
cd path/a/tu/proyecto
```

Tienes que estar en el directorio web para ejecutar el siguiente comando:

```bash
npm run sass
``
