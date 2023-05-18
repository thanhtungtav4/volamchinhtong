<?php
function wpdocs_styles_method()
{
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/assets/css/custom_script.css'
    );

    $bghome = get_field('background_home', 'option');
    $bghomeSub = get_field('background_sub', 'option');

    $bgdefault = get_template_directory_uri() . '/assets/images/bg-summer-2022-2.jpg';
    $bghome = $bghome ? $bghome : $bgdefault;
    $bghomeSub = $bghomeSub ? $bghomeSub : $bgdefault;

    $custom_css = "
        body {
            background: #021533 url('$bghome') no-repeat center 0;
            font-family: 'Roboto Slab', serif;
        }
        body.subpage {
            background: #021533 url('$bghomeSub') no-repeat center 0;
        }
    ";

    wp_add_inline_style('custom-style', $custom_css);
}

add_action('wp_enqueue_scripts', 'wpdocs_styles_method');


