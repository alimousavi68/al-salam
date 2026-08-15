<?php
/**
 * Custom Walker for Primary Navigation Menu
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

class Alsalam_Nav_Walker extends Walker_Nav_Menu {
    
    // Starts the element output.
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
        
        // Fallback for Front Page (especially with Polylang ?lang=en query strings)
        if (!$is_active && (is_front_page() || is_home())) {
            $item_url = untrailingslashit(strtok($item->url, '?'));
            $home_url = untrailingslashit(strtok(home_url('/'), '?'));
            if ($item_url === $home_url || strpos($item->url, '#home') !== false) {
                $is_active = true;
            }
        }
        
        // Custom classes for the <a> tag
        $a_classes = 'nav-link-item relative flex items-center gap-2 text-sm font-medium transition-all duration-200 focus:outline-none ';
        $a_classes .= $is_active ? 'text-white' : 'text-white/80 hover:text-white focus:text-white';
        
        $output .= '<li class="relative group">';
        
        $attributes  = '';
        $attributes .= !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
        $attributes .= ' class="' . esc_attr($a_classes) . '"';
        $attributes .= ' data-nav-link="true"'; // Add JS hook for app.js
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        
        $dot_classes = 'nav-dot w-2 h-2 rounded-full bg-primary-light shadow-[0_0_8px_#79F5FF] shrink-0 transition-all duration-200 ';
        $dot_classes .= $is_active ? 'opacity-100 scale-100' : 'opacity-0 scale-0 group-hover:opacity-50 group-hover:scale-75';
        
        $label_classes = 'nav-label transition-colors duration-200 ';
        $label_classes .= $is_active ? 'text-primary-light font-semibold' : '';
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= '<span class="' . esc_attr($dot_classes) . '" aria-hidden="true"></span>';
        $item_output .= '<span class="' . esc_attr($label_classes) . '">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</span>';
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

class Alsalam_Footer_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $output .= '<li class="relative group">';
        
        $attributes  = '';
        $attributes .= !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
        $attributes .= ' class="flex items-center gap-3 group"';
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= '<span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>';
        $item_output .= '<span class="text-slate-700 group-hover:text-teal-600 text-sm font-medium transition-colors">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</span>';
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
