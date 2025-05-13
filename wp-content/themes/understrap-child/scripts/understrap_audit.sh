#!/bin/bash

# Set script and project root
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"
DATE_STR=$(date "+%Y-%m-%d %H:%M:%S")

# Output destinations
OUT_FILE_LOCAL="$SCRIPT_DIR/understrap_code_audit.txt"
OUT_FILE_DESKTOP=~/Desktop/understrap_code_audit.txt

# Reset output
> "$OUT_FILE_LOCAL"
> "$OUT_FILE_DESKTOP"

# Output header
print_header() {
  echo "Understrap Child Theme Code Audit - $DATE_STR"
  echo "Root: $PROJECT_ROOT"
  echo "---------------------------------------------"
}

# Write file section with filters
write_section() {
  local section_name=$1
  local file_glob=$2
  local file_filter=$3

  echo -e "\n🗂️  $section_name Files" >> "$OUT_FILE_LOCAL"
  echo "---------------------------------------------" >> "$OUT_FILE_LOCAL"

  find "$PROJECT_ROOT" -type f -name "$file_glob" \
    | grep -Ev "node_modules|vendor|/dist/" \
    | grep -E "$file_filter" \
    | while read -r file; do
        REL_PATH="${file#$PROJECT_ROOT/}"
        echo -e "\n🔹 $REL_PATH\n" >> "$OUT_FILE_LOCAL"
        cat "$file" >> "$OUT_FILE_LOCAL"
        echo -e "\n---------------------------------------------" >> "$OUT_FILE_LOCAL"
    done
}

# Run
print_header >> "$OUT_FILE_LOCAL"

# 1. SCSS from src/sass
write_section "SCSS" "*.scss" "src/sass"

# 2. PHP - targeted files/folders
write_section "INC Folder (PHP + JSON)" "*" "inc/"

# 3. Project Root Config Files
write_section "Config Files" "package.json" "."
write_section "Config Files" ".gitignore" "."

# Copy to Desktop
cp "$OUT_FILE_LOCAL" "$OUT_FILE_DESKTOP"

# Final confirmation
echo "✅ Audit complete!"
echo "   ➤ Saved to: $OUT_FILE_LOCAL"
echo "   ➤ Copied to: $OUT_FILE_DESKTOP"
