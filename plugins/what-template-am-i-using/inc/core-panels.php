<?php

class WTAIU_Theme_Panel extends WTAIU_Panel
{
    public function __construct()
    {
        parent::__construct( __('Theme', 'wtaiu'), 'wtaiu-theme-panel' );
        $this->default_open_state = 'closed';
    }

    public function get_content()
    {
        $theme =  wp_get_theme();
        $info  = array();
        do{
            $info[] = $this->get_theme_info_html( $theme );
            $theme  = $theme->parent();
        } while( $theme !== false );
        // WP currently only supports child themes, not grandchild themes. This loop should run at most two times.
        return implode( '', $info );
    }

    protected function get_theme_info_html( WP_Theme $theme )
    {
        $name            = $theme->display('Name');
        $version         = $theme->display('Version');
        $description     = $theme->display('Description');
        $desc_title      = esc_attr( $theme->get('Description') );
        $author          = $theme->display('Author');
        $screenshot      = $theme->get_screenshot();
        $thumbnail_style = $screenshot !== false ? sprintf('style="background-image:url(%s);"', $screenshot ) : '';
        $theme_url       = network_admin_url( add_query_arg('theme', $theme->get_stylesheet(), 'themes.php') );
        $version_label   = __('Version:', 'wtaiu');
        $author_label    = __('By', 'wtaiu');

$output=<<<OUTPUT

<div class="theme-info" title="{$desc_title}">
    <a href="{$theme_url}" class="theme-screenshot" {$thumbnail_style}></a>
    <div class="theme-info-wrap">
        <h3 class="theme-info-header" title="{$name}">
            <a href="{$theme_url}" class="theme-name">{$name}</a>
        </h3>
        <p class="theme-version">{$version_label} {$version}</p>
        <p class="theme-author">{$author_label} {$author}</p>
    </div>
</div>

OUTPUT;

        return $output;
    }
}

class WTAIU_Template_Panel extends WTAIU_Panel
{
    public function __construct()
    {
        parent::__construct( __('Template', 'wtaiu'), 'wtaiu-template-panel' );
    }

    public function get_content()
    {
        global $template;
        return sprintf('<p>%1$s</p>', str_replace( get_theme_root(), '', $template ) );
    }

    public function get_help()
    {
        return '<p>'.sprintf(__('Please see the %stemplate hierarchy%s for more details.', 'wtaiu'), '<a href="https://codex.wordpress.org/Template_Hierarchy" target="_blank">', '</a>').'</p>';
    }
}

class WTAIU_General_Info_Panel extends WTAIU_Panel
{
    const VERSION = '0.1.0';

    public function __construct()
    {
        parent::__construct( __('General Information', 'wtaiu'), 'wtaiu-general-info-panel' );
        $this->author     = 'Eric King';
        $this->author_url = 'http://webdeveric.com/';
    }

    public function get_content()
    {
        global $post;

        $yes =  __('Yes', 'wtaiu');
        $no  =  __('No', 'wtaiu');

        $post_type  = isset( $post, $post->post_type ) ? $post->post_type : __('not set', 'wtaiu');
        $front_page = is_front_page() ? $yes : $no;
        $home_page  = is_home()       ? $yes : $no;
        $is_404     = is_404()        ? $yes : $no;
        $is_search  = is_search()     ? $yes : $no;

        $post_type_label = __('Post Type', 'wtaiu');
        $front_label     = __('Front', 'wtaiu');
        $home_label      = __('Home', 'wtaiu');
        $is404_label     = __('404', 'wtaiu');
        $search_label    = __('Search', 'wtaiu');

$info=<<<INFO
    <table class="info-table">
        <tbody>
            <tr>
                <th scope="row">{$post_type_label}</th>
                <td>{$post_type}</td>
            </tr>
            <tr>
                <th scope="row">{$front_label}</th>
                <td>{$front_page}</td>
            </tr>
            <tr>
                <th scope="row">{$home_label}</th>
                <td>{$home_page}</td>
            </tr>
            <tr>
                <th scope="row">{$is404_label}</th>
                <td>{$is_404}</td>
            </tr>
            <tr>
                <th scope="row">{$search_label}</th>
                <td>{$is_search}</td>
            </tr>
        </tbody>
    </table>
INFO;

        return $info;
    }
}

class WTAIU_Additional_Files_Panel extends WTAIU_Panel
{
    protected $files;

    public function __construct()
    {
        parent::__construct( __('Additional Files Used', 'wtaiu'), 'wtaiu-additional-files-panel' );
        $this->files = array();
    }

    public function setup()
    {
        add_action( 'get_header',        array( $this, 'record_header' ), 10, 1 );
        add_action( 'get_footer',        array( $this, 'record_footer' ), 10, 1 );
        add_action( 'get_sidebar',       array( $this, 'record_sidebar' ), 10, 1 );
        add_filter( 'comments_template', array( $this, 'record_comment_template' ), 10, 1 );
    }

    public function record_header( $name )
    {
        $this->files[] = isset( $name ) ? "header-{$name}.php" : 'header.php';
    }

    public function record_footer( $name )
    {
        $this->files[] = isset( $name ) ? "footer-{$name}.php" : 'footer.php';
    }

    public function record_sidebar( $name )
    {
        $this->files[] = isset( $name ) ? "sidebar-{$name}.php" : 'sidebar.php';
    }

    public function record_comment_template( $theme_template )
    {
        $this->files[] = ltrim( str_replace( STYLESHEETPATH, '', $theme_template ), '/');
        return $theme_template;
    }

    public function get_content()
    {
        global $wp_actions;

        foreach ( $wp_actions as $action_name => $num ) {
            $matches = array();
            if ( preg_match('#get_template_part_(?<slug>.+)#', $action_name, $matches ) )
                $this->files[] = $matches['slug'];
        }

        if ( ! empty( $this->files ) ) {
            return sprintf('<p>%1$s</p>', implode(', ', $this->files ) );
        }

        return '';
    }

    public function get_help()
    {
        $references = array(
            'get_header'        => 'https://codex.wordpress.org/Function_Reference/get_header',
            'get_footer'        => 'https://codex.wordpress.org/Function_Reference/get_footer',
            'get_sidebar'       => 'https://codex.wordpress.org/Function_Reference/get_sidebar',
            'get_template_part' => 'https://codex.wordpress.org/Function_Reference/get_template_part',
        );

        $messages = array();

        foreach ( $references as $func => $url ) {
            $messages[] = sprintf('<a href="%1$s" target="_blank">%2$s()</a>', $url, $func );
        }

        return '<p>'.__('References', 'wtaiu').': '. implode(', ', $messages ).'</p>';
    }
}

class WTAIU_Dynamic_Sidebar_Info_Panel extends WTAIU_Panel
{
    protected $sidebars;

    public function __construct()
    {
        parent::__construct( __('Sidebar Information', 'wtaiu'), 'wtaiu-dynamic-sidebar-info-panel' );
        $this->sidebars = array();
    }

    public function setup()
    {
        add_action( 'dynamic_sidebar_params', array( $this, 'record_dynamic_sidebar_params' ), 10, 1 );
    }

    public function record_dynamic_sidebar_params( $params )
    {
        $sidebar_name = $params[0]['name'];
        if ( ! array_key_exists( $sidebar_name, $this->sidebars ) )
            $this->sidebars[ $sidebar_name ] = array();
        $this->sidebars[ $sidebar_name ][] = $params[0]['widget_name'];
        return $params;
    }

    public function get_content()
    {
        if ( empty( $this->sidebars ) )
            return __('No sidebar widgets found', 'wtaiu');

        $info = array();
        $info[] = '<dl class="info-list">';
        foreach ( $this->sidebars as $sidebar_name => $widget_names ) {
            $widgets = array();
            $widgets[] = sprintf( '<ul title="'.__('Widgets used in %s', 'wtaiu').'">', $sidebar_name );
            foreach ( $widget_names as $widget_name ) {
                $widgets[] = sprintf('<li>%1$s</li>', $widget_name );
            }
            $widgets[] = '</ul>';
            $info[] = sprintf('<dt>%1$s<span class="counter">(%2$d)</span></dt><dd>%3$s</dd>', $sidebar_name, count( $widget_names ), implode('', $widgets ) );
        }
        $info[] = '</dl>';
        return implode('', $info );
    }
}

class WTAIU_WP_Dependencies_Panel extends WTAIU_Panel
{
    protected $dependencies;

    public function __construct( $label = 'Dependencies Used', $id = 'wtaiu-dependencies-panel' )
    {
        parent::__construct( $label, $id );
        $this->dependencies = array();
    }

    public function process_dependency_obj( WP_Dependencies $dep )
    {
        $deps = array_intersect_key( $dep->registered, $dep->groups );

        foreach ( $deps as $d ) {
            if ( isset( $d->src ) && $d->src != '' )
                $this->dependencies[] = sprintf('<li><a href="%2$s">%1$s</a></li>', $d->handle, $d->src );
        }

        $this->label .= sprintf('<span class="counter">(%d)</span>', count( $this->dependencies ) );
    }

    public function get_content()
    {
        return '<ul title="'.__('This lists all enqueued files, not just enqueued files from your theme.', 'wtaiu').'">' . implode('', $this->dependencies ) . '</ul>';
    }
}

class WTAIU_Scripts_Panel extends WTAIU_WP_Dependencies_Panel
{
    public function __construct()
    {
        parent::__construct( __('Enqueued Scripts', 'wtaiu'), 'wtaiu-enqueued-scripts' );
    }

    public function setup()
    {
        add_action( 'wp_footer', array( $this, 'find_enqueued_scripts' ), 1 );
    }

    public function find_enqueued_scripts()
    {
        global $wp_scripts;
        $this->process_dependency_obj( $wp_scripts );
    }
}

class WTAIU_Styles_Panel extends WTAIU_WP_Dependencies_Panel
{
    public function __construct()
    {
        parent::__construct( __('Enqueued Styles', 'wtaiu'), 'wtaiu-enqueued-styles' );
    }

    public function setup()
    {
        add_action( 'wp_footer', array( $this, 'find_enqueued_styles' ), 1 );
    }

    public function find_enqueued_styles()
    {
        global $wp_styles;
        $this->process_dependency_obj( $wp_styles );
    }
}

class WTAIU_IP_Addresses_Panel extends WTAIU_Panel
{
    public function __construct()
    {
        parent::__construct( __('IP Addresses', 'wtaiu'), 'wtaiu-ip-addresses-panel' );
        $this->default_open_state = 'closed';
    }

    public function activate()
    {
        $this->find_public_ip();
    }

    public function find_public_ip()
    {
        /*
            The same script that runs ip.phplug.in is included in what-is-my-ip.php.
            If you don't want to use my IP finding site, you can use one of these alternatives.
                http://bot.whatismyipaddress.com/
                http://curlmyip.com/
                http://icanhazip.com/
        */
        $find_public_ip_url = apply_filters('wtaiu_find_public_ip_url', 'http://ip.phplug.in/' );

        $args = array(
            'user-agent' => sprintf(
                'WordPress/%s; What Template Am I Using/%s; %s',
                get_bloginfo( 'version' ),
                What_Template_Am_I_Using::VERSION,
                get_bloginfo( 'url' )
            )
        );

        $response = wp_remote_get( $find_public_ip_url, $args );

        if ( ! is_wp_error( $response ) ) {
            $ip = wp_remote_retrieve_body( $response );
            $ip = filter_var( $ip, FILTER_VALIDATE_IP );
            // The response body is expected to be a plain text IP address only.
            if ( $ip !== false  )
                update_site_option( 'wtaiu-server-ip', $ip );
            return $ip;
        }
        return false;
    }

    public function get_public_server_ip()
    {
        $ip = get_site_option( 'wtaiu-server-ip', '' );

        if ( $ip != '' )
            return $ip;

        $ip = $this->find_public_ip();

        if ( $ip !== false )
            return $ip;

        return 'unknown';
    }

    public function deactivate()
    {
        delete_site_option( 'wtaiu-server-ip' );
    }

    public function get_content()
    {
        $your_ip          = esc_html( $_SERVER['REMOTE_ADDR'] );
        $server_ip        = esc_html( $_SERVER['SERVER_ADDR'] );
        $dns_ip           = gethostbyname( $_SERVER['HTTP_HOST'] );
        $public_server_ip = $this->get_public_server_ip();

        $your_ip_label          = __('Your IP', 'wtaiu');
        $server_ip_label        = __('Server IP', 'wtaiu');
        $public_server_ip_label = __('Server Public IP', 'wtaiu');
        $dns_ip_label           = __('Domain IP (DNS)', 'wtaiu');

        $your_ip_title          = sprintf(__('This is %s', 'wtaiu'), '$_SERVER[\'REMOTE_ADDR\']') ;
        $server_ip_title        = sprintf(__('This is %s', 'wtaiu'), '$_SERVER[\'SERVER_ADDR\']') ;
        $public_server_ip_title = sprintf(__('This is the IP that you connect to when visiting %s', 'wtaiu'), $_SERVER['HTTP_HOST']) ;
        $dns_ip_title           = sprintf(__('DNS lookup for %s', 'wtaiu'), $_SERVER['HTTP_HOST']) ;

$info=<<<INFO

    <table class="info-table">
        <tbody>
            <tr>
                <th scope="row" title="{$your_ip_title}">{$your_ip_label}</th>
                <td>{$your_ip}</td>
            </tr>
            <tr>
                <th scope="row" title="{$server_ip_title}">{$server_ip_label}</th>
                <td>{$server_ip}</td>
            </tr>
            <tr>
                <th scope="row" title="{$public_server_ip_title}">{$public_server_ip_label}</th>
                <td>{$public_server_ip}</td>
            </tr>
            <tr>
                <th scope="row" title="{$dns_ip_title}">{$dns_ip_label}</th>
                <td>{$dns_ip}</td>
            </tr>
        </tbody>
    </table>

INFO;

        return $info;
    }
}

class WTAIU_Server_Variables_Panel extends WTAIU_Panel
{
    public function __construct()
    {
        parent::__construct( __('$_SERVER Variables', 'wtaiu'), 'wtaiu-server-variables-panel' );
        $this->default_open_state = 'closed';
    }

    public function get_content()
    {
        $info = array();
        $info[] = '<dl class="info-list">';
        foreach ( $_SERVER as $key => $value ) {
            $output = is_string($value) ? $value : print_r($value, true);
            $info[] = sprintf('<dt>%1$s</dt><dd>%2$s</dd>', $key, $output);
        }
        $info[] = '</dl>';
        return implode('', $info );
    }
}

class WTAIU_PHPInfo_Panel extends WTAIU_Panel
{
    const VERSION = '0.1.1';

    public function __construct()
    {
        parent::__construct( __('PHP Info', 'wtaiu'), 'php-info-panel' );
        $this->default_open_state = 'closed';
    }

    public function setup()
    {
        wp_enqueue_style('php-info-panel', plugins_url('/assets/css/php-info-panel.css', What_Template_Am_I_Using::FILE), array('wtaiu'), self::VERSION );
    }

    public function get_content()
    {
        ob_start();
        phpinfo();
        return str_replace(
            'border="0" cellpadding="3" width="600"',
            '',
            preg_replace(
                '#^.*<body>(.*)</body>.*$#ms',
                '$1',
                ob_get_clean()
            )
        );
    }
}
