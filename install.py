import os

os.system('rm -r ./HAUGA/')
os.system('rm -r /var/www/html/HAUGA/')


gitclone = os.system('git clone https://github.com/rubenyanezmartinez/HAUGA.git;')
if gitclone == 0:
    os.system('mv ./HAUGA /var/www/html/;')
    os.system('cd /var/www/html/HAUGA/ || exit;')
    print('Se ha descargado y colocado con exito el proyecto')
else:
    print('ERROR: no ha sido posible descargar el proyecto')


permisoImagenes = os.system('chmod -R a+w /var/www/html/HAUGA/Models/Imagenes_Espacios/;')
if permisoImagenes == 0:
    print('Se han concedido con exito permisos de escritura al directorio Imagenes_Espacios')
else:
    print('ERROR: no ha sido posible conceder permisos de escritura al directorio Imagenes_Espacios')


montarBaseDeDatos = os.system('mysql -u root --password=iu < /var/www/html/HAUGA/Models/db.sql;')
if montarBaseDeDatos == 0:
    print('Se ha montado correctamente la BD')
else:
    print('ERROR: no se ha podido montar correctamente la BD')
