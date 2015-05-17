<?php
/**
 * Plugin Name: Hash Tracker
 * Description: Event scheduler and attendence tracker
 * Version: 0.0.1
 * Author: John Meuser
 * License: GPL2
 */

global $ht_db_version;
$ht_db_version = '0.0.1';

 function ht_install()
 {
    global $wpdb;
    global $ht_db_version;
    $charset_collate = $wpdb->get_charset_collate();

    $ht_hashers_table = $wpdb->prefix . "ht_hashers";
    $ht_hashers_sql = "CREATE TABLE $ht_hashers_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20),
        hasher_nerd_first varchar(20),
        hasher_nerd_last varchar(20),
        hasher_nerd_last varchar(20),
        hasher_name varchar(120),
        hasher_alias1 varchar(120),
        hasher_alias2 varchar(120),
        hasher_alias3 varchar(120),
        hasher_alias4 varchar(120),
        hasher_alias5 varchar(120),
        hasher_is_named boolean,
        UNIQUE KEY id (id)
    ) $charset_collate;";

    $ht_attendence_table = $wpdb->prefix . "ht_attendence";
    $ht_attendence_sql = "CREATE TABLE $ht_attendence_table (
        hasher_id bigint(20) NOT NULL AUTO_INCREMENT,
        hash_id bigint(20) NOT NULL AUTO_INCREMENT,
        attendence_type varchar(10) DEFAULT 'hound',
        UNIQUE KEY id (id)
    ) $charset_collate;";

    $ht_hashes_table = $wpdb->prefix . "ht_hashes";
    $ht_hashes_sql = "CREATE TABLE $ht_hashes_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        location_id bigint(20),
        post_id bigint(20),
        hash_num int(10),
        hash_title bigint(120),
        hash_start datetime,
        UNIQUE KEY id (id)
    ) $charset_collate;";

    $ht_locations_table = $wpdb->prefix . "ht_locations";
    $ht_locations_sql = "CREATE TABLE $ht_locations_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        loc_name varchar(50),
        loc_address varchar(20),
        loc_city varchar(20),
        loc_state char(2),
        loc_zip char(10),
        loc_lat decimal(10,7),
        loc_long decimal(10,7),
        UNIQUE KEY id (id)
    ) $charset_collate;";


    $sql = array(
        $ht_hashers_sql,
        $ht_attendence_sql,
        $ht_hashes_sql,
        $ht_locations_sql
    );

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'ht_db_version', $ht_db_version );
}

register_activation_hook( __FILE__, 'ht_install' );
