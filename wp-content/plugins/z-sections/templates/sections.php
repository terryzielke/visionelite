<?php
/**
 * Template file for displaying Z-Sections content on the frontend.
 */
if ( ! isset( $z_sections_data ) || ! is_array( $z_sections_data ) ) {
    global $post;
    if ( $post ) {
        $z_sections_editor = get_post_meta( $post->ID, 'z_sections_editor', true );
        $z_sections_data = json_decode( $z_sections_editor, true );
        if ( ! is_array( $z_sections_data ) ) {
            $z_sections_data = []; // Ensure it's an array even if empty or invalid JSON
        }
    } else {
        $z_sections_data = [];
    }
}
// Don't output anything if no sections are found.
if ( empty( $z_sections_data ) ) {
    return;
}
?>

<div class="z-sections">

    <?php
    foreach ( $z_sections_data as $section ) :
        // Sanitize and set default values for section attributes
        $type = isset( $section['type'] ) ? sanitize_html_class( $section['type'] ) : 'full-width';
        $bg = isset( $section['bg'] ) ? esc_url( $section['bg'] ) : '';
        $id = isset( $section['id'] ) && ! empty( $section['id'] ) ? 'id="' . sanitize_title( $section['id'] ) . '"' : '';
        $class_attribute = isset( $section['class'] ) && ! empty( $section['class'] ) ?  $section['class'] : '';
        $full_width_class = ( isset( $section['fullWidth'] ) && $section['fullWidth'] ) ? ' full-viewer-width' : '';
        $collapse_class = ( isset( $section['collapse'] ) && $section['collapse'] ) ? ' collapse-spacing' : '';
        $reverse_class = ( isset( $section['reverse'] ) && $section['reverse'] ) ? ' section-reverse' : '';

        // Generate inline style for background image if set
        $bg_style = ! empty( $bg ) ? ' style="background-image: url(' . $bg . ');"' : '';

        // Combine all classes seperate each with a space
        $section_classes = 'z-section ' . esc_attr( $type ) . ' '. esc_attr( $class_attribute ) . $full_width_class . $collapse_class . $reverse_class;

        // --- Content Block Helper Function (to avoid repetition) ---
        // This function will render the common content elements for a column/section
        $render_content_block = function( $content_data ) {
	        
			global $wp_embed;

            $thumbnail_html = '';
            if ( ! empty( $content_data['smallImgLink'] ) ) {
                $thumbnail_html = '<div class="z-thumbnail"><img src="' . esc_url( $content_data['smallImgLink'] ) . '" alt="Thumbnail" /></div>';
            }
            
			$content_html = '';
			if ( ! empty( $content_data['wysiwygContent'] ) ) {
			    $raw_content = $content_data['wysiwygContent'];
			
			    if ( isset( $wp_embed ) && is_object( $wp_embed ) ) {
			        $embedded_content = $wp_embed->autoembed( $raw_content );
			        $embedded_content = do_shortcode( $embedded_content );
			        $embedded_content = preg_replace( '#<p>(\s*)(<iframe.*?</iframe>)(\s*)</p>#i', '$2', $embedded_content );
			    } else {
			        $embedded_content = do_shortcode( $raw_content );
			    }
			
			    $content_html = '<div class="z-content">' . $embedded_content . '</div>';
			    
			}

            $cta_html = '';
            if ( ! empty( $content_data['btnText'] ) && ! empty( $content_data['btnLink'] ) ) {
                $target = ( isset( $content_data['btnTarget'] ) && $content_data['btnTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
                $cta_html = '<div class="z-cta"><a href="' . esc_url( $content_data['btnLink'] ) . '"' . $target . '>' . esc_html( $content_data['btnText'] ) . '</a></div>';
            }
            return $thumbnail_html . $content_html . $cta_html;
        };
    ?>

    <section class="<?php echo $section_classes; ?>" <?php echo $id; ?> <?php echo $bg_style; ?>>
        <div class="z-container">
            <div class="row">

                <?php if ( $type === 'full-width' ) : ?>
                    <div class="col col-12 col-md-12">
                        <?php
                            $content_data = [
                                'smallImgLink'   => isset( $section['smallImgLink'] ) ? $section['smallImgLink'] : '',
                                'wysiwygContent' => isset( $section['wysiwygContent'] ) ? $section['wysiwygContent'] : '',
                                'btnText'        => isset( $section['btnText'] ) ? $section['btnText'] : '',
                                'btnLink'        => isset( $section['btnLink'] ) ? $section['btnLink'] : '',
                                'btnTarget'      => isset( $section['btnTarget'] ) ? $section['btnTarget'] : false,
                            ];
                            echo $render_content_block( $content_data );
                        ?>
                    </div>

                <?php elseif ( $type === 'columns' ) : ?>
                    <?php
                    $columns = isset( $section['columns'] ) && is_array( $section['columns'] ) ? $section['columns'] : [];
                    // responsive column classes based on the number of columns
                    $col_class = 'col col-12 col-md-6';
                    if ( count( $columns ) === 6 ) {
                         $col_class = 'col col-12 col-md-4 col-lg-2';
                    } elseif ( count( $columns ) === 5 ) {
                         $col_class = 'col col-12 col-md-6 col-lg-2';
                    } elseif ( count( $columns ) === 4 ) {
                         $col_class = 'col col-12 col-md-6 col-lg-3';
                    } elseif ( count( $columns ) === 3 ) {
                         $col_class = 'col col-12 col-md-4';
                    } elseif ( count( $columns ) === 2 ) {
                         $col_class = 'col col-12 col-md-6';
                    } elseif ( count( $columns ) === 1 ) {
                         $col_class = 'col col-12 col-md-12';
                    }
                    ?>
                    <?php if ( ! empty( $columns ) ) : ?>
                        <?php foreach ( $columns as $column ) : ?>
                            <div class="<?php echo esc_attr( $col_class ); ?> column-item">
                                <?php
                                    $col_content_data = [
                                        'smallImgLink'   => isset( $column['smallImgLink'] ) ? $column['smallImgLink'] : '',
                                        'wysiwygContent' => isset( $column['wysiwygContent'] ) ? $column['wysiwygContent'] : '',
                                        'btnText'        => isset( $column['btnText'] ) ? $column['btnText'] : '',
                                        'btnLink'        => isset( $column['btnLink'] ) ? $column['btnLink'] : '',
                                        'btnTarget'      => isset( $column['btnTarget'] ) ? $column['btnTarget'] : false,
                                    ];
                                    echo $render_content_block( $col_content_data );
                                ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php elseif ( $type === 'text-image' ) : ?>
                    <div class="col col-12 col-md-6 text-column">
                        <?php
                            $content_data = [
                                'smallImgLink'   => isset( $section['smallImgLink'] ) ? $section['smallImgLink'] : '',
                                'wysiwygContent' => isset( $section['wysiwygContent'] ) ? $section['wysiwygContent'] : '',
                                'btnText'        => isset( $section['btnText'] ) ? $section['btnText'] : '',
                                'btnLink'        => isset( $section['btnLink'] ) ? $section['btnLink'] : '',
                                'btnTarget'      => isset( $section['btnTarget'] ) ? $section['btnTarget'] : false,
                            ];
                            echo $render_content_block( $content_data );
                        ?>
                    </div>
                    <div class="col col-12 col-md-6 image-column">
                        <?php if ( ! empty( $section['largeImgLink'] ) ) : ?>
                            <div class="main-image">
                                <?php if ( preg_match( '/\.(m4v|mp4)$/i', $section['largeImgLink'] ) ) : ?>
                                    <video controls>
                                        <source src="<?php echo esc_url( $section['largeImgLink'] ); ?>" type="video/<?php echo pathinfo( $section['largeImgLink'], PATHINFO_EXTENSION ); ?>">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else : ?>
                                    <img src="<?php echo esc_url( $section['largeImgLink'] ); ?>" alt="Main Image" />
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php elseif ( $type === 'image-text' ) : ?>
                    <div class="col col-12 col-md-6 image-column">
                        <?php if ( ! empty( $section['largeImgLink'] ) ) : ?>
                            <div class="main-image">
                                <img src="<?php echo esc_url( $section['largeImgLink'] ); ?>" alt="Main Image" />
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col col-12 col-md-6 text-column">
                        <?php
                            $content_data = [
                                'smallImgLink'   => isset( $section['smallImgLink'] ) ? $section['smallImgLink'] : '',
                                'wysiwygContent' => isset( $section['wysiwygContent'] ) ? $section['wysiwygContent'] : '',
                                'btnText'        => isset( $section['btnText'] ) ? $section['btnText'] : '',
                                'btnLink'        => isset( $section['btnLink'] ) ? $section['btnLink'] : '',
                                'btnTarget'      => isset( $section['btnTarget'] ) ? $section['btnTarget'] : false,
                            ];
                            echo $render_content_block( $content_data );
                        ?>
                    </div>

                <?php elseif ( $type === 'shortcode' ) : ?>
                    <div class="col col-12 col-md-12">
                        <?php
                        if ( ! empty( $section['shortcode'] ) ) {
                            echo do_shortcode( wp_kses_post( $section['shortcode'] ) );
                        }
                        ?>
                    </div>

                <?php else : ?>
                    <div class="col col-12 col-md-12">
                        <p>Unknown section type: <?php echo esc_html( $section['type'] ); ?></p>
                    </div>
                <?php endif; ?>

            </div></div></section><?php endforeach; ?>

</div>
