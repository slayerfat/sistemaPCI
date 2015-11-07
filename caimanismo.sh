#!/bin/bash

# pregunta: quiero declarar clases en el script, que hago??
# respuesta: ayy
SCRIPT_NAME="Cara e' Papaeo"
VERSION="v0.1"
ENVIDIOSOSVANAENVIDIAR="slayerfat"
PROMPT_ERROR='Por favor solo Si o No, yo no se programar en bash, LOL.'

# fucking magia
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

#composer
COMPOSER='composer.phar'

echo "-------------------------------------------------------"
echo "Hola $USER"
echo "Empezando El $SCRIPT_NAME."
echo "$VERSION hecho por el unico e inigualable"
echo ${ENVIDIOSOSVANAENVIDIAR}
echo "calidad de este script: (0/10) * 100"
echo "-------------------------------------------------------"

# nothing to see here, move along.
while true; do
    read -p "¿Acepta los terminos y condiciones de este script?" yn
    case ${yn} in
        [Ss]* ) break;;
        [Nn]* ) break;;
        * ) echo ${PROMPT_ERROR};;
    esac
done

echo "*******************************************************"
echo "*******************************************************"
echo "*******************************************************"
echo "*******************************************************"
echo "--------------EL PACTO HA SIDO SELLADO-----------------"
echo "*******************************************************"
echo "*******************************************************"
echo "*******************************************************"
echo "*******************************************************"
sleep 2

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
echo "instalando TypeScript Definition manager"
echo "*******************************************************"
npm install tsd -g

echo "*******************************************************"
echo "instalando dependencias de TypeScript"
echo "*******************************************************"
(cd ${DIR} && tsd install)

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
sleep 1
echo "instalando virus... COMPLETO."
sleep 2
echo "instalando troyanos... COMPLETO."
sleep 5
# nothing to see here, move along.
while true; do
    read -p "¿Te asustaste?" yn
    case ${yn} in
        [Ss]* ) break;;
        [Nn]* ) break;;
        * ) echo ${PROMPT_ERROR};;
    esac
done
echo "sistemaPCI es vida."
sleep 1
echo "sistemaPCI es amor."
sleep 1
echo "sistemaPCI es bien."
sleep 1
echo "sistemaPCI es todo."
sleep 1
echo "El sistemaPCI cambio mi vida. - Albert Einstein"
echo "-------------------------------------------------------"
