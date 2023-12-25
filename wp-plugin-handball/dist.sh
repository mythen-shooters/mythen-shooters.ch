#!/bin/bash
rm handball.zip
zip -r handball.zip . -x ".git/*" -x "*.yaml" -x "*.sh" -x ".gitignore" -x "README.md"
