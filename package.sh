#!/bin/bash

# Package script for Retool Video Platform
# Creates a distributable archive with all necessary files

echo "📦 Packaging Retool Video Platform..."

# Set variables
PACKAGE_NAME="retool_video_platform_refactored"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
ARCHIVE_NAME="${PACKAGE_NAME}_${TIMESTAMP}.zip"

# Create temporary directory
TEMP_DIR="/tmp/${PACKAGE_NAME}"
rm -rf "$TEMP_DIR"
mkdir -p "$TEMP_DIR"

echo "📋 Copying files..."

# Copy all necessary files
cp -r public "$TEMP_DIR/"
cp -r src "$TEMP_DIR/"
cp -r database "$TEMP_DIR/"
cp -r assets "$TEMP_DIR/"
cp -r docker "$TEMP_DIR/"
cp -r docs "$TEMP_DIR/"

# Copy configuration files
cp Dockerfile "$TEMP_DIR/"
cp docker-compose.yml "$TEMP_DIR/"
cp README.md "$TEMP_DIR/"
cp DEPLOYMENT.md "$TEMP_DIR/"
cp ARCHITECTURE.md "$TEMP_DIR/"
cp package.sh "$TEMP_DIR/"

# Create cache directory
mkdir -p "$TEMP_DIR/cache"

# Create .gitignore
cat > "$TEMP_DIR/.gitignore" << 'EOF'
# Database
database/retool.db
database/*.db

# Cache
cache/*
!cache/.gitkeep

# Uploads
public/uploads/*
!public/uploads/.gitkeep

# Logs
*.log

# OS files
.DS_Store
Thumbs.db

# IDE
.vscode/
.idea/
*.swp
*.swo

# Environment
.env
EOF

# Create cache .gitkeep
touch "$TEMP_DIR/cache/.gitkeep"

# Create uploads directory
mkdir -p "$TEMP_DIR/public/uploads"
touch "$TEMP_DIR/public/uploads/.gitkeep"

echo "🗜️  Creating archive..."

# Create zip archive
cd /tmp
zip -r "$ARCHIVE_NAME" "${PACKAGE_NAME}" -q

# Move to workspace
mv "$ARCHIVE_NAME" /workspace/

# Cleanup
rm -rf "$TEMP_DIR"

echo "✅ Package created: $ARCHIVE_NAME"
echo "📍 Location: /workspace/$ARCHIVE_NAME"
echo ""
echo "📦 Package contents:"
echo "   - Source code (PHP MVC architecture)"
echo "   - Database schema and seeder"
echo "   - Docker configuration"
echo "   - Documentation (README, DEPLOYMENT, ARCHITECTURE)"
echo "   - Static assets (CSS, JS)"
echo ""
echo "🚀 Ready for deployment!"