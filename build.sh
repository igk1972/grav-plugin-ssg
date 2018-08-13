#!/bin/bash

export GRAV_ROOT=${1} STATIC_DIR=${2} DIST_DIR=${3} HTTP_HOST=${4}

export REQUEST_SCHEME=https HTTP_METHOD=GET BUILD_CMD="php -c . -f index.php" BUILD=true


mkdir "/tmp/lock-${HTTP_HOST}" > /dev/null 2>&1 || exit 1


if [ "$(uname)" == "Darwin" ]; then
  ISED='-i .bak'
else
  ISED='--in-place=.bak'
fi


pushd "${GRAV_ROOT}" > /dev/null 2>&1


echo "Clean: ${DIST_DIR}" && rm -fr "${DIST_DIR}" && mkdir -p "${DIST_DIR}" || {
    rmdir "/tmp/lock-${HTTP_HOST}" > /dev/null 2>&1
    popd  > /dev/null 2>&1
    exit 1
}

echo "Build: /" && mkdir -p "${DIST_DIR}" && REQUEST_URI=/ ${BUILD_CMD} > "${DIST_DIR}/index.html"

REQUEST_URI=/sitemap ${BUILD_CMD} > "${DIST_DIR}/sitemap.xml"

BUILD_SITEMAP="$(cat "${DIST_DIR}/sitemap.xml" | grep '<loc>' | sed -E "s# *</*loc>##g; s#${REQUEST_SCHEME}://${HTTP_HOST}##" | grep -v -E '^$')"

for BUILD_URI in ${BUILD_SITEMAP} ; do
  echo "Build: ${BUILD_URI}" && mkdir -p "${DIST_DIR}/${BUILD_URI}" && REQUEST_URI=${BUILD_URI} ${BUILD_CMD} > "${DIST_DIR}${BUILD_URI}/index.html"
done


BUILD_STATIC="$(find "${STATIC_DIR}" -mindepth 1 -maxdepth 1 -not -name '.*' | tr "\n" ' ')"
echo "Copy: static" && cp -r ${BUILD_STATIC} "${DIST_DIR}/"


echo "Relink: static" && {
  find "${DIST_DIR}" -type f \( -name '*.html' -o -name '*.css' -o -name '*.js' \) -exec \
    sed $ISED -E "s#/site/static##g" {} +
  find "${DIST_DIR}" -type f -name '*.bak' -delete
}


rmdir "/tmp/lock-${HTTP_HOST}" > /dev/null 2>&1

popd > /dev/null 2>&1

