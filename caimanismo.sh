#!/bin/bash

# pregunta: quiero declarar clases en el script, que hago??
# respuesta: ayy
SCRIPT_NAME="Cara e' Papaeo"
VERSION="v0.1"
ENVIDIOSOSVANAENVIDIAR="slayerfat"
# fucking magia
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

#composer
COMPOSER='composer.phar'

echo "-------------------------------------------------------"
echo "Hola $USER"
echo "Empezando El $SCRIPT_NAME."
echo "$VERSION hecho por el unico e inigualable"
echo ${ENVIDIOSOSVANAENVIDIAR}
echo "-------------------------------------------------------"

#se instala composer
echo "instalando composer."
curl -sS https://getcomposer.org/installer | php -- --filename=${COMPOSER}

#movemos composer para eliminarlo despues
mv ${COMPOSER} ${DIR}/${COMPOSER}

#ejecutamos composer
echo "ejecutando Composer"
php ${DIR}/${COMPOSER} --working-dir=${DIR}/src/ install --no-interaction

echo "*******************************************************"
echo "instalando Bower"
echo "*******************************************************"
npm install -g bower

echo "*******************************************************"
echo "instalando dependencias del sistemaPCI por NPM y Bower"
echo "*******************************************************"
(cd ${DIR}/src/ && npm install && bower install && gulp)

echo "*******************************************************"
echo "cambiando permisos de directorios"
echo "*******************************************************"
chmod go+w -R ${DIR}/src/storage && chmod go+w -R ${DIR}/src/bootstrap

echo "*******************************************************"
echo "Conserjeria..."
echo "*******************************************************"
#eliminamos composer
rm ${DIR}/${COMPOSER}

echo "-------------------------------------------------------"
echo "$SCRIPT_NAME Terminado."
echo "$VERSION"
echo ${ENVIDIOSOSVANAENVIDIAR}
echo "instalando virus... COMPLETO."
echo "instalando troyanos... COMPLETO."
echo "sistemaPCI es vida."
echo "sistemaPCI es amor."
echo "sistemaPCI es bien."
echo "sistemaPCI es todo."
echo "-------------------------------------------------------"
