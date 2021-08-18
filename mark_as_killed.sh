#!/bin/bash

pid=`ps -q $(pgrep rtl_fm) -f --no-headers | awk '{ print $3; }'`
ppid=`ps -q $pid -f --no-headers | awk '{ print $3; }'`
pass_start=`ps -q $ppid -f --no-headers | awk '{ print $15; }'`
echo marking process for $pass_start as stopped early
sqlite3 $NOAA_HOME/panel.db "update predict_passes set is_active = 4 where pass_start = $pass_start);"

