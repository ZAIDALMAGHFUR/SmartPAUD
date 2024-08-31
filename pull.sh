#!/bin/bash

# Ganti `your_token_here` dengan token akses personal GitHub Anda
GITHUB_TOKEN=""

echo "Pulling latest changes from the repository..."
git pull https://ZAIDALMAGHFUR:$GITHUB_TOKEN@github.com/ZAIDALMAGHFUR/SmartPAUD.git

echo "Pull completed."
