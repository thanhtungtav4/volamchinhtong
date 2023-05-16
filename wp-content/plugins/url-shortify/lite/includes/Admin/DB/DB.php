<?php

namespace Kaizen_Coders\Url_Shortify\Admin\DB;

/**
 * class
 *
 * @since 1.0.0
 */
class DB {
    /**
     *
     * @var Object|Links
     *
     * @since 1.0.0
     *
     */
    public $links;

    /**
     * @var Object|Clicks
     *
     * @since 1.0.0
     */
    public $clicks;

    /**
     * @var Object|Groups
     *
     * @since 1.1.3
     */
    public $groups;

    /**
     * @var Object|Links_Groups
     *
     * @since 1.1.3
     */
    public $links_groups;

    /**
     * @var Object|Domains
     */
    public $domains;

    /**
     * @var Object|UTM_Presets
     */
    public $utm_presets;


    /**
     * constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->clicks       = new Clicks();
        $this->links        = new Links();
        $this->groups       = new Groups();
        $this->links_groups = new Links_Groups();
        $this->domains      = new Domains();
        $this->utm_presets  = new UTM_Presets();
    }
}
