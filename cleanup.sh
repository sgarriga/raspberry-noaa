#!/bin/bash

## import common lib
. "$HOME/.noaa.conf"
. "$NOAA_HOME/common.sh"

for img_set_name in `sqlite3 panel.db "select file_path from decoded_passes" | tr '\n' ' '`; do

    # check at least one image file exists
    ls ${NOAA_OUTPUT}/images/${img_set_name}* >> /dev/null 2>&1
    cs=$?

    # if not then purge from DB
    if [ $cs -ne 0 ]; then
        sqlite3 "${NOAA_HOME}/panel.db" "delete from decoded_passes where file_path = \"$img_set_name\";"
    fi
done
