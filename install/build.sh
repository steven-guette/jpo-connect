#!/bin/bash

PROJECT_ROOTPATH="$(readlink -f "$(dirname "${BASH_SOURCE[0]}")")/.."
readonly PROJECT_ROOTPATH

readonly FRONTEND_PATH="$PROJECT_ROOTPATH/frontend"
readonly DIST_PATH="$FRONTEND_PATH/dist"

cd "$FRONTEND_PATH" || exit 1

npm run build \
&& cp -rpf "$DIST_PATH"/* "$PROJECT_ROOTPATH" \
&& rm -rf "$DIST_PATH" && {
	echo -e "\n\e[0;32mBuild terminé avec succès.\e[0m"
	exit 0
}

echo -e "\n\e[0;31mLe build a échoué.\e[0m"
exit 1
