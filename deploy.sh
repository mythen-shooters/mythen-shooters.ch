#!/bin/bash

rsync -r --verbose --update ./wp-theme-shooters/shooters/* suterale@hc-goldau.ch:/home/suterale/www/hopp.mythen-shooters.ch/wp-content/themes/shooters
rsync -r --verbose --update ./wp-plugin-handball/handball/* suterale@hc-goldau.ch:/home/suterale/www/hopp.mythen-shooters.ch/wp-content/plugins/handball
