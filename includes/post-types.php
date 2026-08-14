<?php
/**
 * Register Custom Post Types & Taxonomies for AL-SALAM Theme
 * - Products (alsalam_product)
 * - Gallery (alsalam_gallery)
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

add_action('init', 'alsalam_register_custom_post_types');
function alsalam_register_custom_post_types() {
    // 1. PRODUCTS CPT
    $product_labels = [
        'name'               => __('Products', 'alsalam'),
        'singular_name'      => __('Product', 'alsalam'),
        'menu_name'          => __('Products', 'alsalam'),
        'add_new'            => __('Add New Product', 'alsalam'),
        'add_new_item'       => __('Add New Product', 'alsalam'),
        'edit_item'          => __('Edit Product', 'alsalam'),
        'new_item'           => __('New Product', 'alsalam'),
        'view_item'          => __('View Product', 'alsalam'),
        'search_items'       => __('Search Products', 'alsalam'),
        'not_found'          => __('No products found', 'alsalam'),
        'not_found_in_trash' => __('No products found in Trash', 'alsalam'),
    ];

    $product_args = [
        'labels'             => $product_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'products', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-products',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'       => true,
    ];

    register_post_type('alsalam_product', $product_args);

    // Product Category Taxonomy
    register_taxonomy('product_cat', 'alsalam_product', [
        'labels' => [
            'name'          => __('Product Categories', 'alsalam'),
            'singular_name' => __('Product Category', 'alsalam'),
        ],
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'hierarchical'      => true,
        'rewrite'           => ['slug' => 'product-category'],
    ]);

    // 2. GALLERY CPT
    $gallery_labels = [
        'name'               => __('Gallery Items', 'alsalam'),
        'singular_name'      => __('Gallery Item', 'alsalam'),
        'menu_name'          => __('Gallery', 'alsalam'),
        'add_new'            => __('Add New Photo', 'alsalam'),
        'add_new_item'       => __('Add New Gallery Item', 'alsalam'),
        'edit_item'          => __('Edit Gallery Item', 'alsalam'),
        'search_items'       => __('Search Gallery', 'alsalam'),
        'not_found'          => __('No gallery items found', 'alsalam'),
    ];

    $gallery_args = [
        'labels'             => $gallery_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'gallery-item', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest'       => true,
    ];

    register_post_type('alsalam_gallery', $gallery_args);

    // Gallery Category Taxonomy
    register_taxonomy('gallery_cat', 'alsalam_gallery', [
        'labels' => [
            'name'          => __('Gallery Categories', 'alsalam'),
            'singular_name' => __('Gallery Category', 'alsalam'),
        ],
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'hierarchical'      => true,
        'rewrite'           => ['slug' => 'gallery-category'],
    ]);
}
