<?php

/*
Plugin Name: Enable Document Upload
Description: Allow uploading PDF, Presentations (pptx) and Documents (doc, docx)
Author: Jörn Lund
Author URI: http://github.org/mcguffin
Version: 0.0.1
*/

function enable_documents_upload( $post_mime_types ) {

    $post_mime_types['application/pdf'] = array( __( 'PDFs' , 'mu-plugins' ), __( 'Manage PDFs' , 'mu-plugins'), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' , 'mu-plugins') );
    $post_mime_types['application/vnd.openxmlformats-officedocument.presentationml.presentation'] = array( __( 'Presentations', 'mu-plugins' ), __( 'Manage Presentations', 'mu-plugins' ), _n_noop( 'Powerpoints <span class="count">(%s)</span>', 'Powerpoints <span class="count">(%s)</span>', 'mu-plugins' ) );
    $post_mime_types['application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document'] = array( __( 'Documents', 'mu-plugins' ), __( 'Manage Documents', 'mu-plugins' ), _n_noop( 'Documents <span class="count">(%s)</span>', 'Documents <span class="count">(%s)</span>', 'mu-plugins' ) );

    return $post_mime_types;

}

add_filter( 'post_mime_types', 'enable_documents_upload' );