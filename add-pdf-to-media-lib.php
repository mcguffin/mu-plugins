<?php

function modify_post_mime_types( $post_mime_types ) {

    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
    $post_mime_types['application/vnd.openxmlformats-officedocument.presentationml.presentation'] = array( __( 'Powerpoints' ), __( 'Manage Powerpoints' ), _n_noop( 'Powerpoints <span class="count">(%s)</span>', 'Powerpoints <span class="count">(%s)</span>' ) );
    $post_mime_types['application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document'] = array( __( 'Documents' ), __( 'Manage Documents' ), _n_noop( 'Documents <span class="count">(%s)</span>', 'Documents <span class="count">(%s)</span>' ) );

    return $post_mime_types;

}

add_filter( 'post_mime_types', 'modify_post_mime_types' );