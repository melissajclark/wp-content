<?php

abstract class WTAIU_Panel
{
    const VERSION = '0.0.0';

    protected $label;
    protected $id;

    protected $author;
    protected $author_url;

    protected $default_open_state;

    public function __construct( $label = '', $id = '' )
    {
        $this->author             = '';
        $this->author_url         = '';
        $this->label              = $label;
        $this->default_open_state = 'open';

        if ( $id != '' ) {
            $this->id = $id;
        } else {
            $this->id = $label != '' ? sanitize_title( 'panel-' . $label ) : uniqid('panel');
        }

        add_action('init', array( &$this, 'setup' ), 11 );
    }

    public function activate()
    {
        // save initial options here.
    }

    public function deactivate()
    {
        // remove options here.
    }

    public function can_show()
    {
        return true;
    }

    public function get_default_open_state()
    {
        return $this->default_open_state;
    }

    public function setup()
    {
        // do stuff here with actions
    }

    public function get_label()
    {
        return $this->label;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function info()
    {
        return array(
            'author'     => $this->author,
            'author_url' => $this->author_url,
            'version'    => $this->version
        );
    }

    public function render()
    {
        echo $this->get_content();
    }

    public function __toString()
    {
        return $this->get_content();
    }
    
    abstract public function get_content();

    public function get_help()
    {
        return '';
    }
}

abstract class WTAIU_Debug_Panel extends WTAIU_Panel
{
    public function can_show()
    {
        return defined('WP_DEBUG') && constant('WP_DEBUG') == true;
    }
}
