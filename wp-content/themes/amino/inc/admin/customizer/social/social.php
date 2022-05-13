<?php
$social_list  = array (
	''   => '',
	'facebook'   => esc_html__( 'Facebook', 'amino' ),
	'twitter'    => esc_html__( 'Twitter', 'amino' ),
	'google'     => esc_html__( 'Google+', 'amino' ),
	'instagram'  => esc_html__( 'Instagram', 'amino' ),
	'pinterest'  => esc_html__( 'Pinterest', 'amino' ),
	'whatsapp'   => esc_html__( 'Whatsapp', 'amino' ),
	'rss'        => esc_html__( 'RSS', 'amino' ),
	'tumblr'     => esc_html__( 'Tumblr', 'amino' ),
	'youtube'    => esc_html__( 'Youtube', 'amino' ),
	'vimeo'      => esc_html__( 'Vimeo', 'amino' ),
	'behance'    => esc_html__( 'Behance', 'amino' ),
	'dribbble'   => esc_html__( 'Dribbble', 'amino' ),
	'flickr'     => esc_html__( 'Flickr', 'amino' ),
	'github'     => esc_html__( 'GitHub', 'amino' ),
	'skype'      => esc_html__( 'Skype', 'amino' ),
	'snapchat'   => esc_html__( 'Snapchat', 'amino' ),
	'wechat'     => esc_html__( 'WeChat', 'amino' ),
	'weibo'      => esc_html__( 'Weibo', 'amino' ),
	'foursquare' => esc_html__( 'Foursquare', 'amino' ),
	'soundcloud' => esc_html__( 'Soundcloud', 'amino' ),
	'vk'         => esc_html__( 'VK', 'amino' ),
);
Kirki::add_section( 'social', array(
    'priority'    => 55,
    'title'       => esc_html__( 'Social', 'amino' ),
) );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'social_sharing_part',
	'section'     => 'social',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Social sharing', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'sortable',
	'settings'    => 'social_sharing',
	'label'       => esc_html__( 'Social sharing in Single page', 'amino' ),
	'section'     => 'social',
	'default'     => [
		'facebook',
		'pinterest',
		'twitter'
	],
	'choices'     => [
		'facebook' => esc_html__( 'Facebook', 'amino' ),
		'pinterest' => esc_html__( 'Pinterest', 'amino' ),
		'twitter' => esc_html__( 'Twitter', 'amino' ),
		'whatsapp' => esc_html__( 'Whatsapp', 'amino' ),
		'email' => esc_html__( 'Email', 'amino' ),
		'vk' => esc_html__( 'VK', 'amino' ),
		'linkedin' => esc_html__( 'LinkedIn', 'amino' ),
		'telegram' => esc_html__( 'Telegram', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'social_list_part',
	'section'     => 'social',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Social List', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Social list', 'amino' ),
	'section'     => 'social',
	'priority'    => 10,
	'row_label' => [
		'type'  => 'field',
		'value' => esc_attr__( 'Element', 'amino' ),
		'field' => 'name',
	],
	'button_label' => esc_html__('Add new', 'amino' ),
	'settings'     => 'social_list',
	
	'fields' => [
		'name' => [
			'type'        => 'select',
			'label'       => esc_html__( 'Social', 'amino' ),
			'description' => esc_html__( 'Select a social network', 'amino' ),
			'default'     => '',
			'choices'     => $social_list,
		],
		'url'  => [
			'type'        => 'text',
			'label'       => esc_html__( 'Social URL', 'amino' ),
			'default'     => '',
		],
	]
] );