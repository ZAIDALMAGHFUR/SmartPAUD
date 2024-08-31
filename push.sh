#!/bin/bash

# Replace these variables with your actual details
REPO_URL="https://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@github.com/ZAIDALMAGHFUR/SmartPAUD.git"
BRANCH="main"

# Add all changes
git add .

# Commit changes with a message
git commit -m "Your commit message"

# Push changes to GitHub
git push --progress "$REPO_URL" "$BRANCH:$BRANCH"
