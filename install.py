import os

class colores_indicadores:
    COLOR_VERDE = '\033[92m'
    COLOR_ROJO = '\033[91m'
    COLOR_POR_DEFECTO = '\033[0m'

def imprimir_mensaje(mensaje, codigo_color):
    if codigo_color == 1:
        print(colores_indicadores.COLOR_VERDE + mensaje + colores_indicadores.COLOR_POR_DEFECTO)
    else:
       print(colores_indicadores.COLOR_ROJO + mensaje + colores_indicadores.COLOR_POR_DEFECTO)



os.system('rm -r ./HAUGA/')
os.system('rm -r /var/www/html/HAUGA/')


gitclone = os.system('git clone https://github.com/rubenyanezmartinez/HAUGA.git;')
if gitclone == 0:
    os.system('mv ./HAUGA /var/www/html/;')
    os.system('cd /var/www/html/HAUGA/ || exit;')
    imprimir_mensaje('Se ha descargado y colocado con exito el proyecto', 1)
else:
    imprimir_mensaje('ERROR: no ha sido posible descargar el proyecto', 0)


permisoImagenes = os.system('chmod -R a+w /var/www/html/HAUGA/Models/Imagenes_Espacios/;')
if permisoImagenes == 0:
    imprimir_mensaje('Se han concedido con exito permisos de escritura al directorio Imagenes_Espacios',1)
else:
    imprimir_mensaje('ERROR: no ha sido posible conceder permisos de escritura al directorio Imagenes_Espacios',0)


montarBaseDeDatos = os.system('mysql -u root --password=iu < /var/www/html/HAUGA/Models/db.sql;')
if montarBaseDeDatos == 0:
    imprimir_mensaje('Se ha montado correctamente la BD',1)
else:
    imprimir_mensaje('ERROR: no se ha podido montar correctamente la BD',0)