# Usa una imagen base de PHP con Apache o Nginx, o solo PHP-FPM si vas a usar un servidor web separado
# Para un proyecto simple como el tuyo, php:8.2-apache es una buena opción ya que incluye Apache preconfigurado.
FROM php:8.2-apache

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia todos los archivos de tu proyecto al directorio de trabajo en el contenedor
COPY . .

# Habilita el módulo de reescritura de Apache (si lo necesitas para URLs amigables)
# RUN a2enmod rewrite

# Expone el puerto 80, que es el puerto por defecto de Apache
EXPOSE 80

# El comando por defecto para iniciar el servidor Apache (ya viene con la imagen php:*-apache)
# CMD ["apache2-foreground"]