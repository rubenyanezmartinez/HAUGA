############################################
#         FICHERO DE INSTALACIÓN           #
############################################

#Función: Script bash que se encarga de conceder permisos de escritura al directorio Files donde se van a almacenar los ficheros de la aplicación. Tambien se encarga de crear la BD con el script SQL.


#!/bin/bash

#Borrar proyecto si ya existe
rm -r ./HAUGA/ ;
rm -r /var/www/html/HAUGA/ ;

#Si puede descarga el proyecto de github
if git clone https://github.com/rubenyanezmartinez/HAUGA.git; then
	#Envia mensaje afirmativo:
	mv ./HAUGA /var/www/html/;
	cd /var/www/html/HAUGA/;
	printf 'Se ha descargado y colocado con éxito el proyecto\n'
else
	#En caso contrario envía mensaje de error:
	printf 'ERROR: no ha sido posible descargar el proyecto\n'
fi

#Si puede conceder permisos:
if chmod -R a+w Models/Imagenes_Espacios/; then
	#Envia mensaje afirmativo:
	printf 'Se ha concedido con exito permisos de escritura al directorio Imagenes_Espacios\n'
else
	#En caso contrario envía mensaje de error:
	printf 'ERROR: no ha sido posible conceder permisos de escritura al directorio Files\n'
fi

#Si puede crear la BD:
if mysql -u root --password=iu < Models/db.sql; then
	#Envia mensaje afirmativo:
	printf 'Se ha montado correctamente la BD\n'
else
	#En caso contrario envía mensaje de error:
	printf 'ERROR: no se ha podido montar correctamente la BD\n'
fi



