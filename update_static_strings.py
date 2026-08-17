import os
import re

directories_to_scan = ['.']
strings_to_register = set()

# Regex to find $meta('...', 'default') or get_theme_mod('...', 'default')
pattern_meta = re.compile(r"\$meta\s*\(\s*'[^']+'\s*,\s*('[^']+')\s*\)")
pattern_meta_double = re.compile(r'\$meta\s*\(\s*\'[^\']+\'\s*,\s*("[^"]+")\s*\)')
pattern_mod = re.compile(r"get_theme_mod\s*\(\s*'[^']+'\s*,\s*('[^']+')\s*\)")
pattern_hero_title = re.compile(r"\$meta\s*\(\s*'_alsalam_hero_title'\s*\)\s*\?:\s*('[^']+')")

for directory in directories_to_scan:
    for root, dirs, files in os.walk(directory):
        if 'node_modules' in dirs:
            dirs.remove('node_modules')
        if 'vendor' in dirs:
            dirs.remove('vendor')
        for file in files:
            if file.endswith('.php'):
                filepath = os.path.join(root, file)
                with open(filepath, 'r') as f:
                    content = f.read()
                    
                for match in pattern_meta.findall(content):
                    strings_to_register.add(match)
                for match in pattern_meta_double.findall(content):
                    strings_to_register.add(match)
                for match in pattern_mod.findall(content):
                    strings_to_register.add(match)
                for match in pattern_hero_title.findall(content):
                    strings_to_register.add(match)

strings_list = list(strings_to_register)

with open('includes/polylang-strings.php', 'r') as f:
    content = f.read()

# Find the end of $static_strings = [
start_idx = content.find('$static_strings = [')
if start_idx != -1:
    end_idx = content.find('];', start_idx)
    if end_idx != -1:
        current_array = content[start_idx:end_idx]
        new_array = current_array
        for string in strings_list:
            if string not in new_array:
                new_array += f"        {string},\n"
        
        new_content = content[:start_idx] + new_array + content[end_idx:]
        with open('includes/polylang-strings.php', 'w') as f:
            f.write(new_content)
        print(f"Added {len(strings_list)} strings to static strings array.")
