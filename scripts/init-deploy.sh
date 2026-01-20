#!/bin/bash
#
# CTF Challenge Deployment Config Generator
# Creates a deploy.config.json file for a challenge
#
# Usage: ./scripts/init-deploy.sh <challenge-path> [options]
#
# Examples:
#   ./scripts/init-deploy.sh Web/my-challenge
#   ./scripts/init-deploy.sh Web/my-challenge --framework=react --type=pages
#

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Default values
FRAMEWORK="nextjs"
TYPE="pages"
DEPLOY_DIR="deploy"
BUILD_CMD="npm run build"
INSTALL_CMD="npm ci"
ENABLED="true"

# Parse arguments
CHALLENGE_PATH="$1"
shift || true

while [[ $# -gt 0 ]]; do
  case $1 in
    --framework=*)
      FRAMEWORK="${1#*=}"
      shift
      ;;
    --type=*)
      TYPE="${1#*=}"
      shift
      ;;
    --deploy-dir=*)
      DEPLOY_DIR="${1#*=}"
      shift
      ;;
    --build=*)
      BUILD_CMD="${1#*=}"
      shift
      ;;
    --disabled)
      ENABLED="false"
      shift
      ;;
    -h|--help)
      echo "Usage: $0 <challenge-path> [options]"
      echo ""
      echo "Options:"
      echo "  --framework=<type>   Framework: nextjs, react, vue, svelte, static, node (default: nextjs)"
      echo "  --type=<type>        Deploy type: pages, worker (default: pages)"
      echo "  --deploy-dir=<dir>   Deploy directory (default: deploy)"
      echo "  --build=<cmd>        Build command (default: npm run build)"
      echo "  --disabled           Create config with enabled=false"
      echo "  -h, --help           Show this help"
      exit 0
      ;;
    *)
      echo -e "${RED}Unknown option: $1${NC}"
      exit 1
      ;;
  esac
done

# Validate challenge path
if [ -z "$CHALLENGE_PATH" ]; then
  echo -e "${RED}Error: Challenge path is required${NC}"
  echo "Usage: $0 <challenge-path> [options]"
  exit 1
fi

if [ ! -d "$CHALLENGE_PATH" ]; then
  echo -e "${RED}Error: Directory '$CHALLENGE_PATH' does not exist${NC}"
  exit 1
fi

# Check if deploy.config.json already exists
CONFIG_FILE="$CHALLENGE_PATH/deploy.config.json"
if [ -f "$CONFIG_FILE" ]; then
  echo -e "${YELLOW}Warning: $CONFIG_FILE already exists${NC}"
  read -p "Overwrite? [y/N] " -n 1 -r
  echo
  if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Aborted."
    exit 0
  fi
fi

# Extract challenge name from path
CHALLENGE_NAME=$(basename "$CHALLENGE_PATH")
DISPLAY_NAME=$(echo "$CHALLENGE_NAME" | sed 's/-/ /g' | sed 's/\b\w/\u&/g')

# Calculate schema path relative to challenge
DEPTH=$(echo "$CHALLENGE_PATH" | tr -cd '/' | wc -c)
SCHEMA_PATH=$(printf '../%.0s' $(seq 1 $((DEPTH + 1))))
SCHEMA_PATH="${SCHEMA_PATH}.github/deploy.schema.json"

# Determine output directory based on framework
case $FRAMEWORK in
  nextjs)
    OUTPUT_DIR=".vercel/output/static"
    ;;
  react)
    OUTPUT_DIR="build"
    ;;
  vue)
    OUTPUT_DIR="dist"
    ;;
  svelte)
    OUTPUT_DIR="build"
    ;;
  static)
    OUTPUT_DIR="."
    BUILD_CMD="echo 'No build needed'"
    ;;
  *)
    OUTPUT_DIR="dist"
    ;;
esac

# Create the config file
cat > "$CONFIG_FILE" << EOF
{
  "\$schema": "$SCHEMA_PATH",
  "name": "$DISPLAY_NAME",
  "enabled": $ENABLED,
  "type": "$TYPE",
  "framework": "$FRAMEWORK",
  "deploy_directory": "$DEPLOY_DIR",
  "install_command": "$INSTALL_CMD",
  "build_command": "$BUILD_CMD",
  "output_directory": "$OUTPUT_DIR",
  "subdomain": "$CHALLENGE_NAME",
  "env": {
    "NODE_ENV": "production"
  },
  "node_version": "20"
}
EOF

echo -e "${GREEN}Created $CONFIG_FILE${NC}"
echo ""
echo -e "${BLUE}Configuration:${NC}"
echo "  Name: $DISPLAY_NAME"
echo "  Framework: $FRAMEWORK"
echo "  Type: $TYPE"
echo "  Deploy Dir: $DEPLOY_DIR"
echo "  Enabled: $ENABLED"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "  1. Review and customize $CONFIG_FILE"
echo "  2. Set 'enabled' to true when ready"
echo "  3. Push to main branch to trigger deployment"
echo ""
echo -e "${GREEN}Full docs: .github/DEPLOYMENT.md${NC}"
