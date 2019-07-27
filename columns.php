<?php
/*
 * columns
 */

class Space_Admin_Column_Manager {
	static function get_column_slugs( $page_slug = 'posts', $prefix = 'admin-column-manager-posts-' ) {

		$columns = self::get_column_info( $page_slug );
		$column_slugs = array();

		foreach ( $columns as $column_slug => $column_info ) {
			$column_slugs[] = $prefix . $column_slug;
		}

		return $column_slugs;

	}

	static function get_page_name( $page_slug = 'posts' ) {

		$page_names = array(
			'posts' => __( '<br>Posts' ),
			'pages' => __( '<br>Pages' ),
			'media' => __( '<br>Media' ),
			'users' => __( '<br>Users' ),
			'woocommerce-products' => __( 'WooCommerce products', 'space' ),
			'woocommerce-orders' => __( 'WooCommerce orders', 'space' ),
			'woocommerce-coupons' => __( 'WooCommerce coupons', 'space' )
		);
		return isset( $page_names[ $page_slug ] ) ? $page_names[ $page_slug ] : '';

	}

	static function get_column_info( $page = '' ) {

		$columns = array(
			'posts' => array(
				'author' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-author',
						'title' => _x( 'Author', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'categories' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-categories',
						'title' => _x( 'Categories', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'tags' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-tags',
						'title' => _x( 'Tags', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'comments' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-comments',
						'title' => _x( 'Comments', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-date',
						'title' => _x( 'Date', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0
						)
					)
				)
			),
			'pages' => array(
				'author' => array(
					'field' => array(
						'name' => 'admin-column-manager-pages-author',
						'title' => _x( 'Author', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0
						)
					)
				),
				'comments' => array(
					'field' => array(
						'name' => 'admin-column-manager-pages-comments',
						'title' => _x( 'Comments', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0
						)
					)
				),
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-pages-date',
						'title' => _x( 'Date', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0
						)
					)
				)
			),
			'media' => array(
				'icon' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-icon',
						'title' => _x( 'Thumbnail', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'author' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-author',
						'title' => _x( 'Author', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'parent' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-parent',
						'title' => _x( 'Uploaded to', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'comments' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-comments',
						'title' => _x( 'Comments', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-date',
						'title' => _x( 'Date', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				)
			),
			'users' => array(
				'username' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-username',
						'title' => __( 'Username' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'name' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-name',
						'title' => _x( 'Full Name', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'email' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-email',
						'title' => _x( 'E-mail', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'role' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-role',
						'title' => _x( 'Role', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'posts' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-posts',
						'title' => _x( 'Posts', 'Admin column title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'space-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				)
			)
		);

		// wc
		if ( class_exists( 'WooCommerce' ) ) {
			$columns['woocommerce-products'] = array(
				'thumb' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-thumb',
						'title' => __( 'Product image', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'name' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-name',
						'title' => __( 'Product title', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'sku' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-sku',
						'title' => __( 'SKU', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'is_in_stock' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-is_in_stock',
						'title' => __( 'Stock options', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'price' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-price',
						'title' => __( 'Price', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'product_cat' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-product_cat',
						'title' => __( 'Categories', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'product_tag' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-product_tag',
						'title' => __( 'Tags', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'featured' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-featured',
						'title' => __( 'Featured product', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'product_type' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-product_type',
						'title' => __( 'Product type', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-products-date',
						'title' => __( 'Date', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				)
			);
			$columns['woocommerce-orders'] = array(
				'order_status' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_status',
						'title' => __( 'Order status', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'order_title' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_title',
						'title' => __( 'Order', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'order_items' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_items',
						'title' => __( 'Order items', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'billing_address' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-billing_address',
						'title' => __( 'Billing address', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'shipping_address' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-shipping_address',
						'title' => __( 'Shipping address', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'customer_message' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-customer_message',
						'title' => __( 'Customer message', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'order_notes' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_notes',
						'title' => __( 'Order notes', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'order_date' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_date',
						'title' => __( 'Order date', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'order_total' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_total',
						'title' => __( 'Order total', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'order_actions' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-orders-order_actions',
						'title' => __( 'Order actions', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				)
			);
			$columns['woocommerce-coupons'] = array(
				'coupon_code' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-coupon_code',
						'title' => __( 'Coupon code', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'type' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-type',
						'title' => __( 'Coupon type', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'amount' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-amount',
						'title' => __( 'Coupon value', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'description' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-description',
						'title' => __( 'Description', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'products' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-products',
						'title' => __( 'Product IDs', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'usage' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-usage',
						'title' => __( 'Usage / Limit', 'woocommerce' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
				'expiry_date' => array(
					'field' => array(
						'name' => 'admin-column-manager-woocommerce-coupons-expiry_date',
						'title' => __( 'Expiry date', 'space' ),
						'secondary-title' => __( 'Enable', 'space' ),
						'type' => 'checkbox',
						'role-based' => false,
						'default' => 1
					)
				),
			);
		}

		// seo
		if ( defined( 'WPSEO_FILE' ) ) {
			$columns['posts']['wpseo-links'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-links',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Internal links', 'space' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['posts']['wpseo-score'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-score',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'SEO score', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['posts']['wpseo-score-readability'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-score-readability',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Readability score', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['posts']['wpseo-title'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-title',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'SEO Title', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['posts']['wpseo-metadesc'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-metadesc',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Meta Desc.', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['posts']['wpseo-focuskw'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-focuskw',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Focus KW', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['posts']['wpseo-links'] = array(
				'field' => array(
					'name' => 'admin-column-manager-posts-wpseo-links',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Internal links', 'space' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);

			$columns['pages']['wpseo-links'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-links',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Internal links', 'space' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['pages']['wpseo-score'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-score',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'SEO score', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['pages']['wpseo-score-readability'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-score-readability',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Readability score', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['pages']['wpseo-title'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-title',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'SEO Title', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['pages']['wpseo-metadesc'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-metadesc',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Meta Desc.', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);
			$columns['pages']['wpseo-focuskw'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-focuskw',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Focus KW', 'wordpress-seo' ) ),
					'secondary-title' => __( 'Enable for %s', 'space' ),
					'type' => 'checkbox',
					'role-based' => true,
					'default' => 1
				)
			);
			$columns['pages']['wpseo-links'] = array(
				'field' => array(
					'name' => 'admin-column-manager-pages-wpseo-links',
					'title' => sprintf( __( 'Yoast SEO: %s', 'space' ), __( 'Internal links', 'space' ) ),
					'secondary-title' => __( 'Enable', 'space' ),
					'type' => 'checkbox',
					'role-based' => false,
					'default' => 1
				)
			);

		}
		if ( $page ) {
			return isset( $columns[ $page ] ) ? $columns[ $page ] : array();
		}
		return $columns;

	}

	static function remove_page_columns( $page = 'posts', $original_columns = array() ) {

		if ( ! Space_Options::get_saved_option( 'enable-admin-column-manager-tool' ) && ! Space_Options::get_saved_network_option( 'disable-admin-column-manager-tool' ) ) {
			return $original_columns;
		}

		$columns = self::get_column_info( $page );
		foreach ( $columns as $column_slug => $column_info ) {
			if ( ! isset( $original_columns[ $column_slug ] ) ) {
				continue;
			}
			if ( Space_Options::get_saved_network_option( 'disable-admin-column-manager-tool' ) ) {
				$column_is_enabled = Space_Options::get_saved_network_default_option( 'admin-column-manager-' . $page . '-' . $column_slug );
			}
			else {
				$column_is_enabled = Space_Options::get_saved_option( 'admin-column-manager-' . $page . '-' . $column_slug );
			}

			if ( ! $column_is_enabled ) {
				unset( $original_columns[ $column_slug ] );
			}

		}
		return $original_columns;

	}

	static function filter_remove_posts_columns( $columns ) {
		return self::remove_page_columns( 'posts', $columns );
	}

	static function filter_remove_pages_columns( $columns ) {
		return self::remove_page_columns( 'pages', $columns );
	}

	static function filter_remove_users_columns( $columns ) {
		return self::remove_page_columns( 'users', $columns );
	}

	static function filter_remove_media_columns( $columns ) {
		return self::remove_page_columns( 'media', $columns );
	}

	static function filter_remove_woocommerce_product_columns( $columns ) {
		return self::remove_page_columns( 'woocommerce-products', $columns );
	}

	static function filter_remove_woocommerce_order_columns( $columns ) {
		return self::remove_page_columns( 'woocommerce-orders', $columns );
	}

	static function filter_remove_woocommerce_coupon_columns( $columns ) {
		return self::remove_page_columns( 'woocommerce-coupons', $columns );
	}

}
?>
