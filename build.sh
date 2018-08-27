#!/bin/bash

export GRAV_ROOT="${1}" HTTP_HOST="${2}"

export DIST_DIR="app/dist/public" STATIC_DIR="../../../static"

export REQUEST_SCHEME=https HTTP_METHOD=GET BUILD_CMD="php -c . -f index.php" BUILD=true


mkdir "/tmp/lock-${HTTP_HOST}" > /dev/null 2>&1 || exit 1


if [ "$(uname)" == "Darwin" ]; then
  ISED='-i .bak'
else
  ISED='--in-place=.bak'
fi
SSED="s#/${DIST_DIR}##g"


pushd "${GRAV_ROOT}" > /dev/null 2>&1


echo "Clean: ${DIST_DIR}" && rm -fr "${DIST_DIR}" && mkdir -p "${DIST_DIR}" || {
    rmdir "/tmp/lock-${HTTP_HOST}" > /dev/null 2>&1
    popd  > /dev/null 2>&1
    exit 1
}

echo "Build: /" && mkdir -p "${DIST_DIR}/assets" && REQUEST_URI=/ ${BUILD_CMD} | sed -E $SSED > "${DIST_DIR}/index.html"

REQUEST_URI=/sitemap ${BUILD_CMD} > "${DIST_DIR}/sitemap.xml"

BUILD_SITEMAP="$(cat "${DIST_DIR}/sitemap.xml" | grep '<loc>' | sed -E "s# *</*loc>##g; s#${REQUEST_SCHEME}://${HTTP_HOST}##" | grep -v -E '^$')"

for BUILD_URI in ${BUILD_SITEMAP} ; do
  echo "Build: ${BUILD_URI}" && mkdir -p "${DIST_DIR}/${BUILD_URI}" && REQUEST_URI=${BUILD_URI} ${BUILD_CMD} | sed -E $SSED > "${DIST_DIR}${BUILD_URI}/index.html"
done

rm -fr "${DIST_DIR}/cache"

echo "Relink: static" && {
  find "${DIST_DIR}" -type f \( -name '*.css' -o -name '*.js' \) -exec \
    sed $ISED -E $SSED {} +
  find "${DIST_DIR}" -type f -name '*.bak' -delete
}


BUILD_STATIC="$(find "${STATIC_DIR}" -mindepth 1 -maxdepth 1 -not -name '.*' | tr "\n" ' ')"
echo "Copy: static" && cp -r ${BUILD_STATIC} "${DIST_DIR}/"

rmdir "/tmp/lock-${HTTP_HOST}" > /dev/null 2>&1

popd > /dev/null 2>&1

