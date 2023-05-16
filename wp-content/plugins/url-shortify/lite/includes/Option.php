<?php

namespace Kaizen_Coders\Url_Shortify;

class Option {
    /**
     * @var string
     *
     * @since 1.0.0
     */
    static $prefix = 'kc_us_';

    /**
     * Get option
     *
     * @param string $option
     * @param string $default
     *
     * @return bool|mixed|void|null
     *
     * @since 1.0.0
     */
    public static function get( $option = '', $default = '' ) {

        if ( empty( $option ) ) {
            return null;
        }

        $option = self::$prefix . $option;

        return get_option( $option, $default );

    }

    /**
     * Set Option
     *
     * @param string $option
     * @param string $value
     * @param bool $autoload
     *
     * @return bool|null
     *
     * @since 1.0.0
     */
    public static function set( $option = '', $value = '', $autoload = true ) {

        if ( empty( $option ) ) {
            return null;
        }

        $option = self::$prefix . $option;

        return update_option( $option, $value, $autoload );
    }

    /**
     * Add Option
     *
     * @param string $option
     * @param string $value
     *
     * @return bool|null
     *
     * @since 1.0.0
     */
    public static function add( $option = '', $value = '', $autoload = false ) {

        if ( empty( $option ) ) {
            return null;
        }

        $option = self::$prefix . $option;

        return add_option( $option, $value, '', $autoload );

    }

    /**
     * Delete option
     *
     * @param string $option
     *
     * @return bool|null
     *
     * @since 1.0.0
     */
    public static function delete( $option = null ) {

        if ( empty( $option ) ) {
            return null;
        }

        $option = self::$prefix . $option;

        return delete_option( $option );
    }

}
