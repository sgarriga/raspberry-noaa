#!/bin/bash

## import common lib
. "$HOME/.noaa.conf"
. "$NOAA_HOME/common.sh"

for img_set_name in $(sqlite3 ${NOAA_HOME}/panel.db "select file_path from decoded_passes where pass_start < strftime('%s','now', '-3 days');"); do
    rm -f ${NOAA_OUTPUT}/images/${img_set_name}*.jpg
    rm -f ${NOAA_OUTPUT}/images/thumb/${img_set_name}*.jpg
    log "${img_set_name} files pruned" "INFO"
    sqlite3 "${NOAA_HOME}/panel.db" "delete from predict_passes where pass_start = (select pass_start from decoded_passes where file_path = \"$img_set_name\");"
    sqlite3 "${NOAA_HOME}/panel.db" "delete from decoded_passes where file_path = \"$img_set_name\";"
    log "Database entres pruned" "INFO"
done
