<?php

/**
 * Description of tpl_widget
 *
 * @author Studio365
 * @subpackage Core-wp
 * @package WordPress
 */
class Sample_Widget extends WP_Widget {

    /**
     * Widget setup.
     */
    function Sample_Widget() {
        /* Widget settings. */
        $widget_ops = array('classname' => 'sample-widget', 'description' => __('Display...', 'recent-thumbs-widget'));

        /* Widget control settings. */
        //$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
        $control_ops = array('width' => '100%', 'height' => '100%', 'id_base' => 'recent-thumbs-widget');

        /* Create the widget. */
        $this->WP_Widget('sample-widget', __('Recent-Post(thumbs)', 'recent-thumbs-widget'), $widget_ops, $control_ops);
    }

    /**
     * Now to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title']);
        $page = $instance['page'];
        //$thumbs = $instance['thumbs'];
        $qty = $instance['qty'];
        $show_desc = $instance['desc'];
        $desc_words = $instance['desc_words'];
        //$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

        /* Before widget (defined by themes). */
        echo $before_widget;
        echo "<div class=\"recent-post-thumbs\" >";

        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title)
            echo $before_title . $title . $after_title;


        /* After widget (defined by themes). */
        echo "</div>";
        echo $after_widget;
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['page'] = strip_tags($new_instance['page']);
        //$instance['thumbs'] = strip_tags($new_instance['thumbs']);
        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array('title' => __('Recent Post', 'recent-thumbs-widget'), 'page' => '', 'qty' => 5, 'desc_words' => 10, 'desc' => 'OFF');
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'recent-thumbs-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo $instance['title']; ?>" style="width:90%;" />
        </p>

        <!-- Your Name: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Post Types:', 'recent-thumbs-widget'); ?></label>

            <select id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" style="width:90%;" >
                <option><?php echo $instance['page']; ?></option>
                <?php
                $args = array(
                    'public' => true,
                );
                $obj = 'objects';
                $pages = get_post_types($args, $obj);
                foreach ($pages as $value) {
                    echo "   <option value=\"{$value->name}\">{$value->name}</option>";
                }
                ?>
            </select>
        </p>

        <!-- Your Name: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('qty'); ?>"><?php _e('Quantity:', 'recent-thumbs-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('qty'); ?>" name="<?php echo $this->get_field_name('qty'); ?>"
                   value="<?php echo $instance['qty']; ?>" style="width:90%;"  />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('desc_words'); ?>"><?php _e('Description length:', 'recent-thumbs-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('desc_words'); ?>" name="<?php echo $this->get_field_name('desc_words'); ?>"
                   value="<?php echo $instance['desc_words']; ?>" style="width:90%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Show Title/desctiption:', 'recent-thumbs-widget'); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" value="ON" <?php echo ($instance['desc'] == 'ON') ? 'checked="checked"' : ''; ?> />

        </p>



        <?php
    }

}

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action('widgets_init', 'recent_thumbs_widgets');

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function recent_thumbs_widgets() {
    register_widget('Recent_thumbs_Widget');
}

add_image_size('recent-thumb', 80, 80, true);
add_image_size('recent-thumb-60', 60, 60, true);
add_image_size('recent-thumb-48', 48, 48, true);
