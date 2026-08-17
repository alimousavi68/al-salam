import os
import re

total_replacements = 0

def process_file(filepath):
    global total_replacements
    with open(filepath, 'r') as f:
        content = f.read()

    original_content = content
    
    # 1. alsalam_str('key', get_theme_mod(...)) -> pll__(get_theme_mod(...))
    content = re.sub(r"alsalam_str\s*\(\s*['\"][^'\"]*['\"]\s*,\s*(get_theme_mod\([^)]+\))\s*\)", r"pll__(\1)", content)
    
    # 2. alsalam_str('key', 'default_value') -> pll__('default_value')
    content = re.sub(r"alsalam_str\s*\(\s*['\"][^'\"]*['\"]\s*,\s*(['\"][^'\"]*['\"])\s*\)", r"pll__(\1)", content)
    
    # 3. alsalam_str('key', $variable) -> pll__($variable)
    content = re.sub(r"alsalam_str\s*\(\s*['\"][^'\"]*['\"]\s*,\s*(\$[a-zA-Z0-9_>-]+)\s*\)", r"pll__(\1)", content)
    
    # 4. alsalam_str('key') -> pll__('key')
    content = re.sub(r"alsalam_str\s*\(\s*(['\"][^'\"]*['\"])\s*\)", r"pll__(\1)", content)

    if content != original_content:
        diff = original_content.count('alsalam_str') - content.count('alsalam_str')
        total_replacements += diff
        with open(filepath, 'w') as f:
            f.write(content)
        print(f"Updated {filepath}")

for root, dirs, files in os.walk('.'):
    if 'node_modules' in dirs:
        dirs.remove('node_modules')
    if 'vendor' in dirs:
        dirs.remove('vendor')
    for file in files:
        if file.endswith('.php'):
            process_file(os.path.join(root, file))

print(f'Total replacements: {total_replacements}')
