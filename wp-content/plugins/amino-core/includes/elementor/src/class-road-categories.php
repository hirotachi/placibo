<?php  
/**
 * RoadElementsCategory
 *
 * @author Roadthemes  
 */
final class RoadElementsCategory
{
    /**
     * Nope constructor
     */
    private function __construct()
    {

    }

    /**
     * Singleton
     */
    static function instance($return = false)
    {
        static $self = null;

        if (null === $self) {
            $self = new self;
            add_action('elementor/init', [$self, '_register'], 10, 0);
        }

        if ($return) {
            return $self;
        }
    }

    /**
     * Do registration
     *
     * @internal Used as a callback.
     */
    function _register()
    {
        $elementor = Elementor\Plugin::instance();

        $elementor->elements_manager->add_category('roadthemes-category', [
            'title' => __('Roadthemes', 'cafe'),
            'icon'  => 'fa fa-asterisk',
        ], 5);
    }
}

// Initialize.
RoadElementsCategory::instance();
